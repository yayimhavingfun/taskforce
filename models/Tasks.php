<?php

namespace app\models;

use app\helpers\YandexMapHelper;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $date_add
 * @property int $status_id
 * @property int $customer_id
 * @property string $description
 * @property string $end_date
 * @property int|null $price
 * @property int|null $performer_id
 * @property string|null $title
 * @property string|null $location
 * @property int|null $category_id
 * @property string $uid
 * @property int $city_id
 * @property int $lat
 * @property int $long
 *
 */
class Tasks extends ActiveRecord
{
    public $no_responses;
    public $no_location;
    public $filter_period;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_id'], 'default', 'value' => function($model, $attr) {
                return Statuses::find()->select('id')->where('id=1')->scalar();
            }],
            [['city_id'], 'default', 'value' => function($model, $attr) {
                if ($model->location) {
                    return \Yii::$app->user->getIdentity()->city_id;
                }

                return null;
            }],
            [['no_responses', 'no_location'], 'boolean'],
            [['filter_period'], 'number'],
            [['date_add', 'end_date'], 'safe'],
            [['status_id', 'customer_id', 'description', 'end_date', 'title', 'category_id'], 'required'],
            [['customer_id', 'performer_id', 'status_id', 'category_id'], 'integer'],
            [['price'], 'integer', 'min' => 1],
            [['end_date'], 'date', 'format' => 'php:Y-m-d', 'min' => date('Y-m-d'), 'minString' => 'чем текущий день'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Statuses::class, 'targetAttribute' => ['status_id' => 'id']],
            [['location'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_add' => 'Дата создания',
            'status_id' => 'Статус',
            'customer_id' => 'Заказчик',
            'description' => 'Описание',
            'end_date' => 'Крайний срок',
            'price' => 'Бюджет',
            'performer_id' => 'Исполнитель',
            'title' => 'Название',
            'location' => 'Место',
            'category_id' => "Категория",
            'no_responses' => 'Без откликов',
            'no_location' => "Удаленная работа "
        ];
    }

    public function getSearchQuery()
    {
        $query = self::find();
        $query->where(['status_id' => Statuses::STATUS_NEW]);
        $query->andFilterWhere(['category_id' => $this->category_id]);

        if ($this->no_location) {
            $query->andWhere('location IS NULL');
        }

        if ($this->no_responses) {
            $query->joinWith('responses r')->andWhere('r.id IS NULL');
        }

        if ($this->filter_period) {
            $query->andWhere('UNIX_TIMESTAMP(tasks.date_add) > UNIX_TIMESTAMP() - :period', [':period' => $this->filter_period]);
        }

        return $query->orderBy('date_add DESC');
    }

    public function getCategories()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(Users::class, ['id' => 'customer_id']);
    }

    public function getPerformer()
    {
        return $this->hasOne(Users::class, ['id' => 'performer_id']);
    }

    public function getResponses(IdentityInterface $users = null)
    {
        $responses_query = $this->hasMany(Responses::class, ['task_id' => 'id']);

        if ($users && $users->getId() !== $this->customer_id) {
            $responses_query->where(['responses.performer_id' => $users->getId()]);
        }
        return $responses_query;
    }

    public function getStatus()
    {
        return $this->hasOne(Statuses::class, ['id' => 'status_id']);
    }

    public function getFiles()
    {
        return $this->hasMany(Files::class, ['task_id' => 'id']);
    }

    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['task_id' => 'id']);
    }

}
