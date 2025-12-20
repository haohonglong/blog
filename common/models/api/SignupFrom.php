<?php
namespace common\models\api;


use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class SignupFrom extends \common\models\SignupFrom
{
    public
        $username,
        $password,
        $email,
        $phone;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'email','phone'], 'required'],
            [['username', 'password', 'email', 'avatar', 'phone'], 'string', 'max' => 255],
            ['email', 'email'],
            ['username', 'validateUsernameUnique'],
            ['email', 'validateEmailUnique'],
            ['phone', 'validatePhoneUnique'],

        ];
    }

    public function validatePhoneUnique($attribute, $params)
    {
        if (User::find()->where(['phone' => $this->$attribute])->exists()) {
            $this->addError($attribute, '手机号已存在');
        }
    }

    public function validateUsernameUnique($attribute, $params)
    {
        if (User::find()->where(['username' => $this->$attribute])->exists()) {
            $this->addError($attribute, '用户名已存在');
        }
    }
    
    public function validateEmailUnique($attribute, $params)
    {
        if (User::find()->where(['email' => $this->$attribute])->exists()) {
            $this->addError($attribute, '邮箱已存在');
        }
    }

    public function register()
    {
        if($this->validate()){
            $user = new User();
            $user->username = $this->username;
            $user->phone = $this->phone;
            $user->email = $this->email;
            $user->created_at = time();
            $user->updated_at = $user->created_at;
            $user->setPassword($this->password);
            $user->generatePasswordResetToken();
            $user->generateAuthKey();
            $user->ip = Yii::$app->getRequest()->getUserIP();
            if($user->save()){
                return true;
            }else{
                $this->addErrors($user->getErrors());
            }

        }
        return false;

    }





}
