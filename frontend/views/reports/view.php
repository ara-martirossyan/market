<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */
/* @var $day int */



$this->title = $day;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Day nr.".$this->title;
?>
<div class="reports-view">

    <h1><?= Html::encode("Working day nr.".$this->title) ?></h1>

    <p>
        <?php
        $report_max_id = common\models\Reports::find()->max('id');
        if ($model->id == $report_max_id) {
            echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) . " " .
            Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
         
        'attributes' => [
            'id',
            'user.username',
             [
               'attribute' => 'revenue',
               'value' => number_format($model->revenue),                                                                                                               
             ],
             
             [
               'attribute' => 'salary',
               'value' => number_format($model->salary),                                                                                                               
             ],            
             [
               'attribute' => 'day_type',
               'value' => $model->day_type ? "Working day": "Non-working day"  ,                 
             ],   
             [
               'attribute' => 'date',
               'value' => Yii::$app->formatter->asDate("$model->date", "php:d/m/Y") ,                 
             ], 
            /* [
               'attribute' => 'created_at',
               'value' => Yii::$app->formatter->asDatetime("$model->create_date", "php:d/m/Y H:i:s") ,                 
             ],*/

        ],
    ]) ?>

</div>
