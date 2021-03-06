<?php

use yii\grid\GridView;

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel  array of backend\models\GoodsSearch */
/* @var $dataProvider array of  yii\data\ActiveDataProvider */
/* @var $activeTab integer */
/* @var $firmList array */


$this->title = 'Select Order';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel-heading">
    <ul class="nav nav-tabs">
        <?php
        foreach ($firmList as $key => $value) {
            ?>
            <li class=<?= $key == $activeTab ? " active" : ""; ?> ><a href="#tab<?= $key; ?>" data-toggle="tab"><?= $value; ?></a></li>
        <?php } ?>

    </ul>
</div>
<div class="panel-body">
    <div class="tab-content">

<?php
foreach ($firmList as $key => $value) {
    ?>
          
            <div class="tab-pane fade in <?= $key == $activeTab ? " active" : ""; ?>" id="tab<?= $key; ?>">
                
            <p>            
                <button  id="submit_order<?= $key?>" class ='btn btn-success'>send order</button>
            </p> 
            
            <?php  Pjax::begin(); ?>            
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider[$key],
                'filterModel' => $searchModel[$key],
                'id' => 'grid'.$key,
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',                        
                    ],
                    [
                        'attribute' => 'Quantity',
                        'format' => 'raw',
                        'value' => function ($model) {
                        return '<div>'
                                 . '<input '
                                    . 'type="number" '
                                    . 'min="1" '
                                    . 'max="100" '
                                    . 'step="1" '
                                    . 'value="1" '
                                    . 'style = "width: 3em;"'
                                 . '>'
                             . '</div>';
                        },
                    ],
                    [ 'class' => 'yii\grid\SerialColumn',],                 
                    'id', 
                    'name',
                    'description',
                    [
                        'attribute' => 'price_with_vat',
                        'value' => function($model) {
                            return number_format($model->price_with_vat);
                        },                        
                    ],
                    [
                        'attribute' => 'price_without_vat',
                        'value' => function($model) {
                            return number_format($model->price_without_vat);
                        },
                    ],
                    [
                        'attribute' => 'increment_price',
                        'value' => function($model) {
                            return number_format($model->increment_price);
                        },
                    ],
                    'percentage',                     
                    [
                        'attribute' => 'firm_id',
                        'value' => function($model) {
                            return $model->firm_id;
                        },
                       'contentOptions' => ['style' => "display:none"],
                       'headerOptions' =>  ['style' => "display:none"],
                       'filterOptions' =>  ['style' => "display:none"],
                    ],
                    'expiration_date', 
                    [
                        'attribute' => 'is_active',                        
                        'value' => function($goodsrow){ return ($goodsrow->is_active ? "active": "inactive" ); },
                        'filter' => [1 => 'active', 0 => 'inactive'] , 
                    ], 
                    [
                        'format' => ['image', ['width' => '100', 'height' => '100']],
                        'value' => function($data) {
                            return Yii::$app->request->BaseUrl . '/uploads/' . $data->picture;
                        },
                        'header' => 'picture',
                        'headerOptions' => ['style'=>'text-align:center'],
                    ],
                ],
            ]);
            ?>
            
            <?php  Pjax::end(); ?>
                
            </div>
            <?php } ?>


    </div>
</div>




