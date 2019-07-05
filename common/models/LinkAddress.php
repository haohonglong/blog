<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linkAddress".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $info
 * @property string $date create time 
 * @property int $sorts_id 当前信息属于哪个类别
 */
class LinkAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'linkaddress';
    }

    public static function findById($id)
    {
        return self::find()->where(['id'=>$id])->limit(1)->one();
    }

    public static function removeById($id)
    {
        $model = static::findById($id);
        if($model){
            if($model->delete()){
                return true;
            }else{
                $model->getErrors();
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'info', 'sorts_id'], 'required'],
            [['date'], 'safe'],
            [['sorts_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 516],
            [['info'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '名称',
            'url' => 'Url',
            'info' => '表述内容',
            'date' => '日期',
            'sorts_id' => '类别',
        ];
    }
}
