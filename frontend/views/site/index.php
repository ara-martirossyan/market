<?php

use \yii\bootstrap\Modal;
use kartik\social\FacebookPlugin;
use \yii\bootstrap\Collapse; 
use \yii\bootstrap\Alert;
use yii\helpers\Html;
use common\models\RecordHelpers;

/* @var $this yii\web\View */
$this->title = 'Market'; 
?>
<div class="site-index">

    <div class="jumbotron">
         
        <h1>Market <i class="fa fa-shopping-cart"></i></h1>
        <p class="lead">
        <?php if (Yii::$app->user->isGuest) { 
            echo Html::a('Register', ['site/signup'], ['class' => 'btn btn-lg btn-success'])."<br>".
                "Get registered as a user";
        }elseif(!(Yii::$app->user->isGuest) && !RecordHelpers::userHas("profile")){
            echo Html::a('Create profile', ['profile/create'], ['class' => 'btn btn-lg btn-success'])."<br>"
                    .Yii::$app->user->identity->username.", create your profile please.";
        } 
        ?>
        </p>
        

        
        
        <br/>

        <?= FacebookPlugin::widget(['type'=>FacebookPlugin::LIKE, 'settings' => []]); ?>


    </div>
    

    
    <br/> 
    <br/> 
 
    
    <div class="body-content">
        <div class="row">
 
            
            </div> 
    </div>
</div>





                    





        


            



                     









</div>
