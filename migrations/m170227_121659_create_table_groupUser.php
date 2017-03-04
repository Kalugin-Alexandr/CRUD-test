<?php

use yii\db\Migration;
use yii\db\Schema;

class m170227_121659_create_table_groupUser extends Migration
{
    public function up()
    {
        $this->createTable('groupUser', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING.'(15) NOT NULL UNIQUE',
        ] , 'ENGINE=InnoDB CHARSET=utf8');
        $this->batchInsert('groupUser', ['name'],[
             ['manager'], ['executor'],
        ]);
    }

    public function down()
    {
        $this->dropTable('groupUser');
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
