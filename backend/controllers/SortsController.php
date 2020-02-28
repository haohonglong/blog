<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 30/03/2018
 * Time: 7:58 PM
 */

namespace backend\controllers;

use backend\models\Sorts;
use common\models\Article;
use common\models\LinkAddress;
use common\models\Tree;
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
        if ($model->load(Yii::$app->request->post())) {
            $model->pid = isset($model->pid) ? $model->pid : 0;
            if($model->validate() && $model->save()){
                return $this->redirect(['sorts/index']);
            }

        }
        return $this->render('add', [
            'model' => $model,
        ]);
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



    public function actionReSort()
    {



        $sql =<<<SQL
    select * from ushop_cat  ORDER BY sort ASC 
SQL;

        $data = Yii::$app->fcms->createCommand($sql)
            ->queryAll();

//        $menu = $data;

//var_dump($data);exit;
         Tree::getTree($data,$menu);


        print_r($menu);



        exit;

        $query = Sorts::find()->orderBy(['id'=>SORT_DESC])->all();
        $arr = [];
        foreach ($query as $item) {
            $id = $item->id+1;
            $arr[$item->id] = $id;
        }
        foreach ($arr as $id2=>$id){
            Article::updateAll(['sorts_id' => $id], ['sorts_id'=>$id2]);
            LinkAddress::updateAll(['sorts_id' => $id], ['sorts_id'=>$id2]);


        }

        exit;

    }


}