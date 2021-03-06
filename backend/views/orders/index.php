<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Orders', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'firm_id',
                'value' => function($model) {
                    $firm = backend\models\Firms::findOne($model->firm_id);
                    return $firm->name;
                },
            ],
            'price_with_vat',
            'price_without_vat',
            'increment_price',
            'total_goods',
            'total_types',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
