<?php

/** @var $this yii\web\View */
/** @var $user app\models\User */

$this->title = 'Show User Data';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>User Data</h1>
<div class="user-show">

    <div class="container p-5 row">
        <div class="p-2 col-6 col-md-4 col-lg-3 mb-5">
            <h2 class="h4">Full Name</h2>
            <span><?= $user->name . ' ' . $user->surname ?></span>
        </div>

        <div class="p-2 col-6 col-md-4 col-lg-3 mb-5">
            <h2 class="h4">Username</h2>
            <span><?= $user->username ?></span>
        </div>

        <div class="p-2 col-6 col-md-4 col-lg-3 mb-5">
            <h2 class="h4">E-mail</h2>
            <span><?= $user->email ?></span>
        </div>
        <div class="p-2 col-6 col-md-4 col-lg-3 mb-5">
            <h2 class="h4">Birthdate</h2>
            <span><?= Yii::$app->formatter->asDate($user->birthdate, 'php:d.m.Y') ?></span>
        </div>

        <div class="p-2 col-6 col-md-4 col-lg-3 mb-5">
            <h2 class="h4">Address</h2>
            <span><?= $user->street_name . ' ' . $user->number . '<br>' . $user->postcode ?></span>
        </div>

        <div class="p-2 col-6 col-md-4 col-lg-3 mb-5">
            <h2 class="h4">Last login</h2>
            <span><?= Yii::$app->formatter->asDatetime($user->last_login, 'php:d.m.Y H:i') ?></span>
        </div>
    </div>

</div><!-- user-show -->
