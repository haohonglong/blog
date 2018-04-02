<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property int $user_id
 * @property int $sorts_id
 * @property string $title the title of article
 * @property string $content the content of article
 * @property string $cdate create time
 * @property string $udate update time
 * @property string $is_show 是否显示 默认是1 显示，0 ： 不显示
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sorts_id', 'content'], 'required'],
            [['user_id', 'sorts_id'], 'integer'],
            [['content'], 'string'],
            [['cdate', 'udate'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['is_show'], 'string', 'max' => 1],
        ];
    }

    public static function getById($id)
    {
        return self::find()->where(['id'=>$id])->limit(1)->one();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'sorts_id' => 'Sorts ID',
            'title' => 'Title',
            'content' => 'Content',
            'cdate' => 'Cdate',
            'udate' => 'Udate',
            'is_show' => 'Is Show',
        ];
    }
}
