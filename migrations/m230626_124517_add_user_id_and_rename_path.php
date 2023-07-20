<?php

use yii\db\Migration;

/**
 * Class m230626_124517_add_user_id_and_rename_path
 */
class m230626_124517_add_user_id_and_rename_path extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('files', 'user_id', $this->integer()->notNull());
        $this->renameColumn('files', 'path', 'file');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230626_124517_add_user_id_and_rename_path cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230626_124517_add_user_id_and_rename_path cannot be reverted.\n";

        return false;
    }
    */
}
