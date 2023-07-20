<?php

use yii\db\Migration;

/**
 * Class m230626_132447_add_city_id
 */
class m230626_132447_add_city_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'city_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230626_132447_add_city_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230626_132447_add_city_id cannot be reverted.\n";

        return false;
    }
    */
}
