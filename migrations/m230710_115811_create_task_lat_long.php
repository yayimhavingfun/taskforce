<?php

use yii\db\Migration;

/**
 * Class m230710_115811_create_task_lat_long
 */
class m230710_115811_create_task_lat_long extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'lat', $this->decimal(9, 7));
        $this->addColumn('tasks', 'long', $this->decimal(9, 7));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230710_115811_create_task_lat_long cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230710_115811_create_task_lat_long cannot be reverted.\n";

        return false;
    }
    */
}
