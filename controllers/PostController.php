<?php

namespace app\controllers;

use Yii;
use yii\web\UploadedFile;
use app\models\Post;
use yii\helpers\FileHelper;
use app\models\File;

class PostController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $post = new Post();

        if ($post->load(Yii::$app->request->post())) {

            $post->attachmentFiles = UploadedFile::getInstances($post, 'attachmentFiles');

            if ($post->validate()) {
                $post->save();
                $post->refresh();

                $path = 'uploads/' . $post->id . '/';
                FileHelper::createDirectory($path);

                foreach ($post->attachmentFiles as $attachmentFile) {
                    $file = new File();

                    $filename = $attachmentFile->baseName . '.' . $attachmentFile->extension;
                    $attachmentFile->saveAs($path . $filename);
                    
                    $file->filename = $filename;
                    $file->post_id = $post->id;
                    $file->path = $path;
                    $file->mime_type = FileHelper::getMimeType($attachmentFile);
                    $file->save();
                }
                return $this->redirect('/');
            }
        }

        return $this->render('create', [
            'post' => $post,
        ]);
    }

    public function actionDelete($id)
    {
        return $this->render('delete');
    }

    public function actionEdit($id)
    {
        return $this->render('edit');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
