<?php

use yii\db\Migration;
use yii\db\Schema;
/**
 * Class m181225_131326_customers
 */
class m181225_131326_customers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName ==='mysql' )
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=INNODB';
        $this->createTable('{{%customers}}',[
            'id'=>Schema::TYPE_PK,//id -авто інкримент з primary key
            'username'=>$this->string(32)->notNull(),
            'auth_key'=>$this->string(32)->notNull(),
            'password_hash'=>$this->string()->notNull(),
            'password_reset_token'=>$this->string()->notNull()->unique(),
            'email'=>$this->string(255)->notNull()->unique(),
            'status'=>$this->integer()->notNull()->defaultValue(1),//1- не підтверджено
            'created_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ],$tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%customers}}');

        echo "m181211_165930_posts cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181225_131326_customers cannot be reverted.\n";

        return false;
    }
    */
}
