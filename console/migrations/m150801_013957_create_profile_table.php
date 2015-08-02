<?php

use yii\db\Schema;
use yii\db\Migration;

class m150801_013957_create_profile_table extends Migration
{
	public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
		
		    $this->createTable('{{%profile}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . '(11) NOT NULL UNIQUE',
            'first_name' => Schema::TYPE_TEXT,
            'last_name' => Schema::TYPE_TEXT,
            'birthdate' => Schema::TYPE_DATE,
            'gender_id' => Schema::TYPE_INTEGER . ' NOT NULL UNIQUE',

            'created_at' => Schema::TYPE_DATETIME ,
            'updated_at' => Schema::TYPE_DATETIME ,
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%profile}}');
    }
}
