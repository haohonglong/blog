<?php
namespace backend\controllers\api;

use yii;
use common\models\User;
use common\models\LoginForm;
use common\models\api\SignupFrom;


/**
 * Site controller
 */
class SiteController extends BaseController
{
    
    /**
     * Signup action.
     *
     * @return string
     */
    public function actionSignup()
    {
        
        $request = Yii::$app->request;
        if ($request->isPost) {
            $username = $request->post("username", "");
            $password = $request->post("password", "");
            $phone = $request->post("phone", "");
            $email = $request->post("email", "");

            $model = new SignupFrom();
            $model->username = $username;
            $model->password = $password;
            $model->phone = $phone;
            $model->email = $email;

            if ($model->register()) {
                $data = [
                    "status" => 0
                ];
            } else {
                $data = [
                    "status" => 1,
                    "error" => $model->getErrors(),
                ];

                
            }
        } else {
            $data = [
                "status" => 2,
                "error" => "必须是POST 请求"
            ];
        }

        return $data;
        
        exit;
    }
    
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $username = $request->post("username", "");
            $password = $request->post("password", "");
            $model = new LoginForm();
            $model->username = $username;
            $model->password = $password;
            if ($model->login()) {
                $_SESSION['user'] = (new yii\db\Query())->from(User::tableName())->where(['id'=>Yii::$app->user->identity->id])->one();
                $data = [
                    "status" => 0,
                    "data" => $_SESSION['user']
                ];
            } else {
                $data = [
                    "status" => 1,
                    "error" => $model->getErrors(),
                ];

                
            }
        } else {
            $data = [
                "status" => 2,
                "error" => "必须是POST 请求"
            ];
        }

        return $data;
        
        exit;
    }


}
