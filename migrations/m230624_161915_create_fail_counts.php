<?php

use yii\db\Migration;

/**
 * Class m230624_161915_create_fail_counts
 */
class m230624_161915_create_fail_counts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'fail_count', $this->integer()->unsigned()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230624_161915_create_fail_counts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230624_161915_create_fail_counts cannot be reverted.\n";

        return false;
    }
    */
}
