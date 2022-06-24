<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<div class="user-change-password">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'old_password')->passwordInput(['value' => '']) ?>
        <?= $form->field($user, 'password')->passwordInput(['value' => ''])->label('New Password') ?>
        <?= $form->field($user, 'password_repeat')->passwordInput(['value' => ''])->label('Re-type New Password') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-change-password -->
