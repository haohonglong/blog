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

class PostsForm extends Model
{

    public $article_id,$content;

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
        $posts->show = '0';
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