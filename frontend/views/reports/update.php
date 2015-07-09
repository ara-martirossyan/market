<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Reports */


$this->title = 'Update Report of day '.$day;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'day nr.'.$day, 'url' => ['view', 'id' => $model->id]];

?>
<div class="reports-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
