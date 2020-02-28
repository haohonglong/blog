<?php
namespace backend\controllers;

use common\models\{User,SignupFrom,LoginForm};
use yii;

/**
 * Site controller
 */
class SiteController extends BaseController
{

    public function actions() {
        return yii\helpers\ArrayHelper::merge(
            parent::actions(),
            [
                'captcha' =>  [
                    'class' => 'yii\captcha\CaptchaAction',
                    'height' => 50,
                    'width' => 80,
                    'minLength' => 4,
                    'maxLength' => 4
                ],
            ]
        );
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $_SESSION['user'] = (new yii\db\Query())->from(User::tableName())->where(['id'=>Yii::$app->user->identity->id])->one();
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new SignupFrom();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->redirect('logout');
        }
        return $this->render('signup', [
            'model' => $model,
        ]);

    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


}
