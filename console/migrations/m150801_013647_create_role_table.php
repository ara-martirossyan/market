<?php

use yii\db\Schema;
use yii\db\Migration;

class m150801_013647_create_role_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        
        $this->createTable('{{%role}}', [
            'id' => Schema::TYPE_PK,
            'role_name' => Schema::TYPE_STRING . '(45) NOT NULL',
            'role_value' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                ], $tableOptions);

        $this->insert('{{%role}}', [
            'id' => 1,
            'role_name' => 'user',
            'role_value' => 10,
        ]);
        $this->insert('{{%role}}', [
            'id' => 2,
            'role_name' => 'admin',
            'role_value' => 20,
        ]);
        $this->insert('{{%role}}', [
            'id' => 3,
            'role_name' => 'SuperUser',
            'role_value' => 30,
        ]);
    }

    public function down()
    {
        
        $this->dropTable('{{%role}}');
        
    }
}
