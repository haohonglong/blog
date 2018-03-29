<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 1:44 PM
 */

namespace common\helper;

use yii;

class Help
{
    static public function ip2long()
    {
        return ip2long(Yii::$app->getRequest()->getUserIP());
    }

}