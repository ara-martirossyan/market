<?php

namespace backend\controllers;

use Yii;
use backend\models\Orders;
use backend\models\search\OrdersSearch;
use backend\models\OrderItems;

use backend\models\Goods;
use backend\models\search\GoodsSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermissionHelpers;





/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'goods-order-list', 'submitted-orders-by-ajax'],
                'rules' => [
                    [
                        'actions' => ['index', 'view',],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return PermissionHelpers::requireMinimumRole('Admin') &&
                                   PermissionHelpers::requireStatus('Active');
                        }
                    ],
                    [
                        'actions' => [ 'update', 'delete', 'create', 'goods-order-list', 'submitted-orders-by-ajax'],
                        'allow' => true, 'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return PermissionHelpers::requireMinimumRole('SuperUser') && 
                                   PermissionHelpers::requireStatus('Active');
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
         
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {        
        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {   /*WARNING
     * after updating the last record
     * the state table should be also updated
     * wich is not done yet
     */
        $orders_max_id = \backend\models\Orders::find()->max('id');
        $state_max_id = \backend\models\State::find()->max('id');
        $state_model_with_max_id = \backend\models\State::findOne($state_max_id);

        if ($id == $orders_max_id && $state_model_with_max_id->output == 0) {

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        } else {
            throw new \yii\web\ForbiddenHttpException('You can NOT update this order! '
            . 'Please, contact the Admin for more information.');
        }
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $orders_max_id = \backend\models\Orders::find()->max('id');
        $state_max_id = \backend\models\State::find()->max('id');
        $state_model_with_max_id = \backend\models\State::findOne($state_max_id);
        /*
         * if $state_model_with_max_id->output == 0 , 
         * then the last model in the state table is an order
         * otherwise it would have been a report
         */
        if ($id == $orders_max_id && $state_model_with_max_id->output == 0) {
            /*TRANSACTION*/
            $ordersItems = \backend\models\OrderItems::find()->where(['order_id' => $id])->all();
            //delete order items, then delete the order itself and then delete the last state model 
            foreach ($ordersItems as $ordersItem) {
                $ordersItem->delete();
            } 
            $this->findModel($id)->delete();            
            $state_model_with_max_id->delete();
            /* TRANSACTION*/
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\ForbiddenHttpException('You can NOT delete this order! '
            . 'Please, contact the Admin for more information.');
        }
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
   /**
    * Lists Goods to order
    * @return type
    */
    public function actionGoodsOrderList()
    {                 
        $goods = new Goods();          
        $searchModel = $goods->firmList;// for each key = firm_id => value =  searchModel obj
        $dataProvider = [];
        
        foreach ($searchModel as $key => $value) {
                $searchModel[$key] = new GoodsSearch();
                $searchModel[$key]->firm_id = $key;
                $dataProvider[$key] = $searchModel[$key]->search(Yii::$app->request->queryParams, $key);
        }
   
        return $this->render('goods-order-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'activeTab' => $goods->firstKeyOfFirm,
            'firmList' => $goods->firmList,        
            
        ]);
    }

    /**
     * Ajax
     */    
    public function actionSubmittedOrdersByAjax() {
        if (Yii::$app->request->isAjax) {
            /* Yii::$app->request->post() = {goodsID : quantity} */
            $goodsIdList = Yii::$app->request->post();
            if (!empty($goodsIdList)) {
                $orderID = Orders::saveOrder($goodsIdList);
                OrderItems::saveOrderItems($orderID, $goodsIdList);

                $link = \Yii::$app->homeUrl . '/index.php?r=orders/view&id=' . $orderID;
                $data = array('status' => 'ok', 'link' => $link);
                echo \yii\helpers\Json::encode($data);
            } else {
                $data = array('status' => 'unok');
                echo \yii\helpers\Json::encode($data);
            }
        }
    }    
    
    
}

