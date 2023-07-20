<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\Categories;
use app\models\Users;
use app\models\Cities;
use yii\db\Expression;

return [
    'title' => $faker->sentence,
    'category_id' => Categories::find()->select('id')->orderBy(new Expression('rand()'))->scalar(),
    'description' => $faker->realTextBetween(),
    'price' => rand(1000, 30000),
    'date_add' => $faker->dateTimeBetween('-1 month')->format('Y-m-d'),
    'customer_id' => Users::find()->select('id')->orderBy(new Expression('rand()'))->scalar(),
    'end_date' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
    'status_id' => 1,
    'city_id' => Cities::find()->select('id')->orderBy(new Expression('rand()'))->scalar()
];
