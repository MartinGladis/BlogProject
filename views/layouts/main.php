<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-light bg-light fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'New Post', 'url' => ['/post/create']],
        ],
    ]);  

    echo Nav::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => Yii::$app->user->isGuest ? [
            ['label' => 'Login', 'url' => ['/user/login']],
            ['label' => 'Register', 'url' => ['/user/register']]
        ] : [
            (Yii::$app->session->get("last_login")
                ? '<li class="last-login-element px-0 mr-2">Last Login: '
                    . Yii::$app->session->get("last_login")
                    . '</li>' 
                : ''),
            ['label' => Html::tag('i', '', ['class' => 'fas fa-user-alt']), 'dropdownOptions' => ['class' => 'dropdown-menu-right'], 'items' => [
                ['label' => 'Change Password', 'url' => [
                    Url::to(['/user/change-password', 'id' => isset(Yii::$app->user->identity->id) 
                        ? Yii::$app->user->identity->id : ''])
                    ], 
                ],
                ['label' => 'Edit User Data', 'url' => [
                    Url::to([
                    '/user/edit',
                    'id' => isset(Yii::$app->user->identity->id) 
                        ? Yii::$app->user->identity->id 
                        : ''
                    ])
                ]],
                ['label' => 'My Posts', 'url' => ['/post/view']],
                ['label' => 'Logout', 'url' => ['/user/logout'], 'linkOptions' => ['data-method' => 'post']]
            ]]        
        ]
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; Martin Gladis <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
