<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Firms */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Firms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firms-view">

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
            'tel',
           /* [
               'attribute' => 'tel',
               'value' => $model->tel!= "" ? "(". substr($model->tel,0,2).") ".substr($model->tel,2,3)."-".substr($model->tel,5,2)."-".substr($model->tel,7,2): "",                                                                                                            
             ],*/
            
            'email:email',
            'address',
        ],
    ]) ?>

</div>
