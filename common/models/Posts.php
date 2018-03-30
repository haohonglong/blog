<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int $article_id the id of article
 * @property int $posts_id 对应回复的帖子
 * @property string $content the content of posts
 * @property string $date create time 
 * @property string $ip ip
 * @property string $is_show 是否显示 默认是1 显示，0 ： 不显示
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
            [['article_id', 'posts_id'], 'integer'],
            [['content'], 'string'],
            [['date'], 'safe'],
            [['ip'], 'string', 'max' => 15],
            [['is_show'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'posts_id' => 'Posts ID',
            'content' => 'Content',
            'date' => 'Date',
            'ip' => 'Ip',
            'is_show' => 'Is Show',
        ];
    }
}
