<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Post;
use yii\data\Pagination;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($sort = SORT_DESC)
    {
        $query = Post::find();

        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $query->count()
        ]);

        $posts = $query->orderBy(['create_at' => (int) $sort])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'posts' => $posts,
            'pagination' => $pagination,
            'sort' => $sort
        ]);
    }
}
