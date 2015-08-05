<?php

namespace backend\models\search ;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrderItems;

/**
 * OrderItemsSearch represents the model behind the search form about `app\models\OrderItems`.
 */
class OrderItemsSearch extends OrderItems
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'goods_id', 'multiplicity', 'firm_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = OrderItems::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'goods_id' => $this->goods_id,
            'multiplicity' => $this->multiplicity,
            'firm_id' => $this->firm_id,
        ]);

        return $dataProvider;
    }
}
