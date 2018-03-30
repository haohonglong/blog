<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 12:36 PM
 */

namespace frontend\controllers;

use yii;
use yii\db\Query;

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
            ->leftJoin('article a','a.id = p.article_id')
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
                if($item['id'] == $v['posts_id']){
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
    public function actionDetail()
    {

//        $id = Yii::$app->request->get('id');
        $query = (new Query())
                    ->from('article')
            ->where(['id'=>1,'is_show'=>1]);

        $article = $query->one();



        $arr = $this->get_posts($article['id']);


        $posts = array_values($arr);

        $var = [
            'article'=>$article,
            'posts'=>$posts,
        ];

        print_r($posts);exit;
        $this->render('detail',$var);
    }



}