<?php

namespace backend\controllers;

use common\helper\Help;
use yii;
use yii\web\Controller;


class HomeController extends Controller
{

    public function actionIndex()
    {

        var_dump(Yii::$app->timeZone);exit;
        echo date('Y-m-d H:i:s');
    }
}