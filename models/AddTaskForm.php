<?php
namespace app\models;

use app\helpers\YandexMapHelper;
use Exception;
use app\src\ex\AddTaskException;
use app\src\ex\UploadFileException;
use Throwable;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class AddTaskForm extends Model
{
    /**
     * @property string $title
     * @property string $description
     * @property int $category_id
     * @property int $price
     * @property string $end_date
     * @property string $location
     */
    public $title;
    public $description;
    public $category_id;
    public $price;
    public $end_date;
    public $location;
    /**
     * @var UploadedFile[] $files
     */
    public $files;

    public function rules()
    {
        return [
            [['title', 'description', 'category_id'], 'required'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            ['end_date', 'date', 'format' => 'php:Y-m-d'],
            ['end_date', 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '>', 'type' => 'date'],
            [['price', 'category_id'], 'integer'],
            [['files'], 'file', 'skipOnEmpty' => true, 'checkExtensionByMimeType' => false, 'maxFiles' => 4],
            [['location'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Опишите суть работы',
            'description' => 'Подробности задания',
            'category_id' => 'Категория',
            'price' => 'Бюджет',
            'end_date' => 'Срок исполнения',
            'files' => 'Добавить новый файл',
            'location' => 'Место'
        ];
    }

    /**
     * @throws \yii\db\Exception
     * @throws Throwable
     * @throws AddTaskException
     * @throws UploadFileException
     */
    public function addTask(): Tasks
    {
        $task = new Tasks();
        $task->customer_id = Yii::$app->user->getId();
        $task->title = $this->title;
        $task->description = $this->description;
        $task->category_id = $this->category_id;
        $task->price = $this->price;
        $task->end_date = $this->end_date;
        $task->status_id = Statuses::STATUS_NEW;
        $task->location = $this->location;

        if ($this->location) {
            $ya_helper = new YandexMapHelper(Yii::$app->$_ENV['YANDEX_API_KEY']);
            $coords = $ya_helper->getCoordinates(Yii::$app->user->getIdentity()->city->name, $task->location);

            if ($coords) {
                [$lat, $long] = $coords;

                $task->lat = $lat;
                $task->long = $long;

            }
        }
        return $task;
    }
}