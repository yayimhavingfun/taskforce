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
    'performer_id' => Users::find()->select('id')->orderBy(new Expression('rand()'))->scalar(),
    'price' => rand(1000, 10000),
    'description' => $faker->realTextBetween(),
    'rejected' => rand(0,1)
 ];