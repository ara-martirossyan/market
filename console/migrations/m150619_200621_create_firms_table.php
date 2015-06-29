<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_200621_create_firms_table extends Migration
{
        public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }     
        
        $this->createTable('{{%firms}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT ,
            'tel' => Schema::TYPE_STRING ,
            'email' => Schema::TYPE_STRING  ,
            'address' => Schema::TYPE_STRING  ,           
        ], $tableOptions); 
        
    }

    public function down()
    {
        $this->dropTable('{{%firms}}');
       
    }
}
