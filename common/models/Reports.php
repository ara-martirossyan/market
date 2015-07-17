<?php

namespace common\models;


use yii\db\ActiveRecord;
use yii\db\Expression;

use yii\data\ActiveDataProvider;


use Yii;

/**
 * This is the model class for table "reports".
 *
 * @property integer $id
 * @property integer $revenue
 * @property integer $expense_on_goods
 * @property integer $other_expenses
 * @property integer $salary
 * @property integer $day_type
 * @property string $date
 * @property string $create_date
 */
class Reports extends \yii\db\ActiveRecord
{
    // r=reports/performance fields
    public $month;
    public $totalRevenue;
    public $averageSalaryPerDay;
    public $numberOfWorkedDays;
    public $totalSalary;
       
    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reports';
    }
    
    public function behaviors()
    {
        return [
            'timestamp' => [ 
                'class' => 'yii\behaviors\TimestampBehavior', 
                'attributes' => [ 
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'], 
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'], 
                    ],
                'value' => new Expression('NOW()'), 
                ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['revenue', 'day_type', 'date', 'user_id'], 'required'],
            [['revenue', 'expense_on_goods', 'other_expenses', 'salary', 'day_type'], 'integer'],
            [['date', 'created_at', 'updated_at', ], 'safe'],
            [['month','totalRevenue','averageSalaryPerDay','numberOfWorkedDays','totalSalary'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'user' => Yii::t('app', 'Reported by'),
            'revenue' => 'Revenue',
            'expense_on_goods' => 'Expenses on goods',
            'other_expenses' => 'Other expenses',
            'salary' => 'Salary',
            'day_type' => 'Day type',
            'date' => 'Date',
            'created_at' => 'First Reported', 
            'updated_at' => 'Last Updated',
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']); 
    }  
      
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            
            $state_max_id = \backend\models\State::find()->max('id');
            $state_model_with_max_id = \backend\models\State::findOne($state_max_id);
            
            if ($this->isNewRecord) {

                $old_shop_state = $state_model_with_max_id->shop_state;
                $new_state = new \backend\models\State;
                $new_state->shop_state = $old_shop_state - $this->revenue;
                $new_state->cash_register_start = $state_model_with_max_id->cash_register_end;
                $new_state->cash_register_end = $state_model_with_max_id->cash_register_end + $this->revenue;
                $new_state->output = $this->revenue;
                $new_state->input = 0;

                $new_state->save();
            } else {
                $updating_model = $state_model_with_max_id;
                $previous_id = \backend\models\State::find()->select('max(id)')->andWhere(['<', 'id', $state_max_id]);
                $previous_model = \backend\models\State::findOne($previous_id);              

                $updating_model->shop_state = $previous_model->shop_state - $this->revenue;
                $updating_model->cash_register_start = $previous_model->cash_register_end;
                $updating_model->cash_register_end = $previous_model->cash_register_end + $this->revenue;
                $updating_model->output = $this->revenue;
                $updating_model->input = 0;

                $updating_model->save();
            }
            return true;
        } else {
            return false;
        }
    }

    public function beforeValidate() 
    {
        if ($this->user_id == null) 
        {
            $user_id = Yii::$app->user->identity->id;
            $this->user_id = $user_id;
        }
        return parent::beforeValidate();
    }
}
