<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 4:25 PM
 */

namespace common\models;

use yii;
use yii\base\Model;
use yii\db\Query;

class PostsForm extends Model
{

    public $article_id,$posts_id,$content;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'content'], 'required'],
            [['article_id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    public function save()
    {
        if($this->validate()){
            $posts = new Posts();
            $posts->article_id = $this->article_id;
            $posts->posts_id = isset($this->posts_id) ? $this->posts_id : 0;
            $posts->content    = $this->content;
            $posts->date    = date('Y-m-d H:i:s');
            $posts->ip    = Yii::$app->getRequest()->getUserIP();
            if(!$posts->save()){
                $this->addError($posts->getErrors());
                return false;
            }
            return true;
        }

        return false;
    }

    public function remove($id)
    {
        $posts = Posts::find()->where(['id'=>$id])->limit(1)->one();
        if(!$posts){return false;}
        $query = (new Query())->from('posts')->select('id')->where(['posts_id'=>$id])->limit(1)->one();
        if($query){//帖子有对应的回复的话就不能删除
            return false;
        }
        $posts->is_show = '0';
        if(!$posts->save()){
            $this->addError($posts->getErrors());
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
            'content' => '内容',
            'date' => '日期',
        ];
    }
}