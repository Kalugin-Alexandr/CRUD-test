<?php

use yii\db\Migration;
use yii\db\Schema;

class m170227_121825_create_table_users extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING.'(30) NOT NULL UNIQUE',
            'mail' => Schema::TYPE_STRING.'(30) NOT NULL UNIQUE',
            'password' => Schema::TYPE_STRING.'(60) NOT NULL',
            'status' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT TRUE',
            'group_id' => Schema::TYPE_INTEGER.' NOT NULL DEFAULT 1',
            'auth_key' => Schema::TYPE_STRING.'(32) UNIQUE',
            'created_at' => Schema::TYPE_DATETIME.' NOT NULL DEFAULT NOW()',
            'updated_at' => Schema::TYPE_DATETIME.' NOT NULL DEFAULT NOW()'
        ] , 'ENGINE=InnoDB CHARSET=utf8');
        $this->insert('Users', array(
            'name' => 'Admin',
            'mail' => 'admin@gmail.com',
            'password' => Yii::$app->security->generatePasswordHash('111111'),
            'group_id' => '1'
        ));
        $this->addForeignKey(
            'fk-group_id',
            'users',
            'group_id',
            'groupUser',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('Users');
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
