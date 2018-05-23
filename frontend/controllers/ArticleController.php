<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 12:36 PM
 */

namespace frontend\controllers;

use common\models\Article;
use common\models\PostsForm;
use common\models\Vote;
use yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;

class ArticleController extends yii\web\Controller
{


    private function get_posts2($article_id,$parent_id = 0,&$result = []){
        $query = (new Query())
            ->from('posts p')
            ->select('p.id id,p.posts_id posts_id,p.content content,p.date date,p.ip ip')
            ->leftJoin('article a','a.id = p.article_id')
            ->where(['p.is_show'=>1,'p.article_id'=>$article_id,'p.posts_id'=>$parent_id]);
        $posts = $query->all();
        if(empty($posts)){return null;}
        foreach ($posts as $item) {
            $thisArr=&$result[];
            $item["children"] = $this->get_posts2($article_id,$item["id"],$thisArr);
            $thisArr = $item;
        }
        return $result;
    }
    private function get_posts($article_id,$arr=[])
    {
        $query = (new Query())
            ->from('posts p')
            ->select('p.id id,p.posts_id posts_id,p.content content,p.date date,p.ip ip')
            ->innerJoin('article a','a.id = p.article_id')
            ->where(['p.is_show'=>1,'p.article_id'=>$article_id]);
        $posts = $query->all();
        foreach ($posts as $k => $item){
            if(!isset($arr[$item['id']]) && 0 == $item['posts_id']){
                $arr[$item['id']] = [
                    'id'=>$item['id'],
                    'content'=>$item['content'],
                    'date'=>$item['date'],
                    'ip'=>$item['ip'],

                ];
            }

            foreach ($posts as $v){
                if(isset($arr[$item['id']]) && ($item['id'] == $v['posts_id'])){
                    $arr[$item['id']]['reply'][] = [
                        'id'=>$v['id'],
                        'content'=>$v['content'],
                        'date'=>$v['date'],
                        'ip'=>$v['ip'],
                    ];




                }
            }



        }

        return $arr;
    }

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

        $model = new PostsForm();
        if($model->load(Yii::$app->request->post()) && $model->save()){

        }

        $article = (new Query())->from('article')->where(['id'=>$id,'is_show'=>1])->limit(1)->one();
        if(!$article){$this->redirect(['article/index']);}
        $vote = (new Query())->from('vote')->where(['article_id'=>$id])->all();
        $votes = [];

        foreach ($vote as $item){
            if(!isset($votes[$item['type']])){
                $votes[$item['type']] = 0;
            }
            $votes[$item['type']]++;
        }
        $arr = $this->get_posts($article['id']);
        $posts = array_values($arr);

        $var = [
            'article_id'=>$id,
            'article'=>$article,
            'posts'=>$posts,
            'votes'=>$votes,
            'model'=>$model,
        ];

//        print_r($posts);exit;
        return $this->render('view',$var);

    }





}