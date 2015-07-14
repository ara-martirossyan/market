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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    
    
    public function searchMonthly($params)
    {
        return array( 1 =>  $this->searchMonthReport('1', $params),
                      2 =>  $this->searchMonthReport('2', $params),
                      3 =>  $this->searchMonthReport('3', $params),
                      4 =>  $this->searchMonthReport('4', $params),
                      5 =>  $this->searchMonthReport('5', $params),
                      6 =>  $this->searchMonthReport('6', $params),
                      7 =>  $this->searchMonthReport('7', $params),
                      8 =>  $this->searchMonthReport('8', $params),
                      9 =>  $this->searchMonthReport('9', $params),
                     10 =>  $this->searchMonthReport('10', $params),
                     11 =>  $this->searchMonthReport('11', $params),
                     12 =>  $this->searchMonthReport('12', $params),
                    
                    );
    }
    
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
     * 
     * @param type $month int
     * @param type $params
     * @return ActiveDataProvider
     */
    public function searchMonthReport($month, $params) {

        $month <= 9 ? ($month = '-0' . $month . '-') : ($month = '-' . $month . '-');
        
        $query = Reports::find();
        $query->joinWith(['user']);        

        $dataProvider = new ActiveDataProvider(
                array(
            'query' => $query->where(['like', 'date', $month]),
            'pagination' => array('pageSize' => 20,)
                )
        );

        $dataProvider->sort->attributes['user'] = [

            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];       
        
        if (!($this->load($params) && $this->validate())) {                    
               // when the page loads first time and nothing is typed in the searchbox
            $q = (new \yii\db\Query()); // the summed result of the lowest row in reports
                    $q->select([ '" " as `id`',
                    '" " as `user_id`',
                    'sum(revenue)',
                    'sum(expense_on_goods)',
                    'sum(other_expenses)',
                    'sum(salary)',
                    '" " as`day_type`',
                    '" " as `date`', 
                    '" " as `created_at`', 
                    '" " as `updated_at`'
                ])->from('reports')
                ->andwhere(['like', 'date', $month]);
                    
            $query -> union($q);
            
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'user.username', $this->user])
                ->andFilterWhere(['like', 'revenue', $this->revenue])
                ->andFilterWhere(['like', 'expense_on_goods', $this->expense_on_goods])
                ->andFilterWhere(['like', 'other_expenses', $this->other_expenses])
                ->andFilterWhere(['like', 'salary', $this->salary])
                ->andFilterWhere(['like', 'day_type', $this->day_type])
                ->andFilterWhere(['like', 'date', $this->date]);
       
         
        $searchParams = Yii::$app->request->queryParams['ReportsSearch'];
        if (
                $searchParams["revenue"] == "" &&
                $searchParams["expense_on_goods"] == "" &&
                $searchParams["other_expenses"] == "" &&
                $searchParams["salary"] == ""
        ) {
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
                    ])->from('reports')
                    ->andWhere(['like', 'user.username', $this->user])
                    ->andWhere(['like', 'day_type', $this->day_type])                    
                    ->andWhere(['like', 'date', $this->date])
                    ->andWhere(['like', 'date', $month]);


            $query->union($q);
        }

        return $dataProvider;
    }
    
    private function filter(&$query){
        $query->andFilterWhere(['like', 'user.username', $this->user])
                ->andFilterWhere(['like', 'revenue', $this->revenue])
                ->andFilterWhere(['like', 'expense_on_goods', $this->expense_on_goods])
                ->andFilterWhere(['like', 'other_expenses', $this->other_expenses])
                ->andFilterWhere(['like', 'salary', $this->salary])
                ->andFilterWhere(['like', 'day_type', $this->day_type])
                ->andFilterWhere(['like', 'date', $this->date]);
    }
    
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
