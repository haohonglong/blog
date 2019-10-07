<?php
namespace common\models;


use Yii;
use yii\base\Model;

/**
 * Login form
 */
class SignupFrom extends Model
{
    public
        $username,
        $password,
        $password_repeat,
        $captcha,
        $email,
        $avatar,
        $phone;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password','password_repeat','captcha','email','phone'], 'required'],
            [['username', 'password', 'email', 'avatar', 'phone'], 'string', 'max' => 255],
            ['email', 'email'],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
            ['captcha', 'captcha'],

        ];
    }

    public function validate_($attributeNames = null, $clearErrors = true)
    {
        if(parent::validate($attributeNames,$clearErrors)){
            if(!User::findByPhone($this->phone)){
                return true;
            }else{
                $this->addError('phone','手机号已注册过');
            }
        }
        return false;
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

    public function attributeLabels()
    {
        return (new User())->attributeLabels();
    }


}
