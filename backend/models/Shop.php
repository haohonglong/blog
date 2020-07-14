<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "shop".
 *
 * @property int $id
 * @property string $name 商店名称
 */
class Shop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '商店名称'),
        ];
    }

    /**
     * @author: lhh
     * 创建日期：2020-01-26
     * 修改日期：2020-01-26
     * 名称： getAll
     * 功能：返回所有商店名称列表
     * 说明：
     * 注意：
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAll()
    {
        $shop = Shop::find()->asArray()->all();
        $shop = ArrayHelper::map($shop,'id','name');
        return $shop;
    }


}
