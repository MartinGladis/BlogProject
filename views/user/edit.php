<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>

<h1>Edit User Data</h1>
<div class="user-edit">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'name') ?>
        <?= $form->field($user, 'surname') ?>
        <?= $form->field($user, 'username') ?>
        <?= $form->field($user, 'birthdate')->widget(DatePicker::class, [
            'language' => 'en',
            'dateFormat' => 'dd.MM.yyyy'
        ]) ?>
        <?= $form->field($user, 'email') ?>
        <?= $form->field($user, 'street_name') ?>
        <?= $form->field($user, 'number') ?>
        <?= $form->field($user, 'postcode') ?>
        <?= $form->field($user, 'pesel') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Edit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-edit -->
