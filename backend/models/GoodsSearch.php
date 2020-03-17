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



        $query->andFilterWhere(['like', 'goods.name', $this->name]);
        $query->andFilterWhere(['like', 'shop.name', $this->shop_name]);

        foreach ($dataProvider->getModels() as $item){
            $item->create_by = date('Y-m-d',$item->create_by);
            $item->update_by = date('Y-m-d',$item->update_by);
        }

        return $dataProvider;
    }




}
