<?php
namespace common\models;


use Yii;
use yii\base\Model;

/**
 * Login form
 */
class RegisterFrom extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $captcha;
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password','password_repeat','captcha'], 'required'],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
            ['captcha', 'captcha'],

        ];
    }

    public function register()
    {

    }


}
