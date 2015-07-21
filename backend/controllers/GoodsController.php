<?php

namespace backend\controllers;

use common\models\PermissionHelpers;

use Yii;
use backend\models\Goods;
use backend\models\search\GoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;




//use app\models\ActiveDataProvider;




/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{
    public function behaviors()
    {
                return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view','create', 'update', 'delete'], 
                'rules' => [ 
                [
                    'actions' => ['index', 'view',],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                     return PermissionHelpers::requireMinimumRole('Admin')
                             && PermissionHelpers::requireStatus('Active');
                    }
                ],
                [
                    'actions' => [ 'update', 'delete', 'create'],
                    'allow' => true, 'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) { 
                     return PermissionHelpers::requireMinimumRole('SuperUser') 
                             && PermissionHelpers::requireStatus('Active');
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
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {                 
        $goods = new Goods();          
        $searchModel = $goods->firmList;// for each key = firm_id => value =  searchModel obj
        $dataProvider = [];
        
        foreach ($searchModel as $key => $value) {
                $searchModel[$key] = new GoodsSearch();
                $searchModel[$key]->firm_id = $key;
                $dataProvider[$key] = $searchModel[$key]->search(Yii::$app->request->queryParams, $key);
        }
   
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'activeTab' => $goods->firstKeyOfFirm,
            'firmList' => $goods->firmList,        
            
        ]);
    }

    /**
     * Displays a single Goods model.
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
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();
        $model->is_active = true;       
            
            if ( $model->load(Yii::$app->request->post()) )
            {     
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);              
            }
            else 
            {
               return $this->render('create', ['model' => $model,]);
            }
        
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id); 
        $oldFile = $model->picture;        
        if ( $model->load(Yii::$app->request->post()) ) {
          //because after load function $model->picture = ""
          $model->picture = $oldFile;          
          $model->save();
          return $this->redirect(['view', 'id' => $model->id]);
        }else{
            return $this->render('update', ['model' => $model,]);
        }
    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id); 
        \common\models\UploadHelpers::deleteFile($model->picture, Yii::$app->basePath.'/web/uploads');
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    

}
