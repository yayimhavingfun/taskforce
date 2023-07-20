<?php
/**
 * @var Tasks $model
 * @var View $this
 * @var Users $users
 * @var Responses $responses
 * @var Reviews $reviews
 * @var Files $files
 */

use app\models\Files;
use app\models\Responses;
use app\models\Reviews;
use app\models\Statuses;
use app\models\Tasks;
use app\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

$users = Yii::$app->user->getIdentity();
$this->title = 'Просмотр задания';
\app\assets\YandexAsset::register($this);
?>
<div class="left-column">
    <div class="head-wrapper">
        <h3 class="head-main"><?= Html::encode($model->title);?></h3>
        <p class="price price--big"><?= $model->price.' р';?></p>
    </div>
    <p class="task-description"><?= Html::encode($model->description);?></p>
    <?php if ($users->id !== $model->customer_id && $users->is_performer == 1) : ?>
        <?php if ($model->performer_id == null && $model->status_id == Statuses::STATUS_NEW) : ?>
    <a href="#" class="button button--blue action-btn" data-action="act_response">Откликнуться на задание</a>
        <?php elseif ($users->id == $model->performer_id && $model->status_id == Statuses::STATUS_IN_PROGRESS) : ?>
    <a href="#" class="button button--orange action-btn" data-action="act_deny">Отказаться от задания</a>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($users->id == $model->customer_id && $model->status_id !== Statuses::STATUS_CANCELLED) : ?>
    <a href="<?=Url::to(['tasks/cancel', 'id' => $model->id]); ?>" class="button button--yellow action-btn" data-action="cancellation">Отменить задание</a>
    <a href="#" class="button button--pink action-btn" data-action="act_complete">Завершить задание</a>
    <?php endif; ?>
    <?php if ($model->city): ?>
        <div class="task-map">
            <div class="map" id="map"></div>
            <p class="map-address town"><?=$model->city->name;?></p>
            <p class="map-address"><?=Html::encode($model->location); ?></p>
        </div>

        <?php
        $lat = $model->lat; $long = $model->long;
        $this->registerJs(<<<JS
    ymaps.ready(init);
    function init(){
        var myMap = new ymaps.Map("map", {
            center: ["$lat", "$long"],
            zoom: 16
        });
        
        myMap.controls.remove('trafficControl');
        myMap.controls.remove('searchControl');
        myMap.controls.remove('geolocationControl');
        myMap.controls.remove('typeSelector');
        myMap.controls.remove('fullscreenControl');
        myMap.controls.remove('rulerControl');
    }
JS, View::POS_READY);
        ?>
    <?php endif; ?>

    <h4 class="head-regular">Отклики на задание</h4>
    <?php foreach ($model->getResponses($users)->all() as $response) : ?>
        <?php if ($users->id === $model->customer_id && $response->rejected !== 0 || 1) :?>
    <div class="response-card">
        <img class="customer-photo" src="<?php if($response->user->avatar) {echo Yii::$app->request->baseUrl.$response->user->avatar;}?>" width="146" height="156" alt="Фото заказчиков">
        <div class="feedback-wrapper">
            <a href="<?=Url::toRoute(['users/view', 'id' => $response->user->id]); ?>" class="link link--block link--big">\<?= Html::encode($response->user->name);?></a>
            <div class="response-wrapper">
                <div class="stars-rating small"><span><?=\app\helpers\Helpers::show_stars($response->user->getRating(), 'small'); ?></span></div>
                <p class="reviews"><?=$model->getReviews()->count();?></p>
            </div>
            <p class="response-message"><?= Html::encode($response->description);?></p>

        </div>
        <div class="feedback-wrapper">
            <p class="info-text"><span class="current-time"><?=Yii::$app->formatter->asRelativeTime($response->date_add); ?></span></p>
            <p class="price price--small"><?= $response->price.' p'?></p>
        </div>
        <?php if ($users->id == $model->customer_id) : ?>
        <div class="button-popup">
            <a href="<?=Url::to(['response/approve', 'id' => $response->id]); ?>" class="button button--blue button--small">Принять</a>
            <a href="<?=Url::to(['response/reject', 'id' => $response->id]); ?>" class="button button--orange button--small">Отказать</a>
        </div>
        <?php endif; ?>
    </div>
        <?php endif; ?>
    <?php endforeach;?>
</div>
<div class="right-column">
    <div class="right-card black info-card">
        <h4 class="head-card">Информация о задании</h4>
        <dl class="black-list">
            <dt>Категория</dt>
            <dd><?= $model->categories->name;?></dd>
            <dt>Дата публикации</dt>
            <dd><?=Yii::$app->formatter->asRelativeTime($model->date_add); ?></dd>
            <dt>Срок выполнения</dt>
            <dd><?=Yii::$app->formatter->asDatetime($model->end_date); ?></dd>
            <dt>Статус</dt>
            <dd><?=$model->status->name?></dd>
        </dl>
    </div>
    <div class="right-card white file-card">
        <h4 class="head-card">Файлы задания</h4>
        <ul class="enumeration-list">
        <?php foreach ($model->files as $file): ?>
            <li class="enumeration-item">
                <a href="<?= Yii::$app->request->baseUrl. '/uploads/' .$file->path ?>" class="link link--block link--clip"><?= $file->name;?></a>
                <p class="file-size"><?= $file->size; ?></p>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>
<section class="pop-up pop-up--act_deny pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Отказ от задания</h4>
        <p class="pop-up-text">
            <b>Внимание!</b><br>
            Вы собираетесь отказаться от выполнения этого задания.<br>
            Это действие плохо скажется на вашем рейтинге и увеличит счетчик проваленных заданий.
        </p>
        <a class="button button--pop-up button--orange" href="<?=Url::to(['tasks/decline', 'id' => $model->id]); ?>">Отказаться</a>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
<section class="pop-up pop-up--act_complete pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Завершение задания</h4>
        <p class="pop-up-text">
            Вы собираетесь отметить это задание как выполненное.
            Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
        </p>
        <div class="completion-form pop-up--form regular-form">
            <?php $form = ActiveForm::begin([
                'action' => Url::to(['review/create', 'id' => $model->id]),
                'enableAjaxValidation' => true,
                'validationUrl' => ['review/validate'],
            ]); ?>
            <?= $form->field($reviews, 'text')->textarea(); ?>
            <?= $form->field($reviews, 'score', ['template' => '{label}{input}' . \app\helpers\Helpers::show_stars(0, 'big', 5, true) . '{error}'])
                ->hiddenInput(); ?>
            <input type="submit" class="button button--pop-up button--blue" value="Завершить">
            <?php ActiveForm::end(); ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
<section class="pop-up pop-up--act_response pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Добавление отклика к заданию</h4>
        <p class="pop-up-text">
            Вы собираетесь оставить свой отклик к этому заданию.
            Пожалуйста, укажите стоимость работы и добавьте комментарий, если необходимо.
        </p>
        <div class="addition-form pop-up--form regular-form">
            <?php $form = ActiveForm::begin(['enableAjaxValidation' => true,
                    'validationUrl' => ['response/validate', 'id' => $model->id],
                    'action' => Url::to(['response/create', 'id' => $model->id])]
            );
            ?>
            <?= $form->field($responses, 'description')->textarea(); ?>
            <?= $form->field($responses, 'price'); ?>
            <input type="submit" class="button button--pop-up button--blue" value="Отправить">
            <?php ActiveForm::end(); ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
