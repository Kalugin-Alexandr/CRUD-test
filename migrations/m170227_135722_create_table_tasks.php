<?php

use yii\db\Migration;
use yii\db\Schema;

class m170227_135722_create_table_tasks extends Migration
{
    public function up()
    {
        $this->createTable('tasks', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING.'(30) NOT NULL',
            'description' => Schema::TYPE_STRING.'(30)',
            'status' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT TRUE',
            'user_id' => Schema::TYPE_INTEGER.' NOT NULL'
        ] , 'ENGINE=InnoDB CHARSET=utf8');
        $this->addForeignKey(
            'fk-user_id',
            'tasks',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('Tasks');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
