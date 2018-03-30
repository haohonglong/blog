<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 12:39 PM
 */

namespace common\models;

use yii;
use yii\base\Model;
use yii\db\Query;

class ArticleForm extends Model
{
    public $id,$sorts_id,$title,$content;

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function save()
    {
        if($this->validate()){
            $article = new Article();
            $article->user_id = Yii::$app->user->identity->id;
            $article->sorts_id = isset($this->sorts_id) ? $this->sorts_id : 0;
            $article->title = $this->title;
            $article->content = $this->content;
            $article->cdate = date('Y-m-d H:i:s');
            $article->udate = $article->cdate;
            if(!$article->save()){
                $this->addError($article->getErrors());
            }
            return true;
        }

        return false;

    }

    public function edit()
    {
        if($this->validate()){
            $article = Article::find()->where(['id'=>$this->id,'user_id'=>Yii::$app->user->identity->id])->limit(1)->one();
            if(!$article){return false;}
            $article->title = $this->title;
            $article->content = $this->content;
            $article->udate = date('Y-m-d H:i:s');
            if(!$article->save()){
                $this->addError($article->getErrors());
                return false;
            }
            return true;
        }

        return false;

    }

    /**
     *
     * @param $id
     * @return bool
     */
    public function remove($id)
    {
        $article = Article::find()->where(['id'=>$id,'user_id'=>Yii::$app->user->identity->id])->limit(1)->one();
        if(!$article) {return false;}
        $query = (new Query())->from('posts')->select('id')->where(['article_id'=>$id])->one();
        if($query){//检查文章里是否有一条评论，有就不删除
            return false;
        }
        $article->is_show = '0';
        if(!$article->save()){
            $this->addError($article->getErrors());
            return false;
        }
        return true;
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'content' => 'Content',
        ];
    }
}