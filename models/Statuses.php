<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "statuses".
 *
 * @property int $id
 * @property string|null $name
 */
class Statuses extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_CANCELLED = 2;
    const STATUS_IN_PROGRESS = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_FAILED = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
