<?php

use yii\db\Migration;

/**
 * Class m230616_155750_add_statuses
 */
class m230616_155750_add_statuses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('statuses', ['name' => 'new']);
        $this->insert('statuses', ['name' => 'cancelled']);
        $this->insert('statuses', ['name' => 'in_progress']);
        $this->insert('statuses', ['name' => 'completed']);
        $this->insert('statuses', ['name' => 'failed']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230616_155750_add_statuses cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230616_155750_add_statuses cannot be reverted.\n";

        return false;
    }
    */
}
