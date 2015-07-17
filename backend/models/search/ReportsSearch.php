<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Reports;

/**
 * ReportsSearch represents the model behind the search form about `app\models\Reports`.
 */
class ReportsSearch extends Reports
{
    public $user;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'revenue', 'expense_on_goods', 'other_expenses', 'salary', 'day_type'], 'integer'],
            [['date', 'created_at', 'updated_at', 'user'], 'safe'],
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
     * @param type $year int
     * @param string $month int
     * @param type $params Yii::$app->request->queryParams
     * @return ActiveDataProvider
     */
    public function search($year, $month, $params) {
        if($month <= 9){$month = '0'.$month;}
        $query = Reports::find();
        $query->joinWith(['user']);        

        $dataProvider = new ActiveDataProvider([            
            'query' => $query->where(['like', 'date', $year.'-'.$month]),
            'pagination' => array('pageSize' => 30,)
        ]);

        $dataProvider->sort->attributes['user'] = [

            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];
        
        if (!($this->load($params) && $this->validate())) {                    
               // when the page loads first time and nothing is typed in the searchbox
            $q = $this->sumOfReports()->andwhere(['like', 'date', $year."-".$month]);                    
            $query -> union($q);            
            return $dataProvider;
        }
        
        $this->filter($query);
        
        $searchParams = Yii::$app->request->queryParams['ReportsSearch'];
        if (
                $searchParams["revenue"] == "" &&
                $searchParams["expense_on_goods"] == "" &&
                $searchParams["other_expenses"] == "" &&
                $searchParams["salary"] == ""
        ) {
            $q = $this->sumOfReports()
                    ->andWhere(['like', 'user.username', $this->user])
                    ->andWhere(['like', 'day_type', $this->day_type])                    
                    ->andWhere(['like', 'date', $this->date])
                    ->andWhere(['like', 'date', $year."-".$month]);
            $query->union($q);
        }
        
         return $dataProvider;
    }

    /**
     * query is passed by reference
     * @param type $query
     */
    private function filter(&$query){
        $query->andFilterWhere(['like', 'user.username', $this->user])
                ->andFilterWhere(['like', 'revenue', $this->revenue])
                ->andFilterWhere(['like', 'expense_on_goods', $this->expense_on_goods])
                ->andFilterWhere(['like', 'other_expenses', $this->other_expenses])
                ->andFilterWhere(['like', 'salary', $this->salary])
                ->andFilterWhere(['like', 'day_type', $this->day_type])
                ->andFilterWhere(['like', 'date', $this->date]);
    }
    
    /**
     * finds the row of summed fields from reports
     * @return type query
     */
    private function sumOfReports(){
        $q = Reports::find();
            $q->joinWith(['user']);
            $q->select([ '" " as `id`',
                        ' " " as `user_id`',
                        'sum(revenue)',
                        'sum(expense_on_goods)',
                        'sum(other_expenses)',
                        'sum(salary)',
                        '" " as`day_type`',
                        '" " as `date`',
                        '" " as `created_at`',
                        '" " as `updated_at`'
                    ])->from('reports');
            
        return $q;
    }

}
