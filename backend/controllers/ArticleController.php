<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 12:36 PM
 */

namespace backend\controllers;

use common\models\Article;
use yii;
use yii\db\Query;
use common\models\ArticleForm;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ArticleController extends BaseController
{


    public function actionIndex()
    {
        $keyword = trim(Yii::$app->request->post('keyword'));
        $query = (Article::find())
                    ->from('article')
            ->orderBy(['id' => SORT_DESC])
            ->where(['is_show'=>1]);
        if(!empty($keyword)){
            $query->andWhere(['like','title',$keyword]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $var = [
            'dataProvider'=>$dataProvider,
        ];
        return $this->render('index',$var);



    }

    public function actionView($id)
    {

        $article = (new Query())->from('article')->where(['id'=>$id,'is_show'=>1])->limit(1)->one();
        $var = [
            'article'=>$article,
        ];
        return $this->render('view',$var);

    }



    /**
     * @return string|yii\web\Response
     */
    public function actionAdd()
    {
        $model = new ArticleForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack();
        } else {
            $sort = (new Query())->from('sorts')->select('id,name')->all();
            $sorts = [];
            foreach ($sort as $item){
                $sorts[$item['id']] = $item['name'];
            }
            return $this->render('add', [
                'model' => $model,
                'sorts' => $sorts,
            ]);
        }
    }

    public function actionEdit($id)
    {

        $model = new ArticleForm();
        $article = Article::find()->where(['id'=>$id])->limit(1)->one();
        if ($model->load(Yii::$app->request->post()) && $model->edit($article)) {
            return $this->goBack();
        } else {
            $model->title = $article->title;
            $model->sorts_id = $article->sorts_id;
            $model->content = Html::decode($article->content);
            $sort = (new Query())->from('sorts')->select('id,name')->all();
            $sorts = [];
            foreach ($sort as $item){
                $sorts[$item['id']] = $item['name'];
            }
            return $this->render('edit', [
                'model' => $model,
                'sorts' => $sorts,
            ]);
        }
    }


    public function actionRemove()
    {
        $request = yii::$app->request;
        if($request->isGet){
            $id = $request->get('id');
            $article = new ArticleForm();
            $article->remove($id);
            return $this->redirect(['article/index']);
        }


    }


}