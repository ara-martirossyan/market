<?php

use yii\db\Schema;
use yii\db\Migration;

class m150802_101010_create_orders_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        
        $this->createTable('{{%orders}}', [
            'id' => Schema::TYPE_PK,
            'firm_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'price_with_vat' => Schema::TYPE_INTEGER. ' NOT NULL',
            'price_without_vat' => Schema::TYPE_INTEGER. ' NOT NULL',
            'increment_price' => Schema::TYPE_INTEGER. ' NOT NULL',
            'total_goods' => Schema::TYPE_INTEGER. ' NOT NULL',
            'total_types' => Schema::TYPE_INTEGER. ' NOT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('idx_orders_firm_id', '{{%orders}}', 'firm_id','{{%firms}}','id' );
        
        $this->createTable('{{%order_items}}', [
            'id' => Schema::TYPE_PK,
            'order_id' => Schema::TYPE_INTEGER. ' NOT NULL',
            'goods_id' => Schema::TYPE_INTEGER. ' NOT NULL',
            'multiplicity' => Schema::TYPE_INTEGER. ' NOT NULL',
            'firm_id' => Schema::TYPE_INTEGER. ' NOT NULL',
        ], $tableOptions); 
        $this->addForeignKey('idx_order_items_order_id', '{{%order_items}}', 'order_id','{{%orders}}','id' );
        $this->addForeignKey('idx_order_items_goods_id', '{{%order_items}}', 'goods_id','{{%goods}}','id' );
        $this->addForeignKey('idx_order_items_firm_id', '{{%order_items}}', 'firm_id','{{%firms}}','id' );
    }

    public function down()
    {
        $this->dropTable('{{%orders}}');
        $this->dropTable('{{%order_items}}');
    }
}
