<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string|null $name
 * @property string $date_add
 * @property string $path
 * @property int $size
 * @property string $task_uid
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id', 'name'], 'required'],
            [['task_id', 'user_id', 'size'], 'integer'],
            [['date_add'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['path'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'name' => 'Name',
            'path' => 'Path',
            'size' => 'Size',
            'date_add' => 'Date Add',
            'user_id' => 'User ID'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id'=>'task_id']);
    }

}
