<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\Cities;
use yii\db\Expression;

return [
    'email' => $faker->unique()->email,
    'name' => $faker->name,
    'city_id' => Cities::find()->select('id')->orderBy(new Expression('rand()'))->scalar(),
    'password' => Yii::$app->security->generatePasswordHash('qwerty'),
    'avatar' => '/img/avatars/' . rand(1, 5) . '.png',
    'bio' => $faker->realTextBetween(),
    'birthday' => $faker->date,
    'tel' => $faker->phoneNumber,
    'skype' => $faker->unique()->email,
    'telegram' => $faker->phoneNumber,
];