<?php

use yii\db\Migration;

/**
 * Class m230626_132233_remove_task_id
 */
class m230626_132233_remove_task_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('files', 'task_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230626_132233_remove_task_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230626_132233_remove_task_id cannot be reverted.\n";

        return false;
    }
    */
}
