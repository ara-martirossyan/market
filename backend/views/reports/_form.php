<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Reports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reports-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'revenue')->textInput() ?>

    <?= $form->field($model, 'expense_on_goods')->textInput() ?>

    <?= $form->field($model, 'other_expenses')->textInput() ?>

    <?= $form->field($model, 'salary')->textInput() ?>

    <?= $form->field($model, 'day_type')->dropDownList([1=>'Working day',0=>'Non-working day'], [ 'prompt' => 'Choose the day type']) ?>

    <?= $form->field($model, 'date')->widget(DatePicker::className(),['clientOptions' => ['defaultDate' => date("Y-m-d")],'dateFormat' => 'yyyy-MM-dd']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Send Report' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
