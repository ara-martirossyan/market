<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReportsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reports-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'revenue') ?>

    <?= $form->field($model, 'expense_on_goods') ?>

    <?= $form->field($model, 'other_expenses') ?>

    <?= $form->field($model, 'salary') ?>

    <?php // echo $form->field($model, 'day_type') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
