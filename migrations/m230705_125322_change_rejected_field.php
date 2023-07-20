<?php

use yii\db\Migration;

/**
 * Class m230705_125322_change_rejected_field
 */
class m230705_125322_change_rejected_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('responses', 'rejected', $this->tinyInteger()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230705_125322_change_rejected_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230705_125322_change_rejected_field cannot be reverted.\n";

        return false;
    }
    */
}
