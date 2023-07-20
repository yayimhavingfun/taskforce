<?php
/**
 * @var Users $user
 * @var View $this
 * @var Performer_categories $performer_categories
 */

use app\models\Performer_categories;
use app\models\Users;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Html;

$this->title = 'Профиль пользователя';
?>
<div class="left-column">
    <h3 class="head-main"><?= Html::encode($user->name);?></h3>
    <div class="user-card">
        <div class="photo-rate">
            <img class="card-photo" src="<?= Yii::$app->request->baseUrl.$user->avatar;?>" width="191" height="190" alt="Фото пользователя">
            <div class="card-rate">
                <?=\app\helpers\Helpers::show_stars($user->getRating(), 'big'); ?>
                <span class="current-rate"><?=$user->getRating();?></span>
            </div>
        </div>
        <p class="user-description"><?= $user->bio;?></p>
    </div>
    <div class="specialization-bio">
        <div class="specialization">
            <p class="head-info">Специализации</p>
            <ul class="special-list">
                <?php foreach ($user->categories as $category): ?>
                <li class="special-item">
                    <a href="#" class="link link--regular"><?= $category->name?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="bio">
            <p class="head-info">Био</p>
            <p class="bio-info"><span class="country-info">Россия</span>, <span class="town-info"><?= $user->city->name;?></span>, <?php if ($user->birthday) : ?> <span class="age-info"><?=$user->getAge();?></span> лет</p> <?php endif; ?>
        </div>
    </div>
    <?php if ($user->reviews): ?>
    <h4 class="head-regular">Отзывы заказчиков</h4>
    <?php foreach ($user->reviews as $review): ?>
    <div class="response-card">
        <img class="customer-photo" src="<?=Yii::$app->request->baseUrl.$review->author->avatar;?>" width="120" height="127" alt="Фото заказчиков">
        <div class="feedback-wrapper">
            <p class="feedback"><?= Html::encode($review->text);?></p>
            <p class="task">Задание «<a href="<?=Url::to(['tasks/view', 'id' => $review->task_id]); ?>" class="link link--small"><?= Html::encode($review->task->title);?></a>» выполнено</p>
        </div>
        <div class="feedback-wrapper">
            <div class="stars-rating small"><?=\app\helpers\Helpers::show_stars($user->getRating(), 'small'); ?>;</span></div>
            <p class="info-text"><span class="current-time"><?=Yii::$app->formatter->asRelativeTime($review->date_add); ?></span>назад</p>
        </div>
    </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="right-column">
    <div class="right-card black">
        <h4 class="head-card">Статистика исполнителя</h4>
        <dl class="black-list">
            <dt>Всего заказов</dt>
            <dd><?=$user->success_count; ?> выполнено, <?=$user->fail_count;?> провалено</dd>
            <?php if ($position = $user->getRatingPosition()): ?>
            <dt>Место в рейтинге</dt>
            <dd><?= $position;?> место</dd>
            <?php endif; ?>
            <dt>Дата регистрации</dt>
            <dd><?=Yii::$app->formatter->asDate($user->reg_date); ?></dd>
            <dt>Статус</dt>
            <?php if (!$user->is_busy()): ?>
                <dd>Открыт для новых заказов</dd>
            <?php else: ?>
                <dd>Занят</dd>
            <?php endif ?>
        </dl>
    </div>
    <div class="right-card white">
        <h4 class="head-card">Контакты</h4>
        <ul class="enumeration-list">
            <li class="enumeration-item">
                <a href="tel:<?= $user->tel; ?>" class="link link--block link--phone"><?=$user->tel;?></a>
            </li>
            <li class="enumeration-item">
                <a href="mailto:<?= $user->email; ?>" class="link link--block link--email"><?=$user->email;?></a>
            </li>
            <li class="enumeration-item">
                <a href="https://t.me/<?= $user->telegram; ?>" class="link link--block link--tg"><?=$user->telegram;?></a>
            </li>
        </ul>
    </div>
</div>
