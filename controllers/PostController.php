<?php

namespace app\controllers;

class PostController extends \yii\web\Controller
{
    public function actionCreate()
    {
        return $this->render('create');
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
