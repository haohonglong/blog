<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 4:25 PM
 */

namespace common\models;

use yii;
use yii\db\Query;

class PostsForm extends Posts
{


    

    public function save($runValidation = true, $attributeNames = NULL)
    {
        if($this->validate()){
            $this->date    = date('Y-m-d H:i:s');
            $this->ip    = Yii::$app->getRequest()->getUserIP();
            var_dump($this->attributes);exit;
            if($this->save(false)){
                echo "1";exit;
                return true;
            }else {
                echo "2";exit;
                return $this->getErrors();
            }
        }

        return false;
    }

    public function remove($id)
    {
        $posts = static::find()->where(['id'=>$id])->limit(1)->one();
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