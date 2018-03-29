<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title the title of article
 * @property string $content the content of article
 * @property string $cdate create time
 * @property string $udate update time
 * @property string $isshow 是否显示 默认是1 显示，0 ： 不显示
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
            [['user_id', 'content'], 'required'],
            [['user_id'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['isshow'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'content' => 'Content',
            'cdate' => 'Cdate',
            'udate' => 'Udate',
            'isshow' => 'Show',
        ];
    }
}
