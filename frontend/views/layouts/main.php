<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\widgets\Alert;

use frontend\assets\AppAsset;
use frontend\assets\FontAwesomeAsset;
use frontend\assets\NestedTabsAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
FontAwesomeAsset::register($this);
NestedTabsAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo \Yii::$app->request->BaseUrl; ?>/favicon.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Market <i class="fa fa-shopping-cart"></i>',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => '', 'url' => ['/site/index'], 'linkOptions'=>['class'=>'glyphicon glyphicon-home'],],
                ['label' => '', 'url' => ['/site/about'],'linkOptions'=>['class'=>'glyphicon glyphicon-info-sign'],],
                ['label' => '', 'url' => ['/site/contact'], 'linkOptions'=>['class'=>'glyphicon glyphicon-envelope'],],
            ];
            if (!Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => ' Reports', 'url' => ['/reports/index' ], 'linkOptions'=>['class'=>'glyphicon glyphicon-pencil'],];
                $menuItems[] = ['label' => ' Performance', 'url' => ['/reports/performance'], 'linkOptions'=>['class'=>'glyphicon glyphicon-stats'],];
            }

            if (Yii::$app->user->isGuest) {
                
                $menuItems[] = ['label' => ' Signup', 'url' => ['/site/signup'], ];
                $menuItems[] = ['label' => ' Login', 'url' => ['/site/login'], 'linkOptions'=>['class'=>'glyphicon glyphicon-log-in'],];
            } else {
                
                $menuItems[] = [
                    'label' => "  ".Yii::$app->user->identity->username,
                    'items' =>
                    [
                       ['label' => ' Profile', 'url' => ['/profile/view'],'linkOptions' => ['class' => 'glyphicon glyphicon-user'],],
                       [ 'label' => ' Logout', 'url' => [ '/site/logout'], 'linkOptions' => ['data-method' => 'post', 'class'=>'glyphicon glyphicon-log-out']],
                    ],
                    'linkOptions'=>['class'=>'fa fa-user'], 
                    
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>  

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Market <?= date('Y') ?></p>
        <p class="pull-right"><?= "Powered by Ara" ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
