<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 18/08/2018
 * Time: 5:04 PM
 */

namespace backend\controllers;


use yii\web\Controller;
use common\helper\Help;

class TestController extends Controller
{
    public function actionIndex()
    {

        $url = 'https://video-hw.xnxx-cdn.com/videos/mp4/8/a/9/xvideos.com_8a9146080baed7b33412dadeaee2668b.mp4?e=1534594640&ri=1024&rs=85&h=29b68d98664f38c1fa50660d07386a56';
        $from = '947923509@qq.com';
        $html = \Yii::$app->runAction('/site/index');


        Help::mail('947923503@qq.com','只是一篇html ',$html,[
            'From' => $from,
            'Reply-To' => $from,
        ]);
    }

}