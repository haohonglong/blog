<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $source 嵌入视频的源码
 * @property string $date
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'source'], 'required'],
            [['source'], 'string'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 500],
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
            'title' => 'Title',
            'source' => 'Source',
            'date' => 'Date',
        ];
    }
}
