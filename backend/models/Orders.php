<?php

namespace backend\models;

use backend\models\Goods;
use yii\db\ActiveRecord;
use yii\db\Expression;

//use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $firm_id
 * @property integer $price_with_vat
 * @property integer $price_without_vat
 * @property integer $increment_price
 * @property integer $total_goods
 * @property integer $total_types
 * @property string  $created_at
 * @property string  $updated_at
 * 
 * @property OrderItems[] $orderItems
 * @property Firms $firm
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
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
            [['firm_id', 'price_with_vat', 'price_without_vat', 'increment_price', 'total_goods', 'total_types'], 'required'],
            [['firm_id', 'price_with_vat', 'price_without_vat', 'increment_price', 'total_goods', 'total_types'], 'integer'],
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
            'firm_id' => 'Firm ID',
            'price_with_vat' => 'Price With Vat',
            'price_without_vat' => 'Price Without Vat',
            'increment_price' => 'Increment Price',
            'total_goods' => 'Total Goods',
            'total_types' => 'Total Types',
            'created_at' => 'Create Date',
            'updated_at' => 'Update Date'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFirm()
    {
        return $this->hasOne(Firms::className(), ['id' => 'firm_id']);
    }

    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $state_max_id = \backend\models\State::find()->max('id');
            $state_model_with_max_id = \backend\models\State::findOne($state_max_id);
            
            $old_shop_state = $state_model_with_max_id->shop_state;

            $new_state = new State;
            $new_state->shop_state = $old_shop_state + $this->increment_price;
            $new_state->cash_register_start = $state_model_with_max_id->cash_register_end;
            $new_state->cash_register_end = $state_model_with_max_id->cash_register_end - $this->increment_price;
            $new_state->output = 0;
            $new_state->input = $this->increment_price;

            $new_state->save();

            return true;
        } else {
            return false;
        }
    }
    
    /**
     * goodsIdList = [goodID => quantity]
     * @param array $goodsIdList
     * @return int $orderID
     */
    public static function saveOrder($goodsIdList){
        /* all the goods in $goodsIdList are ordered from the same firm */
        $goodID = key($goodsIdList);
        $firmID = Goods::findOne($goodID)->firm_id;
        $totalGoods = $priceWithVat = $priceWithoutVat = $incrementPrice = 0;        
        foreach ($goodsIdList as $id => $quantity){
            $totalGoods += $quantity;
            $good = Goods::findOne($id);
            $priceWithVat += ($good->price_with_vat) * $quantity;
            $priceWithoutVat += ($good->price_without_vat) * $quantity;
            $incrementPrice += ($good->increment_price) * $quantity;
        }
        
        $order = new Orders();
        $order->firm_id = $firmID;
        $order->price_with_vat = $priceWithVat;
        $order->price_without_vat = $priceWithoutVat;
        $order->increment_price = $incrementPrice;
        $order->total_types = count($goodsIdList);
        $order->total_goods = $totalGoods;

        $order->save();
        $orderID = $order->getPrimaryKey();
        return $orderID;
    }

}


 