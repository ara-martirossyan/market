<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $class is current month number*/
/* @var $searchModel app\models\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => 'Performance', 'url' => ['performance']];
?>
<div class="reports-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Make Report', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



</div>

<div class="panel-heading">
    <ul class="nav nav-tabs">
        <?php
        $month = array("", "January", " February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemeber", "December");
        for ($m = 1; $m <= 12; ++$m) {
            ?>
            <li class=<?= $m == $class ? " active" : ""; ?> ><a href="#tab<?= $m; ?>" data-toggle="tab"><?= $month[$m]; ?></a></li>
        <?php } ?>

    </ul>
</div>
<div class="panel-body">
    <div class="tab-content">

        <?php
        for ($m = 1; $m <= 12; ++$m) {
            ?>
        <div class="tab-pane fade in <?= $m == $class ? " active" : ""; ?>" id="tab<?= $m; ?>">                
                <p>
                    <?= Html::a('Export to Excel', ["/reports/export?month=$m"], ['class' => 'btn btn-success']) ?>
                </p>
                <br>                                    

                <?=
                //   echo '<pre>'; var_dump($dataProviderMonthly[$m]); echo '</pre>'; die();
                GridView::widget([
                    'dataProvider' => $dataProviderMonthly[$m],
                    'filterModel' => $searchModel,  
                    'rowOptions' => function($model) {
                        if ($model->date == " ") {
                            // return ['class' => 'success', ];
                            return ['style' => ' color:white; background-color:#BDBDBD; font-family:"Comic Sans MS"; '];
                        }
                    },
                            'columns' => [

                               /* [ 
                                    'class' => 'yii\grid\SerialColumn',
                                    
                                ],*/
                                [ //instead of serial column
                                    'attribute' => '#',
                                    'contentOptions'=>['style'=>'width: 50px;'],
                                    'format' => 'raw',
                                    'value' => function ($model,  $index, $key) {
                                        if ($model->date == " ") {
                                            return "Total";
                                        } else {
                                            return ++$key;// ++ dnum enq vor 0-ic chsksi hamarakalumy
                                        }
                                    },
                                ],                               
                                
                                [
                                    'attribute' => 'revenue',
                                    'value' => function($model) {
                                        return number_format($model->revenue);
                                    },
                                ],          
                                            
                                [
                                    'attribute' => 'date',
                                    'value' => function($model) {
                                        if ($model->date == " ") {
                                            return " ";
                                        } else {
                                            return Yii::$app->formatter->asDate("$model->date", "php:d/m/Y");
                                        }
                                    },
                                ],       
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'contentOptions'=>['style'=>'width: 50px;'],
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            return $model->date !== " " ?
                                                    Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                                        'title' => Yii::t('app', 'View'),
                                                        'data-pjax' => '0'
                                                    ]) : '';
                                        },
                                                'update' => function ($url, $model) {
                                            $orders_max_id = common\models\Reports::find()->max('id');
                                            if ($model->id == $orders_max_id && $model->date !== " ") {
                                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                                            'title' => Yii::t('app', 'Update'),
                                                            'data-pjax' => '0'
                                                                ]
                                                );
                                            } else {
                                                return "";
                                            }
                                        },
                                                'delete' => function ($url, $model) {
                                            $orders_max_id = common\models\Reports::find()->max('id');
                                            if ($model->id == $orders_max_id && $model->date !== " ") {
                                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                                            'title' => Yii::t('app', 'Delete'),
                                                            'data-pjax' => '0',
                                                            'data-method' => 'post',
                                                            'data-confirm' => 'Are you sure, you want to delete this item?'
                                                                ]
                                                );
                                            } else {
                                                return "";
                                            }
                                        }
                                            ],
                                        ],
                                    ],
                                ]);
                                ?>                                            
                            </div>
                        <?php } ?>


    </div>
</div>
