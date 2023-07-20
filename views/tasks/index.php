<?php
/**
 * @var Tasks $models
 * @var $this View
 * @var  Tasks $tasks
 * @var Categories $categories
 * @var Pagination $pages
 */


use app\models\Categories;
use app\models\Tasks;
use yii\data\Pagination;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Просмотр новых заданий';
?>
<div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        <?php foreach ($models as $model): ?>
        <div class="task-card">
            <div class="header-task">
                <a  href="<?=Url::toRoute(['tasks/view', 'id' => $model->id]); ?>" class="link link--block link--big"><?=Html::encode($model->title); ?></a>
                <p class="price price--task"><?=$model->price?> руб</p>
            </div>
            <p class="info-text"><?=Yii::$app->formatter->asRelativeTime($model->date_add)?></p>
            <p class="task-text"><?=Html::encode(BaseStringHelper::truncate($model->description, 200));?>
            </p>
            <div class="footer-task">
                <p class="info-text town-text"><?php if (!is_null($model->city)) {echo $model->city->name;} else {echo "Удаленная работа";} ?></p>
                <p class="info-text category-text"><?=$model->categories->name?></p>
                <a href="<?=Url::toRoute(['tasks/view', 'id' => $model->id]); ?>" class="button button--black">Смотреть Задание</a>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="pagination-wrapper">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'prevPageCssClass' => 'pagination-item mark',
                'nextPageCssClass' => 'pagination-item mark',
                'pageCssClass' => 'pagination-item',
                'activePageCssClass' => 'pagination-item--active',
                'linkOptions' => ['class' => 'link link--page'],
                'nextPageLabel' => '',
                'prevPageLabel' => '',
                'maxButtonCount' => 5
            ]);?>
        </div>
    </div>
    <div class="right-column">
       <div class="right-card black">
           <div class="search-form">
                <?php $form = ActiveForm::begin(['method' => 'post']); ?>
                    <h4 class="head-card">Категории</h4>
               <?= Html::activeCheckboxList($tasks, 'category_id', array_column($categories, 'name', 'id'), ['tag' => null, 'separator' => '<br>','itemOptions' => ['labelOptions' => ['class' => 'control-label']]]);?>
                    <h4 class="head-card">Дополнительно</h4>
                    <div class="form-group">
                        <?=$form->field($tasks, 'no_responses')->checkbox(['labelOptions' => ['class' => 'control-label']]); ?>
                    </div>
                    <div class="form-group">
                        <?=$form->field($tasks, 'no_location')->checkbox(['labelOptions' => ['class' => 'control-label']]); ?>
                    </div>
                    <h4 class="head-card">Период</h4>
                    <div class="form-group">
                        <?=$form->field($tasks, 'filter_period', ['template' => '{input}'])->dropDownList([
                            '3600' => 'За последний час', '86400' => 'За сутки', '604800' => 'За неделю'
                        ], ['prompt' => 'Выбрать']); ?>
                    </div>
                    <input type="submit" class="button button--blue" value="Искать">
                <?php ActiveForm::end();?>
           </div>
       </div>
    </div>