<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Reports;

/**
 * ReportsSearch represents the model behind the search form about `common\models\Reports`.
 */
class ReportsSearch extends Reports
{ 

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'revenue', 'expense_on_goods', 'other_expenses', 'salary', 'day_type'], 'integer'],
            [['date', 'created_at', 'updated_at', ], 'safe'],
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
        $userID = Yii::$app->user->identity->id;
        $dataProvider = new ActiveDataProvider([
            'query' => $query->where(['like', 'date', $year.'-'.$month])->andFilterWhere(['user_id' => $userID]),
            //'pagination' => array('pageSize' => 30,)                
        ]);                 
        
        if (!($this->load($params) && $this->validate())) {                    
               // when the page loads first time and nothing is typed in the searchbox
            $q = $this->totalQuery($year, $month, $userID);                    
            $query -> union($q);
            
            return $dataProvider;
        }

        $query  ->andFilterWhere(['like', 'revenue', $this->revenue])
                ->andFilterWhere(['like', 'date', $this->date]);     

        return $dataProvider;
    }
    
    /**
     * query for bottom row sum of revenue
     * $month is with leading zero like 06 
     * @param type $year int
     * @param type $month string
     * @param type $userID int
     * @return type \yii\db\QueryTrait 
     */
    private function totalQuery($year, $month, $userID) {
        $q = Reports::find();// the summed result of the lowest row in reports
                    $q->select([ '" " as `id`',
                    '" " as `user_id`',
                    'sum(revenue)',
                    '" " as `expense_on_goods`',
                    '" " as `other_expenses`',
                    '" " as `salary`',
                    '" " as `day_type`',
                    '" " as `date`', 
                    '" " as `created_at`', 
                    '" " as `updated_at`'
                ])->from('reports')
                ->andFilterWhere(['like', 'date', $year.'-'.$month])
                ->andFilterWhere(['user_id' => $userID]);
                    
        return $q;
    }
    
    /**
     * the array  of report ids reported by the current user in mentioned $month of the $year
     * where the keys(key+1) of the array represent the working day numbers of the user
     * @param type $year int
     * @param type $month int
     * @return type array
     */
    public function listOfReportsIDbyCurrentUser($year, $month) {
        
       if($month <= 9)
       {
           $month = '0' . $month;
       }
       $userID = Yii::$app->user->identity->id;
       $arrayID =    yii\helpers\ArrayHelper::map(
                  Reports::find()->where(['like', 'date', $year."-".$month])->andFilterWhere(['user_id' => $userID])->all(), 
                  'id',
                  'id'
               );
         
       return array_values($arrayID) ;
    }
    
    /**
     * 
     * @return ActiveDataProvider
     */
    public function searchPerformance() {
        
        $userID = Yii::$app->user->identity->id;
        $query = Reports::find()->select([
            'MONTH(date) as "month"',
            'SUM(revenue) as "totalRevenue"',
            'AVG(salary) as "averageSalaryPerDay"',
            'COUNT(id) as "numberOfWorkedDays"',
            'SUM(salary) as "totalSalary"',
           
        ])->from('reports')
          ->andFilterWhere(['user_id' => $userID])
          ->andFilterWhere(['<=', "date", Date('Y-m-d')])
          ->andFilterWhere(['>=', "date", $this->currentDateMinusSixMonths()])
          ->groupBy("MONTH(date)")->orderBy('date');   

        $dataProvider = new ActiveDataProvider( ['query' => $query,] );        
        
        return $dataProvider;
    }
    
    /**
     * say current date is 2015-06-28
     * the function returns 2014-12-01
     * @return string
     */
    private function currentDateMinusSixMonths() {
        $year = Date('Y');
        $month = Date('n');        
        if($month<=6){
            $month = 12+$month-6;
            --$year; 
        }else{
            $month = $month-6;
        }
        if($month <= 9){
            $month = "0".$month;
        } 
        $date = $year."-".$month."-01";
        return $date;
    }

}
