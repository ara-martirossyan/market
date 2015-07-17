<?php

namespace backend\models;
use yii\db\ActiveRecord;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "state".
 *
 * @property integer $id
 * @property integer $shop_state
 * @property integer $cash_register_start
 * @property integer $cash_register_end
 * @property string $date
 * @property integer $input
 * @property integer $output
 */
class State extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'state';
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
            [['shop_state'], 'required'],
            [['shop_state', 'cash_register_start', 'cash_register_end', 'input', 'output'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_state' => 'Shop State',
            'cash_register_start' => 'Cash Register Start',
            'cash_register_end' => 'Cash Register End',
            'created_at' => 'First Registered', 
            'updated_at' => 'Last Updated',
            'input' => 'Input',
            'output' => 'Output',
        ];
    }
}
