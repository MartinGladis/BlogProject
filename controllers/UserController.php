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
                'only' => ['logout', 'change-password', 'edit', 'show'],
                'rules' => [
                    [
                        'actions' => ['logout', 'change-password', 'edit', 'show'],
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
                Yii::$app->getSession()->setFlash('success', 'Registered successfully');
                return $this->goHome();
            }
        };

        return $this->render('register', [
            'user' => $user,
        ]);
    }

    public function actionChangePassword()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        $user->scenario = "change-password";

        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate()) {
                $user->save();
                Yii::$app->getSession()->setFlash('success', 'Password changed successfully');
                return $this->goHome();
            }
        }

        return $this->render('change-password', [
            'user' => $user
        ]);
    }

    public function actionEdit()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        $user->scenario = "edit";

        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate()) {
                $user->save();
                Yii::$app->getSession()->setFlash('success', 'User data edited succesfully');
                return $this->goHome();
            }
        }

        return $this->render('edit', [
            'user' => $user
        ]);
    }

    public function actionShow()
    {
        $user = User::findOne(Yii::$app->user->identity->id);

        return $this->render('show', [
            'user' => $user
        ]);
    }
}
