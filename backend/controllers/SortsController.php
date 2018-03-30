<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 30/03/2018
 * Time: 7:58 PM
 */

namespace backend\controllers;

use common\models\SortsForm;
use yii;

class SortsController extends BaseController
{
    public function actionIndex()
    {
        $model = new SortsForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->goBack();
        } else {
            return $this->render('add', [
                'model' => $model,
            ]);
        }
    }

    public function actionEdit()
    {
        $model = new SortsForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->edit()) {
            return $this->goBack();
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }


}