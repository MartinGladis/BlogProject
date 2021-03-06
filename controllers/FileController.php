<?php

namespace app\controllers;
use app\models\File;
use yii\filters\AccessControl;
use Yii;

class FileController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['delete'],
                'rules' => [
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionDownload($id)
    {
        $file = File::findOne($id);
        header("Content-Disposition: attachment; filename=$file->filename");
    }

    public function actionView($id)
    {
        $file = File::findOne($id);
        header("Content-Type: $file->mime_type");
        echo $file->blob;
    }

    public function actionDelete($id)
    {
        $file = File::findOne($id);
        $file->delete();
        $key = 'success';
        Yii::$app->getSession()->setFlash($key, 'File removed succesfully');

        return $this->renderAjax('../_flash.php', [
            'key' => $key
        ]);
    }

}
