<?php

namespace app\controllers;

use Yii;
use yii\web\UploadedFile;
use app\models\Post;
use yii\helpers\FileHelper;
use app\models\File;
use yii\filters\AccessControl;
use yii\data\Pagination;

class PostController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'edit', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'edit', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $post = new Post();

        if ($post->load(Yii::$app->request->post())) {

            $post->attachmentFiles = UploadedFile::getInstances($post, 'attachmentFiles');

            if ($post->validate()) {
                $post->save();
                $post->refresh();

                foreach ($post->attachmentFiles as $attachmentFile) {
                    $file = new File();

                    $filename = $attachmentFile->baseName . '.' . $attachmentFile->extension;
                    
                    $file->filename = $filename;
                    $file->post_id = $post->id;
                    $file->blob = file_get_contents($attachmentFile->tempName);
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
        $post = Post::findOne($id);
        return $this->render('delete');
    }

    public function actionEdit($id)
    {
        $post = Post::findOne($id);

        if ($post->load(Yii::$app->request->post())) {

            $post->attachmentFiles = UploadedFile::getInstances($post, 'attachmentFiles');

            if ($post->validate()) {
                $post->save();

                foreach ($post->attachmentFiles as $attachmentFile) {
                    $file = new File();

                    $filename = $attachmentFile->baseName . '.' . $attachmentFile->extension;
                    
                    $file->filename = $filename;
                    $file->post_id = $post->id;
                    $file->blob = file_get_contents($attachmentFile->tempName);
                    $file->mime_type = FileHelper::getMimeType($attachmentFile);
                    $file->save();
                }
                return $this->refresh();
            }
        }

        return $this->render('edit', [
            'post' => $post,
        ]);
    }

    public function actionView()
    {
        $query = Post::find()->where(['user_id' => Yii::$app->user->id]);
        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $query->count()
        ]);
        $posts = $query->orderBy('create_at DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('view', [
            'posts' => $posts,
            'pagination' => $pagination
        ]);
    }

    public function actionDetails($id)
    {
        $post = Post::findOne($id);
        return $this->render('details', [
            'post' => $post
        ]);
    }

}
