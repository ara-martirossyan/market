<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\models\ValueHelpers;
use backend\assets\FontAwesomeAsset;


/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
FontAwesomeAsset::register($this);
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
        $is_admin = ValueHelpers::getRoleValue('Admin');

        if (!Yii::$app->user->isGuest) {

            NavBar::begin([
                'brandLabel' => 'Market <i class="fa fa-shopping-cart"></i> Admin',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
        } else {
            NavBar::begin([
                'brandLabel' => 'Market <i class="fa fa-shopping-cart"></i>',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
        }


        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
        ];
 
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= $is_admin) {
            $menuItems[] = ['label' => 'Users', 'url' => ['user/index']];
            $menuItems[] = ['label' => 'Profiles', 'url' => ['profile/index']];
            $menuItems[] = ['label' => 'Roles', 'url' => ['/role/index']];
            $menuItems[] = ['label' => 'User Types', 'url' => ['/user-type/index']];
            $menuItems[] = ['label' => 'Statuses', 'url' => ['/status/index']];
        }
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        } else {
           // $menuItems[] = ['label' => 'Logout (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout']];
            $menuItems[] = [
                'label' => Yii::$app->user->identity->username,
                'items' =>
                [
                    [ 'label' => 'Logout', 'url' => [ '/site/logout']],
                ]
                ];
        }



        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>

            <div class="container">
            <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])
            ?>
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
