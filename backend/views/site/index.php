<?php

   use yii\helpers\Html; 
   use common\models\ValueHelpers;
   
   /*
    *  @var yii\web\View $this
    */
   
   $this->title = 'Admin Market';
   
   $is_admin = ValueHelpers::getRoleValue('Admin');

?>
<div class="site-index">

    <div class="jumbotron">
        <h1><i class="fa fa-gears"></i> Admin Panel</h1>

        <p class="lead">Manage The Databases Of The Market</p>

       
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Users <i class="fa fa-users"></i></h2>

                <p>This is the place to manage users. You can edit status and roles from here. 
                    The UI is easy to use and intuitive, just click the link below to get started.</p>

                <p>
                    <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Manage Users', ['user/index'], ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Roles <i class="glyphicon glyphicon-pawn"></i></h2>

                <p>This is where you manage Roles. You can decide who is admin and who is not.
                    You can add a new role if you like, just click the link below to get started.</p>

                <p>
                    <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Manage Roles', ['role/index'], ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Profiles <i class="glyphicon glyphicon-user"></i></h2>

                <p>Need to review Profiles? This is the place to get it done. These are easy to manage via UI. 
                    Just click the link below to manage profiles.</p>

                <p>
                    <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Manage Profiles', ['profile/index'], ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4">
                <h2>User Types <i class="fa fa-credit-card"></i></h2>

                <p>This is the place to manage user types. You can edit user types from here. The UI is easy to use and intuitive,
                    just click the link below to get started.</p>

                <p>
                    <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Manage User Types', ['user-type/index'], ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Statuses <i class="fa fa-ban"></i></h2>

                <p>This is where you manage Statuses. You can add or delete. You can add a new status if you like, 
                    just click the link below to get started.</p>

                <p>
                    <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Manage Statuses', ['status/index'], ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
            <div class="col-lg-4">
                <!--empty space-->
            </div>
        </div>
        <hr>
        
        <div class="row">
            <div class="col-lg-4">
                <h2>Firms</h2>

                <p>This is the place to manage Firms. You can edit the firms you are dealing with from here. 
                    Just click the link below to get started.</p>

                <p>
                    <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Manage Firms', ['firms/index'], ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Reports</h2>

                <p>This is where you manage Reports. 
                    Just click the link below to get started.</p>

                <p>
                    <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Manage Reports', ['reports/index'], ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Goods</h2>

                <p>This is where you manage the list of goods. Just click the link below to get started.</p>

                <p>
                    <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Manage Goods', ['goods/index'], ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
        </div>
        
        

    </div>
</div>
