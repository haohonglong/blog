<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vote".
 *
 * @property int $id
 * @property int $type 投票的类型 1：差；2：一般；3：好
 * @property int $article_id the id of article
 * @property string $date create time
 * @property string $ip 投票用户的ip
 */
class Vote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'article_id'], 'required'],
            [['article_id'], 'integer'],
            [['date'], 'safe'],
            [['type'], 'string', 'max' => 3],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'article_id' => 'Article ID',
            'date' => 'Date',
            'ip' => 'Ip',
        ];
    }
}
