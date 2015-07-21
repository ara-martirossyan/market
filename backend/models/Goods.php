<?php

namespace backend\models;

use Yii;


/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $price_with_vat
 * @property integer $price_without_vat
 * @property integer $increment_price
 * @property integer $percentage
 * @property integer $firm_id
 * @property string $expiration_date
 * @property integer $is_active
 * @property string $picture
 *
 * @property Firms $firm
 */
class Goods extends \yii\db\ActiveRecord
{
   
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price_without_vat', 'increment_price', 'firm_id', 'is_active'], 'required'],
            [['description'], 'string'],
            [['price_with_vat', 'price_without_vat', 'increment_price', 'percentage', 'firm_id', 'expiration_date', 'is_active', ], 'integer'], 
            [['name'], 'string', 'max' => 255],
            [['picture'] , 'file' ],
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
            'price_with_vat' => 'Price With Vat',
            'price_without_vat' => 'Price Without Vat',
            'increment_price' => 'Increment Price',
            'percentage' => 'Percentage',
            'firm_id' => 'Firm ID',
            'expiration_date' => 'Expiration Date',
            'is_active' => 'Is Active',
            'picture' => 'Picture',
          
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFirm()
    {
        return $this->hasOne(Firms::className(), ['id' => 'firm_id']);
    }
        
     /** 
     * @return array 
     * makes an associative array of all goods-related firms
     * where key is the firm id and value is the firm name 
     * ['id' => 'name']
      * $model->firmList
     */
    public static function getFirmList() 
    {
        $firmArray = Firms::find()->asArray()->all(); 
        return yii\helpers\Arrayhelper::map($firmArray, 'id', 'name');
    }  
    
    public function beforeSave($insert) 
    {      
        if (parent::beforeSave($insert)) {
          $oldFileName = $this->picture;               
          \common\models\UploadHelpers::saveFile( $this, 'picture', $oldFileName, Yii::$app->basePath.'/web/uploads' );
        
          $this->price_with_vat = (int)(1.1 * ($this->price_without_vat) );
            
          $this->percentage = (int) (100 * ($this->increment_price)/($this->price_without_vat) - 100);  
         
          return true;
        }else{
          return false;
        }
    }

    /**
     *@return integer first key of firms array
     */    
    public function getFirstKeyOfFirm()
    {
        $arr = $this->firmList;
        reset( $arr );
        $first_key = key($arr);
        
        return $first_key;
    }
    
}
