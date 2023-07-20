<?php
/**
 * @var Users $user
 * @var View $this
 * @var Responses $new_response
 * @var Reviews $review
 */

use app\models\Categories;
use app\models\Responses;
use app\models\Reviews;
use app\models\Users;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование профиля';
$this->params['main_class'] = 'main-content--left';
$this->registerJsFile('/js/main.js');
?>

<div class="left-menu left-menu--edit">
        <h3 class="head-main head-task">Настройки</h3>
        <ul class="side-menu-list">
            <li class="side-menu-item side-menu-item--active">
                <a href="#section-profile" class="link link--nav">Мой профиль</a>
            </li>
            <li class="side-menu-item">
                <a href="#section-safety" class="link link--nav">Безопасность</a>
            </li>
        </ul>
    </div>
    <div class="my-profile-form">
        <?php $form = ActiveForm::begin();?>
            <h3 class="head-main head-regular" id="section-profile">Мой профиль</h3>
            <div class="photo-editing">
                <div>
                    <p class="form-label">Аватар</p>
                    <img class="avatar-preview" alt="Аватар пользователя" src="<?= $user->avatar;?>" width="83" height="83">
                </div>
                <?=$form->field($user, 'avatarFile', ['template' => '{input}'])->fileInput(['id' => 'button-input']); ?>
                <label for="button-input" class="button button--black"> Сменить аватар</label>
            </div>
            <?=$form->field($user, 'name'); ?>
            <div class="half-wrapper">
                <?=$form->field($user, 'email')->input('email'); ?>
                <?=$form->field($user, 'birthday')->input('date'); ?>
            </div>
            <div class="half-wrapper">
                <?=$form->field($user, 'tel')->input('tel'); ?>
                <?=$form->field($user, 'telegram'); ?>
            </div>
            <?=$form->field($user, 'bio')->textarea(); ?>

             <div class="form-group">
            <?=$form->field($user, 'categories')->checkboxList(array_column(Categories::find()->all(), 'name', 'id'),
                ['class' => 'checkbox-profile',  'itemOptions' => ['labelOptions' => ['class' => 'control-label']]]); ?>
            </div>

            <h3 class="head-main head-regular" id="section-safety">Безопасность</h3>
            <?=$form->field($user, 'old_password')->passwordInput(); ?>
            <?=$form->field($user, 'new_password', ['enableClientValidation' => false])->passwordInput(); ?>
            <?=$form->field($user, 'new_password_repeat')->passwordInput(); ?>
            <?=$form->field($user, 'hide_contacts')->checkbox(); ?>

            <input type="submit" class="button button--blue" value="Сохранить">
        <?php ActiveForm::end();?>
    </div>

