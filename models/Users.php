<?php

namespace app\models;

use Yii;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use app\models\Tasks;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property int $city_id
 * @property string $password
 * @property string $reg_date
 * @property string|null $birthday
 * @property string|null $bio
 * @property string|null $tel
 * @property string|null $telegram
 * @property string|null $avatar
 * @property int|null $is_performer
 * @property int|null $fail_count
 * @property int|null $success_count
 * @property string $old_password
 * @property string $new_password
 * @property string $password_repeat
 * @property string $new_password_repeat
 * @property-read null|int $ratingPosition
 * @property-read \yii\db\ActiveQuery $tasks
 * @property-read null|int $age
 * @property-read mixed $categories
 * @property-read \yii\db\ActiveQuery $responses
 * @property-read null|float $rating
 * @property-read \yii\db\ActiveQuery $city
 * @property-read \yii\db\ActiveQuery $reviews
 * @property boolean $hide_contacts
 */
class Users extends BaseUser implements IdentityInterface
{
    public $password_repeat;
    public $old_password;
    public $new_password;
    public $new_password_repeat;

    /**
     * @var UploadedFile
     */
    public  $avatarFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users';
    }

    public function behaviors()
    {
        return [
            'saveRelations' => [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'categories'
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['email', 'name'], 'required'],
            [['city_id', 'password'], 'required', 'on' => 'insert'],
            [['new_password'], 'required', 'when' => function ($model) {
                return $model->old_password;
            }],
            [['city_id', 'is_performer', 'fail_count'], 'integer'],
            [['password_repeat', 'categories', 'old_password', 'new_password', 'new_password_repeat', 'avatarFile'], 'safe'],
            [['avatarFile'], 'file', 'mimeTypes' => ['image/jpeg', 'image/png'], 'extensions' => ['png', 'jpg', 'jpeg']],
            [['bio'], 'string'],
            [['new_password'], 'compare', 'on' => 'update'],
            [['email', 'name', 'tel', 'telegram', 'avatar'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 64],
            [['password'], 'compare', 'on' => 'insert'],
            [['birthday'], 'date', 'format' => 'php:Y-m-d',],
            [['is_performer', 'hide_contacts'], 'boolean'],
            [['tel'], 'match', 'pattern' => '/^[+-]?\d{11}$/', 'message' => 'Номер телефона должен быть строкой в 11 символов'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Имя',
            'city_id' => 'Город',
            'password' => 'Пароль',
            'old_password' => 'Старый пароль',
            'new_password' => 'Новый пароль',
            'password_repeat' => 'Повтор пароля',
            'new_password_repeat' => 'Повтор пароля',
            'reg_date' => 'Reg Date',
            'birthday' => 'Дата рождения',
            'bio' => 'Информация о себе',
            'tel' => 'Телефон',
            'telegram' => 'Telegram',
            'is_performer' => 'Я собираюсь откликаться на заказы',
            'hide_contacts' => 'Показывать контакты только заказчику    ',
            'success_count' => 'Success count',
            'fail_count' => 'Fail count'
        ];
    }

    public function getTasks(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Tasks::class, ['performer_id' => 'id']);
    }

    public function getCity(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    public function getReviews(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Reviews::class, ['user_id' => 'id']);
    }
    public function getAge(): ?int
    {
        $result = null;

        if ($this->birthday) {
            $bd = new \DateTime($this->birthday);
            $now = new \DateTime();
            $diff = $now->diff($bd);
            $result = $diff->y;
        }

        return $result;
    }

    public function getResponses(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Responses::class, ['performer_id' => 'id']);
    }

    public function getRating(): ?float
    {
        $rating = null;

        $reviews_count = $this->getReviews()->count();

        if ($reviews_count) {
            $ratingSum = $this->getReviews()->sum('score');
            $failCount = $this->fail_count;
            $rating = round(intdiv($ratingSum, $reviews_count + $failCount), 2);
        }

        return $rating;
    }

    public function is_busy(): bool
    {
        return $this->getTasks()->where(['status_id' => 3])->exists();
    }

    public function getTasksByStatus($status)
    {
        $query = Tasks::find();
        switch ($status) {
            case 'new':
                $query->where(['status_id' => Statuses::STATUS_NEW]);
                break;
            case 'closed':
                $query->where(['status_id' => [Statuses::STATUS_COMPLETED, Statuses::STATUS_FAILED, Statuses::STATUS_CANCELLED]]);
                break;
            case 'in_progress':
                $query->where(['status_id' => Statuses::STATUS_IN_PROGRESS]);
                break;
            case 'expired':
                $query->where(['status_id' => Statuses::STATUS_IN_PROGRESS])
                    ->andWhere(['<', 'end_date', date('Y-m-d')]);
                break;
        }
        return $query;
    }

    public function getRatingPosition()
    {
        $result = null;

        $sql = "SELECT u.id, (SUM(r.score) / (COUNT(r.id) + u.fail_count)) as score FROM users u
                LEFT JOIN reviews r on u.id = r.user_id
                GROUP BY u.id
                ORDER BY score DESC";

        $records = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        $index = array_search($this->id, array_column($records, 'id'));

        if ($index !== false) {
            $result = $index + 1;
        }

        return $result;
    }

    public function getCategories()
    {
        return $this->hasMany(Categories::class, ['id' => 'category_id'])->viaTable('performer_categories', ['performer_id' => 'id']);
    }


    public function beforeSave($insert)
    {
        parent::beforeSave($insert);

        if ($this->avatarFile) {
            $newname = uniqid() . '.' . $this->avatarFile->getExtension();
            $path = '/uploads/' . $newname;

            $this->avatarFile->saveAs('@webroot/uploads/' . $newname);
            $this->avatar = $path;
        }

        if ($this->new_password) {
            $this->setPassword($this->new_password);
        }

        return true;
    }

    public function newPasswordValidation($attribute, $params)
    {
        if (!$this->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Указан неверный старый пароль');
        }
    }
}
