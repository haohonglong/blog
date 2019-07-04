<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 6:15 PM
 */

namespace frontend\controllers;

use yii;
use common\models\PostsForm;
use yii\web\Controller;

class PostsController extends Controller
{
    public function actionAdd()
    {
        $model = new PostsForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack();
        } else {
            return $this->render('add', [
                'model' => $model,
            ]);
        }
    }
}