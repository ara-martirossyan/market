<?php

namespace backend\models;

use backend\models\Goods;
//use Yii;

/**
 * This is the model class for table "order_items".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $goods_id
 * @property integer $multiplicity
 * @property integer $firm_id
 *
 * @property Orders $order
 * @property Goods $goods
 * @property Firms $firm
 */
class OrderItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'goods_id', 'multiplicity', 'firm_id'], 'required'],
            [['order_id', 'goods_id', 'multiplicity', 'firm_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'goods_id' => 'Goods ID',
            'multiplicity' => 'Multiplicity',
            'firm_id' => 'Firm ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasMany(Orders::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ['id' => 'goods_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFirm() {
        return $this->hasOne(Firms::className(), ['id' => 'firm_id']);
    }

    /**
     * goodsIdList = [goodID => quantity]
     * @param int $orderID
     * @param array $goodsIdList
     */
    public static function saveOrderItems($orderID, $goodsIdList) {
        foreach ($goodsIdList as $id => $quantity) {
            $orderItemModel = new OrderItems();
            $orderItemModel->order_id = $orderID;
            $orderItemModel->goods_id = $id;
            $orderItemModel->multiplicity = $quantity;
            $orderItemModel->firm_id = Goods::findOne($id)->firm_id;
            $orderItemModel->save();
        }
    }

}
