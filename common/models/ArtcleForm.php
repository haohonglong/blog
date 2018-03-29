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

class ArticleForm extends Model
{
    public $title,$content;

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

    public function update($id)
    {
        if($this->validate()){
            $article = Article::find()->where(['id'=>$id,'user_id'=>Yii::$app->user->identity->id])->limit(1)->one();
            $article->title = $this->title;
            $article->content = $this->content;
            $article->cdate = date('Y-m-d H:i:s');
            $article->udate = $article->cdate;
            if(!$article->save()){
                $this->addError($article->getErrors());
                return false;
            }
            return true;
        }

        return false;

    }

    public function remove($id)
    {
        $article = Article::find()->where(['id'=>$id,'user_id'=>Yii::$app->user->identity->id])->limit(1)->one();
        $article->isshow = '0';
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