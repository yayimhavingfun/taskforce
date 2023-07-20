<?php

use yii\db\Migration;

/**
 * Class m230705_103117_drop_file_from_files
 */
class m230705_103117_drop_file_from_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('files', 'file');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230705_103117_drop_file_from_files cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230705_103117_drop_file_from_files cannot be reverted.\n";

        return false;
    }
    */
}
