<?php
/**
 * @var \app\models\AddTaskForm $model;
 * @var Categories $categories
 * @var View $this
 */

use app\models\Categories;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Создание задания';
$this->params['main_class'] = 'main-content--center';

?>
<div class="add-task-form regular-form">
    <?php $form = ActiveForm::begin(['id' => 'add-task-form', 'options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => true]);?>
        <h3 class="head-main head-main">Публикация нового задания</h3>
    <?= $form->field($model, 'title'); ?>
    <?= $form->field($model, 'description')->textarea(); ?>
    <?= $form->field($model, 'category_id')->dropDownList(array_column($categories, 'name', 'id'),
        ['prompt' => 'Выбрать категорию']); ?>
    <?= $form->field($model, 'location'); ?>
        <div class="half-wrapper">
            <?= $form->field($model, 'price')->input('text', ['class' => 'budget-icon']); ?>
            <?= $form->field($model, 'end_date')->input('date'); ?>
        </div>
        <p class="form-label">Файлы</p>
        <?= $form->field($model, 'files[]')->fileInput(['multiple' => true]); ?>
        <input type="submit" class="button button--blue" value="Опубликовать">
    <?php ActiveForm::end();?>
</div>