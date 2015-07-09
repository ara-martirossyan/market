<?php

namespace frontend\controllers;

use Yii;
use common\models\Reports;
use frontend\models\search\ReportsSearch;
use common\models\PermissionHelpers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use arturoliveira\ExcelView;

/**
 * ReportsController implements the CRUD actions for Reports model.
 */
class ReportsController extends Controller
{
    public function behaviors()
    {
                return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view','create', 'update', 'delete', 'performance'], 
                'rules' => [ 
                [
                    'actions' => ['index', 'view','update', 'delete', 'create', 'performance'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                     return PermissionHelpers::requireMinimumRole('User')
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
     * Lists all Reports models.
     * @return mixed
     */
    public function actionIndex()
    {
        $fromYear = 2014;
        $untilYear = 2021;

       $searchModel = [];
       $dataProvider = [];

       
        for($y = $fromYear; $y <= $untilYear; ++$y){
            for($m = 1; $m <= 12; ++$m){
                  $searchModel[$y][$m] = new ReportsSearch();
                  $dataProvider[$y][$m] = $searchModel[$y][$m]->search($y, $m, Yii::$app->request->queryParams);
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'currentmonth'=> date('n'),
            'currentyear' => date('Y'),
            'fromYear'  => $fromYear,
            'untilYear' => $untilYear,
            
        ]);
        
       
    }

    /**
     * Displays a single Reports model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {     
        $model = $this->findModel($id);
        $day = $this->dayNumberOfReport($id);      

        return $this->render('view', [
            'model' => $model,
            'day' => $day,
        ]);
    }

    /**
     * Creates a new Reports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reports();
        //in case of the user, the working or non-working day type is inserted by default 1(working day)
        $model->day_type = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Reports model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $report_max_id = Reports::find()->max('id');
        //$state_max_id = \app\models\State::find()->max('id');
        //$state_model_with_max_id = \app\models\State::findOne($state_max_id);

        if ($id == $report_max_id /* && $state_model_with_max_id->input == 0*/) {

            $model = $this->findModel($id);
            $day = $this->dayNumberOfReport($id); 
            
            if ($model->load(Yii::$app->request->post()) && $model->save()) {             
                
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                            'day' => $day,
                ]);
            }
        }else{
             throw new \yii\web\ForbiddenHttpException('You can NOT update this report! '                                                 
                                                 . 'Please, contact the Admin for more information.');
        }
    }

    /**
     * Deletes an existing Reports model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $report_max_id = Reports::find()->max('id');
        //$state_max_id = \app\models\State::find()->max('id');
       // $state_model_with_max_id = \app\models\State::findOne($state_max_id);
        /*
         * if $state_model_with_max_id->input == 0 , 
         * then the last model in the state table is a report
         * otherwise it would have been an order
         */
        if ( $id == $report_max_id /*&& $state_model_with_max_id->input == 0*/) {
            /*
             * TRANSACTION
             */
            $this->findModel($id)->delete();
           // $state_model_with_max_id->delete();
            /*
             * TRANSACTION
             */
            return $this->redirect(['index']);
        }else{
             throw new \yii\web\ForbiddenHttpException('You can NOT delete this report! '                                                 
                                                 . 'Please, contact the Admin for more information.');
        }
    }
    
    public function actionPerformance() {
        $searchModel = new ReportsSearch();
        $dataProvider = $searchModel->searchPerformance();
        
        return $this->render('performance', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Reports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reports::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * day number coincides with the 
     * serial number of the GridView::widget
     * @param type $id
     * @return type int
     */
    private function dayNumberOfReport($id)
    {
        $model = $this->findModel($id);
        $time = strtotime($model->date);
        $month = date('n', $time);
        $year = date('Y', $time);
        $list = ReportsSearch::listOfReportsIDbyCurrentUser($year, $month);
        foreach ($list as $key => $value) {
           if($value == $id){
           $day = $key + 1;}
        }  
        
        return $day;
    }


    /*
     * to export excel monthly
     
    public function actionExport($month) {
        $model = new Reports();
        $dataProviderMonthly = $model->getDataProviderMonthly();
        ExcelView::widget([
            'dataProvider' => $dataProviderMonthly[$month],
           // 'filterModel' => $searchModel,
            'fullExportType'=> 'xlsx', //can change to html,xls,csv and so on
            'grid_mode' => 'export',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'revenue',
                'expense_on_goods',
                'other_expenses',
                'salary',
                'day_type',
                'date',
                'create_date',
            ],
        ]);
    }
     * 
     */
}
