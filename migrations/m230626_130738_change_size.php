<?php

use yii\db\Migration;

/**
 * Class m230626_130738_change_size
 */
class m230626_130738_change_size extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('files', 'size',$this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230626_130738_change_size cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230626_130738_change_size cannot be reverted.\n";

        return false;
    }
    */
}
