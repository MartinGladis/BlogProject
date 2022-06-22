<?php

namespace app\controllers;
use app\models\File;

class FileController extends \yii\web\Controller
{
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

}
