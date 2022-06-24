<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\models\LoginForm;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UserController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'change-password'],
                'rules' => [
                    [
                        'actions' => ['logout', 'change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister()
    {
        $user = new User();
        $user->scenario = "register";

        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate()) {
                $user->auth_key = Yii::$app->security->generateRandomString();
                $user->save();
                return $this->goHome();
            }
        };

        return $this->render('register', [
            'user' => $user,
        ]);
    }

    public function actionChangePassword($id)
    {
        $user = User::findOne($id);
        $user->scenario = "change-password";

        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate()) {
                $user->save();
                return $this->goHome();
            }
        }

        return $this->render('change-password', [
            'user' => $user
        ]);
    }
}
