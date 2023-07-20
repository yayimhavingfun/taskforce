<?php

use yii\db\Migration;

/**
 * Class m230621_124442_change_status_id
 */
class m230621_124442_change_status_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('statuses', ['id'=>1], ['id'=>6]);
        $this->update('statuses', ['id'=>2], ['id'=>7]);
        $this->update('statuses', ['id'=>3], ['id'=>8]);
        $this->update('statuses', ['id'=>4], ['id'=>9]);
        $this->update('statuses', ['id'=>5], ['id'=>10]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230621_124442_change_status_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230621_124442_change_status_id cannot be reverted.\n";

        return false;
    }
    */
}
