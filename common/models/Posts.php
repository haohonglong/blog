<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int $article_id the id of article
 * @property string $content the content of posts
 * @property string $date create time 
 * @property int $ip ip
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'content', 'ip'], 'required'],
            [['article_id', 'ip'], 'integer'],
            [['content'], 'string'],
        ];
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
