<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property string $date_add
 * @property int $task_id
 * @property int $author_id
 * @property int $score
 * @property string $text
 * @property int $user_id
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_add'], 'safe'],
            [['task_id', 'author_id', 'score', 'text', 'user_id'], 'required'],
            [['task_id', 'author_id', 'score', 'user_id'], 'integer'],
            [['text'], 'string'],
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
            'author_id' => 'Author ID',
            'score' => 'Score',
            'text' => 'Text',
            'user_id' => 'User ID',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Users::class, ['id' => 'author_id']);
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id'=>'task_id']);
    }
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
