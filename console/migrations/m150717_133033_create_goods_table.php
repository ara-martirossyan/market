<?php

use yii\db\Schema;
use yii\db\Migration;

class m150717_133033_create_goods_table extends Migration
{
     public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        
        $this->createTable('{{%goods}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'price_with_vat' => Schema::TYPE_INTEGER.' NOT NULL',
            'price_without_vat' => Schema::TYPE_INTEGER .' NOT NULL',
            'increment_price' => Schema::TYPE_INTEGER .' NOT NULL',
            'percentage' => Schema::TYPE_INTEGER.' NOT NULL',
            'firm_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'expiration_date' => Schema::TYPE_INTEGER ,
            'is_active' => Schema::TYPE_SMALLINT. ' NOT NULL',  
            'picture' => Schema::TYPE_STRING ,
        ], $tableOptions); 
        $this->addForeignKey('idx_goods_firm_id', '{{%goods}}', 'firm_id','{{%firms}}','id' );
    }

    public function down()
    {
        $this->dropTable('{{%goods}}');        
    }
}
