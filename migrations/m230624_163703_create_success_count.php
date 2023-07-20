<?php

use yii\db\Migration;

/**
 * Class m230624_163703_create_success_count
 */
class m230624_163703_create_success_count extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'success_count', $this->integer()->unsigned()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230624_163703_create_success_count cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230624_163703_create_success_count cannot be reverted.\n";

        return false;
    }
    */
}
