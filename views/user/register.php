<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<div class="user-register">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'name') ?>
        <?= $form->field($user, 'surname') ?>
        <?= $form->field($user, 'username') ?>
        <?= $form->field($user, 'password')->passwordInput() ?>
        <?= $form->field($user, 'password_repeat')->passwordInput() ?>
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
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-register -->
