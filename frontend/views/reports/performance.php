<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Performance';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
               'attribute' => 'month',
               'value' => function($model) {
                  $timestamp = mktime(0, 0, 0, $model->month, 1);
                  $monthName = date('F', $timestamp );
                  return $monthName;
                },
            ],            
            [
               'attribute' => 'totalRevenue',
               'value' => function($model) {
                return number_format($model->totalRevenue);
                },
            ],
          
            [
               'attribute' => 'averageSalaryPerDay',
               'value' => function($model) {
                return number_format($model->averageSalaryPerDay,4);
                },
            ],       
            'numberOfWorkedDays',
            
            [
               'attribute' =>  'totalSalary',
               'value' => function($model) {
                return number_format($model->totalSalary);
                },
            ],
        
           
            


          
        ],
    ]); ?>

