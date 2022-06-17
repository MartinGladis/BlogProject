<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $post app\models\Post */
/* @var $form ActiveForm */
?>
<h1>Add new post</h1>
<div class="post-create mt-4">

    <?php $form = ActiveForm::begin(
        ['options' => ['enctype' => 'multipart/form-data']
    ]); ?>

        <?= $form->field($post, 'topic') ?>
        <?= $form->field($post, 'description')->textarea(['rows' => '5']) ?>
        <?= $form->field($post, 'attachmentFiles[]')->fileInput(['multiple' => true]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- post-create -->
