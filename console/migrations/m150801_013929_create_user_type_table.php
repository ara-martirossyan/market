<?php

use yii\db\Schema;
use yii\db\Migration;

class m150801_013929_create_user_type_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        
        $this->createTable('{{%user_type}}', [
            'id' => Schema::TYPE_PK,
            'user_type_name' => Schema::TYPE_STRING . '(45)',
            'user_type_value' =>Schema::TYPE_INTEGER . '(11) NOT NULL',
            
        ], $tableOptions); 
        
        $this->insert('{{%user_type}}', [
            'id' => 1,
            'user_type_name' => 'Free',
            'user_type_value' => 10,
        ]);
        $this->insert('{{%user_type}}', [
            'id' => 2,
            'user_type_name' => 'Paid',
            'user_type_value' => 30,
        ]);
        
    }

    public function down()
    {
        
        $this->dropTable('{{%user_type}}');
        
    }
}
