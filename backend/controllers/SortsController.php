<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 30/03/2018
 * Time: 7:58 PM
 */

namespace backend\controllers;

use backend\models\Sorts;
use yii;
use backend\models\SortsForm;
use yii\db\Query;

class SortsController extends BaseController
{
    public function actionIndex()
    {
        $keyword = trim(Yii::$app->request->post('keyword'));
        $query = (new Query())->from('sorts');
        if(!empty($keyword)){
            $query->where(['like','name',$keyword]);
        }
        $list = $query->all();
        $var = [
            'list'=>$list,
        ];
        return $this->render('index',$var);
    }

    public function actionAdd()
    {
        $model = new SortsForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['sorts/index']);
        } else {
            return $this->render('add', [
                'model' => $model,
            ]);
        }
    }



    public function actionEdit($id)
    {
        $model = Sorts::find()->where(['id'=>$id])->limit(1)->one();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['sorts/index']);
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }


}