<?php

use yii\db\Schema;
use yii\db\Migration;

class m150622_201839_create_reports_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        
        $this->createTable('{{%reports}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'revenue' => Schema::TYPE_INTEGER . ' NOT NULL',
            'expense_on_goods' => Schema::TYPE_INTEGER ,
            'other_expenses' => Schema::TYPE_INTEGER,
            'salary' => Schema::TYPE_INTEGER ,
            'day_type' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'date' => Schema::TYPE_DATE. ' NOT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            
        ], $tableOptions); 
        
        $this->addForeignKey('idx_reports_user_id', '{{%reports}}', 'user_id','{{%user}}','id' );
        
    }

    public function down()
    {
        
        $this->dropTable('{{%reports}}');
        
    }
    
    /*
     * new
     */
}
