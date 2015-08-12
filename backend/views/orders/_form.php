<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'firm_id')->dropDownList( ArrayHelper::map(backend\models\Firms::find()->all(), 'id', 'name'), ['prompt' => 'Choose Firm'] ) ?> 

    <?= $form->field($model, 'price_with_vat')->textInput() ?>

    <?= $form->field($model, 'price_without_vat')->textInput() ?>

    <?= $form->field($model, 'increment_price')->textInput() ?>

    <?= $form->field($model, 'total_goods')->textInput() ?>

    <?= $form->field($model, 'total_types')->textInput() ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
