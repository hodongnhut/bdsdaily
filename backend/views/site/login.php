<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Đăng Nhập';
?>
<div class="w-full max-w-md bg-white rounded-lg shadow-xl p-8 space-y-6 md:p-10">
    <div class="text-center">
        <div
            class="mx-auto h-16 w-16 bg-red-600 rounded-full flex items-center justify-center text-white mb-4 shadow-md">
            <i class="fas fa-lock text-3xl"></i>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2"><?= Html::encode($this->title) ?></h2>
        <p class="text-sm text-gray-500">Truy cập vào tài khoản của bạn</p>
    </div>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Thành công!</strong>
            <span class="block sm:inline"><?= Yii::$app->session->getFlash('success') ?></span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';">
                    <title>Close</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.697l-2.651 2.652a1.2 1.2 0 1 1-1.697-1.697L8.303 10 5.651 7.348a1.2 1.2 0 1 1 1.697-1.697L10 8.303l2.651-2.652a1.2 1.2 0 1 1 1.697 1.697L11.697 10l2.652 2.651a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </span>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Lỗi!</strong>
            <span class="block sm:inline"><?= Yii::$app->session->getFlash('error') ?></span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';">
                    <title>Close</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.697l-2.651 2.652a1.2 1.2 0 1 1-1.697-1.697L8.303 10 5.651 7.348a1.2 1.2 0 1 1 1.697-1.697L10 8.303l2.651-2.652a1.2 1.2 0 1 1 1.697 1.697L11.697 10l2.652 2.651a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </span>
        </div>
    <?php endif; ?>


    <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'space-y-6'],
            'fieldConfig' => [
                'options' => ['class' => 'mb-3'], 
                'inputOptions' => ['class' => 'form-control'], 
                'labelOptions' => ['class' => 'form-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'usernameOrEmail', [
            'template' => "{label}\n<div class=\"input-group\">"
                          . "<span class=\"input-group-text\"><i class=\"fas fa-envelope\"></i></span>"
                          . "{input}</div>\n{hint}\n{error}",
            'inputOptions' => [
                'autofocus' => true,
                'placeholder' => 'your.email@example.com',
            ],
        ])->label('Email Hoặc Mã Nhân Viên') ?>

        <?= $form->field($model, 'password', [
            'template' => "{label}\n<div class=\"input-group\">"
                        . "<span class=\"input-group-text\"><i class=\"fas fa-key\"></i></span>"
                        . "{input}"
                        . "<button type=\"button\" class=\"btn btn-outline-secondary toggle-password\" tabindex=\"-1\">
                            <i class=\"fas fa-eye\"></i>
                        </button>"
                        . "</div>\n{hint}\n{error}",
        ])->passwordInput([
            'placeholder' => '********',
            'class' => 'form-control password-input',
        ])->label('Mật khẩu') ?>


        <div class="d-flex justify-content-between align-items-center mb-3">

                <?= $form->field($model, 'rememberMe')->checkbox([
                    'class' => 'form-check-input',
                    'labelOptions' => ['class' => 'form-check-label ms-2'],
                ])->label('Ghi nhớ đăng nhập') ?>
 

            <div class="text-sm">
                <a href="/site/request-password-reset" class="text-decoration-none text-primary">
                    Quên mật khẩu?
                </a>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Đăng Nhập', ['class' => 'bg-red-600 text-white w-100 py-2', 'name' => 'login-button']) ?>
        </div>

        <div class="form-group text-center">
            <div class="border-t border-gray-700 pt-6 text-sm text-gray-400">
                Bản Quyền Thuộc Về Công Ty <a href="https://stonenetworktech.com/"
                        target="_blank" rel="nofollow noopener" title="StoneNetwork">
                        StoneNetwork</a>
                </div>
        </div>

        <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
$(document).on('click', '.toggle-password', function () {
    var input = $(this).siblings('input');
    var icon = $(this).find('i');
    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
});
JS;
$this->registerJs($js);
?>
