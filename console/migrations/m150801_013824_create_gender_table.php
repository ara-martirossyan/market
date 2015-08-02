<?php

use yii\db\Schema;
use yii\db\Migration;

class m150801_013824_create_gender_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        
        $this->createTable('{{%gender}}', [
            'id' => Schema::TYPE_PK,
            'gender_name' => Schema::TYPE_STRING . '(45) NOT NULL',
            
        ], $tableOptions); 
        
        $this->insert('{{%gender}}', [
            'id' => 1,
            'gender_name' => 'male',
        ]);
        $this->insert('{{%gender}}', [
            'id' => 2,
            'gender_name' => 'female',
        ]);
        
    }

    public function down()
    {
        
        $this->dropTable('{{%gender}}');
        
    }
}
