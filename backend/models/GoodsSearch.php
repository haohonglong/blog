<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Goods;

/**
 * ShopListSearch represents the model behind the search form of `backend\models\ShopList`.
 */
class GoodsSearch extends Goods
{

    public $shop_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'shop_id', 'number', 'weight', 'create_by', 'update_by'], 'integer'],
            [['name','shop_name'], 'safe'],
            [['single_price', 'final_price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @author: lhh
     * 创建日期：2020-03-18
     * 修改日期：2020-03-18
     * 名称： currentTotalPrices
     * 功能：获取当前页面商品价格总额
     * 说明：
     * 注意：
     * @param $dataProvider
     * @return float|int
     */
    public static function currentTotalPrices($dataProvider)
    {
        $prices = 0;
        foreach ($dataProvider->getModels() as $item){
            $prices += floatval($item->final_price);
        }
        return $prices;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Goods::find();
        $query->joinWith(['shop']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if ($this->load($params) && !$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'number' => $this->number,
            'weight' => $this->weight,
            'single_price' => $this->single_price,
            'final_price' => $this->final_price,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);



        $query->andFilterWhere(['like',  Goods::tableName().".name", $this->name]);
        $query->andFilterWhere(['like', 'shop.name', $this->shop_name]);

        foreach ($dataProvider->getModels() as $item){
            $item->create_by = date('Y-m-d',$item->create_by);
            $item->update_by = date('Y-m-d',$item->update_by);
        }

        return $dataProvider;
    }




}
