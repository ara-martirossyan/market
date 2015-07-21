<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Goods */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            [
               'attribute' => 'price_with_vat',
               'value' => number_format($model->price_with_vat),                                                                                                               
             ],
            [
               'attribute' =>  'price_without_vat',
               'value' => number_format($model->price_without_vat),                                                                                                               
             ],
            [
               'attribute' => 'increment_price',
               'value' => number_format($model->increment_price),                                                                                                               
             ],         
            [
               'attribute' => 'percentage',
               'value' => $model->percentage . " %",                                                                                                               
             ],
            'firm.name',
            'expiration_date',
             [
               'attribute' =>  'is_active',
               'value' => $model->is_active ? "active": "inactive"  ,                 
             ],
             [
               'attribute' =>  'picture',
               'value'=> Yii::$app->request->BaseUrl.'/uploads/'.$model->picture,
               'format' => ['image',['width'=>'100','height'=>'100']],
             ],
        ],
    ]) ?>

</div>
