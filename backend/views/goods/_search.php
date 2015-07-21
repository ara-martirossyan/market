<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GoodsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'price_with_vat') ?>

    <?= $form->field($model, 'price_without_vat') ?>

    <?php  echo $form->field($model, 'increment_price') ?>

    <?php  echo $form->field($model, 'percentage') ?>

    <?php  echo $form->field($model, 'firm_id') ?>

    <?php  echo $form->field($model, 'expiration_date') ?>

    <?php  echo $form->field($model, 'is_active') ?>
    
    
    
    <?php  //echo $form->field($model, 'grid') ?>

    <?php // echo $form->field($model, 'picture') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
