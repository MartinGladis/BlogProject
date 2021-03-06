<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Post $post */
/** @var ActiveForm $form */

$this->title = 'Edit Post';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="post-edit">

    <h1 class="mb-4">Edit post</h1>

    <?php $form = ActiveForm::begin(
        ['options' => ['enctype' => 'multipart/form-data']
    ]); ?>

        <?= $form->field($post, 'topic') ?>
        <?= $form->field($post, 'description')->textarea(['rows' => '5']) ?>
        
        <?php if ($post->files) : ?>

            <label id="attachmentLabel">Attachment files:</label>

            <div class="container mb-3">

                <?php foreach ($post->files as $file) : ?>

                <div class="row border-bottom border-dark">
                    <div class="col-8 col-md-9 my-2 d-flex justify-content-left align-items-center">
                        <?= $file ?>
                    </div>
                    <div class="col d-flex justify-content-center align-items-center my-2">
                        <button id="<?=$file->id ?>" class="btn btn-danger delete-file-button" type="button">Delete</button>
                    </div>
                </div>

                <?php endforeach ?>

            </div>

        <?php endif ?>

        <?= $form->field($post, 'attachmentFiles[]')->fileInput(['multiple' => true]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- post-create -->