<?php

use yii\db\Migration;

/**
 * Class m230720_105041_user_fields
 */
class m230720_105041_user_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('users', 'skype');
        $this->addColumn('users', 'hide_contacts', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230720_105041_user_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230720_105041_user_fields cannot be reverted.\n";

        return false;
    }
    */
}
