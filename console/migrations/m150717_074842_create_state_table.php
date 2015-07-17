<?php

use yii\db\Schema;
use yii\db\Migration;

class m150717_074842_create_state_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';                   
        }
        
        $this->createTable('{{%state}}', [
            'id' => Schema::TYPE_PK,
            'shop_state' => Schema::TYPE_INTEGER . ' NOT NULL',
            'cash_register_start' => Schema::TYPE_INTEGER ,
            'cash_register_end' => Schema::TYPE_INTEGER,            
            'input' => Schema::TYPE_INTEGER,
            'output' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL',
          
        ], $tableOptions); 
        
        $this->insert('{{%state}}', [
            'id' => 1,
            'shop_state' => 1000000,
            'cash_register_start' => 0 ,
            'cash_register_end' => 0,
            'input' => 0 ,
            'output' => 0,                 
            
        ]);
        
        
        
    }

    public function down()
    {
        $this->delete('{{%state}}', ['id' => 1]);
        $this->dropTable('{{%state}}');        
    }
}
