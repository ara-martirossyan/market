<?php

use yii\db\Schema;
use yii\db\Migration;

class m150801_013802_create_status_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        
        $this->createTable('{{%status}}', [
            'id' => Schema::TYPE_PK,
            'status_name' => Schema::TYPE_STRING . '(45) NOT NULL',
            'status_value' => Schema::TYPE_SMALLINT . ' NOT NULL',
                ], $tableOptions);


        $this->insert('{{%status}}', [
            'id' => 1,
            'status_name' => 'Active',
            'status_value' => 10,
        ]);
        $this->insert('{{%status}}', [
            'id' => 2,
            'status_name' => 'Pending',
            'status_value' => 5,
        ]);
    }

    public function down()
    {
        
        $this->dropTable('{{%status}}');
        
    }
}
