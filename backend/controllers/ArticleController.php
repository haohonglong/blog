<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 12:36 PM
 */

namespace backend\controllers;

use yii;
use yii\db\Query;
use common\models\ArticleForm;

class ArticleController extends BaseController
{
    public function actionIndex()
    {
        $query = (new Query())
                    ->from('article')->where(['show'=>1]);

        $list = $query->all();
        var_dump($list);exit;
    }

    public function actionAdd()
    {
        $model = new ArticleForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }


}