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
use yii\helpers\Html;

class ArticleForm extends Model
{
    public $id,$sorts_id,$title,$content,$model;

    public function rules()
    {
        return [
            [['title', 'content','sorts_id'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function save()
    {
        if($this->validate()){
            $article = $this->model;
            $date = date('Y-m-d H:i:s');
            $article->user_id = Yii::$app->user->identity->id;
            $article->sorts_id = isset($this->sorts_id) ? $this->sorts_id : 0;
            $article->title = $this->title;
            $article->content = Html::encode($this->content);
            if($article->add){
                $article->cdate = $date;
            }
            $article->udate = $date;
            if(!$article->save()){
                $this->addError($article->getErrors());
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
            'sorts_id' => '类别名称',
            'title' => '标题',
            'content' => '内容',
        ];
    }
}