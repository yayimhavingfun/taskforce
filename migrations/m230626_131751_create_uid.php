<?php

use yii\db\Migration;

/**
 * Class m230626_131751_create_uid
 */
class m230626_131751_create_uid extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'uid', $this->char(64)->unique());
        $this->addColumn('files', 'task_uid', $this->char(64));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230626_131751_create_uid cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230626_131751_create_uid cannot be reverted.\n";

        return false;
    }
    */
}
