<?php

use yii\db\Migration;

/**
 * Class m181225_145907_accesstoken
 */
class m181225_145907_accesstoken extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customers}}','AccessToken','string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customers}}','AccessToken');
        echo "m181225_145907_accesstoken cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181225_145907_accesstoken cannot be reverted.\n";

        return false;
    }
    */
}
