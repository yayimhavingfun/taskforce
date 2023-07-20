<?php

use yii\db\Migration;

/**
 * Class m230621_123636_change_statuses
 */
class m230621_123636_change_statuses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('statuses', ['id' => 1]);
        $this->delete('statuses', ['id' => 2]);
        $this->delete('statuses', ['id' => 3]);
        $this->delete('statuses', ['id' => 4]);
        $this->delete('statuses', ['id' => 5]);

        $this->insert('statuses', ['name' => 'Новое']);
        $this->insert('statuses', ['name' => 'Отменено']);
        $this->insert('statuses', ['name' => 'В работе']);
        $this->insert('statuses', ['name' => 'Завершено']);
        $this->insert('statuses', ['name' => 'Провалено']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230621_123636_change_statuses cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230621_123636_change_statuses cannot be reverted.\n";

        return false;
    }
    */
}
