<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bills".
 *
 * @property string $bill_id 账单号
 * @property int $shop_id 超市id
 * @property string $discount 折扣
 * @property string $price 账单价格
 * @property int $create_by
 * @property int $update_by
 */
class Bills extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bills';
    }

    public static function generateId()
    {
        return time();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bill_id', 'shop_id', 'discount', 'price', 'create_at', 'update_at'], 'required'],
            [['shop_id', 'create_at', 'update_at'], 'integer'],
            [['discount', 'price'], 'number'],
            [['bill_id'], 'string', 'max' => 23],
            [['bill_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bill_id' => '账单号（小票号）',
            'shop_id' => 'Shop ID',
            'discount' => '折扣价',
            'price' => 'Price',
            'create_at' => 'Create By',
            'update_at' => 'Update By',
        ];
    }
}
