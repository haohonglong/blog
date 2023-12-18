<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sorts".
 *
 * @property int $id
 * @property int $pid
 * @property string $name the name of sort
 */
class Sorts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sorts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','pid'], 'required'],
            [['name'], 'string', 'max' => 11],
        ];
    }

    public static function has_name($name, $pid=0)
    {
        $n = static::find()
        ->where(['name' => $name, 'pid'=>$pid])
        -limit(1)
        ->count();
        if($n > 0) {
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
