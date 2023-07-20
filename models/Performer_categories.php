<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "performer_categories".
 *
 * @property int $id
 * @property int $performer_id
 * @property int $category_id
 */
class Performer_categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'performer_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['performer_id', 'category_id'], 'required'],
            [['performer_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'performer_id' => 'Performer ID',
            'category_id' => 'Category ID',
        ];
    }

    public function getCategories()
    {
        $this->hasOne(Categories::class, ['id' => 'category_id']);
    }
}
