<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190205_163412_customers_temp
 */
class m190205_163412_customers_temp extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName ==='mysql' )
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=INNODB';
        $this->createTable('{{%customers_temp}}',[
            'id'=>Schema::TYPE_PK,//id -авто інкримент з primary key
            'username'=>$this->string(32)->notNull(),
            'auth_key'=>$this->string(32)->notNull(),
            'password_hash'=>$this->string()->notNull(),
            'password_reset_token'=>$this->string()->notNull()->unique(),
            'email'=>$this->string(255)->notNull()->unique(),
            'status'=>$this->integer()->notNull()->defaultValue(1),//1- не підтверджено
            'created_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'AccessToken'=>$this->string()
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customers_temp}}');
        echo "m190205_163412_customers_temp cannot be reverted.\n";
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190205_163412_customers_temp cannot be reverted.\n";

        return false;
    }
    */
}
