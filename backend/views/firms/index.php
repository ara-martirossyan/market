<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\FirmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Firms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firms-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Firm', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description:ntext',
            /*[
                'attribute' => 'tel', 
                'value' => function($model)
                           {
                              $d = "$model->tel";
                              return $d != "" ? "(". substr($d,0,2).") ".substr($d,2,3)."-".substr($d,5,2)."-".substr($d,7,2): "";
                           }
                
            ],*/
            'tel',
            'email:email',
            'address',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
