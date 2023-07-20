<?php

use yii\db\Migration;

/**
 * Class m230628_124559_add_task_id_remove_uid
 */
class m230628_124559_add_task_id_remove_uid extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('files', 'task_uid');
        $this->addColumn('files', 'task_id', $this->integer()->notNull());
        $this->dropColumn('tasks', 'uid');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230628_124559_add_task_id_remove_uid cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230628_124559_add_task_id_remove_uid cannot be reverted.\n";

        return false;
    }
    */
}
