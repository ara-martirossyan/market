<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "firms".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $tel
 * @property string $email
 * @property string $address
 */
class Firms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'firms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['tel'], 'string'],            
            [['tel'], 'udokmeci\yii2PhoneValidator\PhoneValidator','country'=>'DK'],
            ['email','email'],
            [['name', 'email', 'address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'tel' => 'Phone number',
            'email' => 'E-mail address',
            'address' => 'Address',
        ];
    }
    
   
}
