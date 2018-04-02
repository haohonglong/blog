<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 02/04/2018
 * Time: 9:27 PM
 */

namespace frontend\controllers;

use yii;
use yii\web\Controller;
use common\models\Article;
use yii\db\Query;
use common\models\Vote;

class VoteController extends Controller
{
    public function actionSet()
    {
        $article_id = Yii::$app->request->get('article_id');
        $type = Yii::$app->request->get('type');
        $ip = Yii::$app->getRequest()->getUserIP();
        if(Article::getById($article_id)){
            $count = (new Query())->from('vote')
                ->where(['article_id'=>$article_id,'ip'=>$ip])->count();

            if(!$count){
                $vote = new Vote();
                $vote->ip = $ip;
                $vote->article_id = $article_id;
                $vote->type = $type;
                $vote->date = date('Y-m-d H:i:s');
                if($vote->save()){
                    echo 'voted success';
                }else{
                    echo 'vote failed';exit;
                }
            }else{
                echo 'has been voted';exit;
            }
        }else{
            echo 'without anything with id';exit;
        }



    }
}