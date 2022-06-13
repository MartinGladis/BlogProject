<?php

namespace app\controllers;

use Yii;

class PostController extends \yii\web\Controller
{
    public function actionCreate()
{
    $post = new \app\models\Post();

    if ($post->load(Yii::$app->request->post())) {
        if ($post->validate()) {
            $post->save();
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
