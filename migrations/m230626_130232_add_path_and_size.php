<?php

use yii\db\Migration;

/**
 * Class m230626_130232_add_path_and_size
 */
class m230626_130232_add_path_and_size extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('files', 'path', $this->string(256)->notNull());
        $this->addColumn('files', 'size', $this->string(64)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230626_130232_add_path_and_size cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230626_130232_add_path_and_size cannot be reverted.\n";

        return false;
    }
    */
}
