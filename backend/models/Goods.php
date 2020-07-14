<?php

namespace backend\models;

use app\models\Bills;
use common\models\User;
use Yii;

/**
 * This is the model class for table "shop_list".
 *
 * @property int $id
 * @property int $uid
 * @property int $shop_id 超市名称
 * @property string $name 名称
 * @property int $number 数量
 * @property int $weight 重量
 * @property string $single_price 单价
 * @property string $final_price 结算价格
 * @property int $create_by
 * @property int $update_by
 */
class Goods extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'bill_id', 'shop_id', 'name', 'weight', 'single_price', 'final_price', 'create_by', 'update_by'], 'required'],
            [['uid', 'shop_id', 'number'], 'integer'],
            [['weight'],'string','max'=>16],
            [['single_price', 'final_price'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @author: lhh
     * 创建日期：2020-03-18
     * 修改日期：2020-03-18
     * 名称： totalPrices
     * 功能：计算商品总额
     * 说明：
     * 注意：
     * @return float|int
     */
    public static function totalPrices()
    {
        $prices = 0;
        $total = static::find()
            ->select('final_price')
            ->all();
        foreach ($total as $item){
            $prices += floatval($item->final_price);
        }
        return $prices;
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uid' => Yii::t('app', 'Uid'),
            'shop' => Yii::t('app', '超市名称'),
            'shop_id' => Yii::t('app', '超市id'),
            'bill_id' => Yii::t('app', '账单号'),
            'name' => Yii::t('app', '商品名称'),
            'number' => Yii::t('app', '数量'),
            'weight' => Yii::t('app', '重量'),
            'single_price' => Yii::t('app', '单价'),
            'final_price' => Yii::t('app', '结算价格'),
            'create_by' => Yii::t('app', '创建日期'),
            'update_by' => Yii::t('app', '修改日期'),
        ];
    }

    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }



    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }


}
