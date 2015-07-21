<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Goods;

/**
 * GoodsSearch represents the model behind the search form about `app\models\Goods`.
 */
class GoodsSearch extends Goods
{

  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price_with_vat', 'price_without_vat', 'increment_price', 'percentage', 'firm_id', 'is_active', ], 'integer'],
            [['name', 'description', 'expiration_date', 'picture'], 'safe'],
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
     * @param integer $firmID 
     *
     * @return ActiveDataProvider
     */
    public function search($params, $firmID )
    {
      /*  if($params != []){
        var_dump($params);die();}*/
        $query = Goods::find()-> where(['like','firm_id',$firmID]);//-> orderBy('id ASC');

        $dataProvider = new ActiveDataProvider(['query' => $query,  ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        


        $query->andFilterWhere([
            
            'is_active' => $this->is_active,
          
        ]);

        $query
            ->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'price_with_vat', $this->price_with_vat])
            ->andFilterWhere(['like', 'price_without_vat', $this->price_without_vat])                
            ->andFilterWhere(['like', 'increment_price', $this->increment_price])
            ->andFilterWhere(['like', 'percentage', $this->percentage])
            ->andFilterWhere(['like', 'expiration_date', $this->expiration_date])               
  
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'picture', $this->picture]);

        return $dataProvider;
    }
}
