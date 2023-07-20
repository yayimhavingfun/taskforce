<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\Tasks;
use app\models\Users;
use yii\db\Expression;

return [
    'date_add' => $faker->dateTimeBetween('-1 month')->format('Y-m-d'),
    'task_id' => Tasks::find()->select('id')->orderBy(new Expression('rand()'))->scalar(),
    'author_id' => Users::find()->select('id')->orderBy(new Expression('rand()'))->scalar(),
    'score' => rand(0, 5),
    'text' => $faker->realTextBetween(),
    'user_id' => Users::find()->select('id')->orderBy(new Expression('rand()'))->scalar(),
];
