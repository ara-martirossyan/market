
<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use yii\widgets\ActiveForm;

use yii\widgets\Pjax;

//use yii\bootstrap\Nav ;

/* @var $this yii\web\View */
/* @var $currentmonth is current month number*/
/* @var $currentyear is current year like 2015*/
/* @var $fromYear lower limit of year interval*/
/* @var $untilYear upper limit of year interval*/
/* @var $searchModel frontend\models\search\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => 'Performance', 'url' => ['performance']];

$month = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemeber", "December"];
?>
<div class="reports-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(' Add Report', ['create'], ['class' => 'fa fa-plus btn btn-default']) ?>
    </p>



</div>




<div class="tabbable boxed parentTabs">
    <ul class="nav nav-tabs">
        
        <br><br><br>
        <?php
        for ($y = $fromYear; $y <= $untilYear; ++$y) {
            ?>
            <li class=<?= $y == $currentyear ? " active" : ""; ?> ><a href="#set<?= $y; ?>"><?= $y; ?></a>
            </li>
        <?php } ?>
            
    </ul>
    <div class="tab-content">
        
        <?php
        for ($y = $fromYear; $y <= $untilYear; ++$y) {
            ?>
        
        <div class="tab-pane fade <?= $y == $currentyear ? "active in" : "";?>" id="set<?= $y;?>">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    
                    <?php
                    for ($m = 1; $m <= 12; ++$m) {
                    ?>
                    <li class=<?= $m == $currentmonth ? " active" : ""; ?> ><a href="#sub<?= $y;?><?= $month[$m]; ?>" ><?= $month[$m]; ?></a>
                    </li>
                    <?php } ?>
                    
                </ul>
                <div class="tab-content">                    
                    
                    <?php
                    for ($m = 1; $m <= 12; ++$m) {
                    ?>
                        <div class="tab-pane fade <?= $m == $currentmonth ? "active in" : ""; ?>" id="sub<?= $y; ?><?= $month[$m] ?>">
                                
                                <br>

                                <p>
                                    <?php // Html::a('Export to Excel', ["/reports/export?month=$m"], ['class' => 'btn btn-success']) ?>
                                </p>
                                <br>                                    
                                <?php  Pjax::begin(); ?>
                                <?=
                                //   echo '<pre>'; var_dump($dataProviderMonthly[$m]); echo '</pre>'; die();
                                 GridView::widget([
                                    'dataProvider' => $dataProvider[$y][$m],
                                    'filterModel' => $searchModel[$y][$m],
                                    'rowOptions' => function($model) {
                                        if ($model->date == " ") {
                                            // return ['class' => 'success', ];
                                            return ['style' => ' color:white; background-color:#BDBDBD; font-family:"Comic Sans MS"; '];
                                        }
                                    },
                                            'columns' => [

                                                /* [ 
                                                  'class' => 'yii\grid\SerialColumn',

                                                  ], */
                                                [ //instead of serial column
                                                    'attribute' => '#',
                                                    'contentOptions' => ['style' => 'width: 50px;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model, $index, $key) {
                                                if ($model->date == " ") {
                                                    return "Total";
                                                } else {
                                                    return ++$key; // ++ dnum enq vor 0-ic chsksi hamarakalumy
                                                }
                                            },
                                                ],
                                                
                                                [
                                                   'attribute' => 'user',
                                                   'value' => function($model) {
                                                     if ($model->date == " ") {
                                                       return " ";
                                                     } else {
                                                       $user_id = $model->user_id;
                                                       return common\models\User::findIdentity($user_id)->username;
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
                                                   'attribute' => 'expense_on_goods',
                                                   'value' => function($model) {
                                                      return number_format($model->expense_on_goods);
                                                   },
                                                ],
                                                [
                                                   'attribute' => 'other_expenses',
                                                   'value' => function($model) {
                                                      return number_format($model->other_expenses);
                                                   },
                                                ],
                                                [
                                                   'attribute' => 'salary',
                                                   'value' => function($model) {
                                                      return number_format($model->salary);
                                                    },
                                                ],
                                                [
                                                   'attribute' => 'day_type',
                                                   'value' => function($model) {
                                                      if ($model->date == " ") {
                                                        return " ";
                                                      } else {
                                                        return ($model->day_type ? "Working day" : "Non-working day" );
                                                      }
                                                    },
                                                   'filter' => [1 => 'Working', 0 => 'Non-wrking day'],
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
                                                    'contentOptions' => ['style' => 'width: 50px;'],
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
                                <?php  Pjax::end(); ?>



                        </div>
                    <?php } ?>
                    
                </div>
            </div>
        </div>
            
        <?php } ?>
        

    </div>
</div>