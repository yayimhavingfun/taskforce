<?php
/* @var $this yii\web\View */
/* @var $menu_items array */
/* @var $tasks Tasks[] */

use app\models\Tasks;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

$this->title = 'Мои задания';
?>

<div class="left-menu">
    <h3 class="head-main head-task">Мои задания</h3>
    <?=Menu::widget([
        'options' => ['class' => 'side-menu-list'], 'activeCssClass' => 'side-menu-item--active',
        'itemOptions' => ['class' => 'side-menu-item'],
        'linkTemplate' => '<a href="{url}" class="link link--nav">{label}</a>',
        'items' => $menu_items
    ]); ?>
</div>
<div class="left-column left-column--task">
    <?php foreach ($tasks as $model): ?>
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
</div>