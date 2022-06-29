<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

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
            ['label' => Html::tag('i', '', ['class' => 'fas fa-user-alt d-none d-md-inline']) . Html::tag('span', 'Hello ' . Yii::$app->user->identity->username, ['class' => 'd-inline d-md-none']),
            'dropdownOptions' => ['class' => 'dropdown-menu-right'], 'items' => [
                ['label' => 'Change Password', 'url' => ['/user/change-password']],
                ['label' => 'Show User Data', 'url' => ['/user/show']],
                ['label' => 'Edit User Data', 'url' => ['/user/edit']],
                ['label' => 'My Posts', 'url' => ['/post/view']],
                '<div class="dropdown-divider"></div>',
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
