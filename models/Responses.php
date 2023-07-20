<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "responses".
 *
 * @property int $id
 * @property string $date_add
 * @property int $task_id
 * @property int $performer_id
 * @property int $price
 * @property string $description
 * @property int $rejected
 */
class Responses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_add'], 'safe'],
            [['task_id', 'performer_id', 'price', 'description'], 'required'],
            [['task_id', 'performer_id', 'price', 'rejected'], 'integer'],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_add' => 'Date Add',
            'task_id' => 'Task ID',
            'performer_id' => 'Performer ID',
            'price' => 'Price',
            'description' => 'Description',
            'rejected' => 'Rejected',
        ];
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'performer_id']);
    }
}
