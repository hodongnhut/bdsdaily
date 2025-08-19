<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

$hours = [];
for ($i = 0; $i < 24; $i++) {
    $hours[$i] = date("h:i A", strtotime("$i:00")); 
}
$this->title = 'Tạo Mẫu Email Marketing';
?>
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800"><h1><?= Html::encode($this->title) ?></h1></div>
    <div class="relative flex items-center space-x-4">
        <button
            id="userMenuButton"
            class="w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-md transition-colors duration-200"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <i class="fas fa-user"></i>
        </button>
        <div
            id="userMenu"
            class="absolute right-0 mt-20 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-10 hidden"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="userMenuButton"
        >
            <a href="<?= \yii\helpers\Url::to(['/login-version']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Phiên Đăng Nhập</a>
            <a href="<?= \yii\helpers\Url::to(['/change-password']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đổi Mật Khẩu</a>
            <?= Html::a('Đăng Xuất', ['/site/logout'], [
                'data-method' => 'post',
                'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100',
                'role' => 'menuitem'
            ]) ?>
        </div>
    </div>
</header>
<main class="flex-1 p-6 overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="card-container">
        <?php $form = ActiveForm::begin(
            [
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{hint}\n{error}",
                    'options' => ['class' => 'mb-3'],
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback d-block'], 
                    'hintOptions' => ['class' => 'form-text text-muted'],
                ],
                ],
            ); ?>
            <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'content')->widget(CKEditor::class, [
                'options' => ['rows' => 6],
                'preset' => 'custom',
                    'clientOptions' => [
                    'extraPlugins' => 'codesnippet',
                    'codeSnippet_theme' => 'monokai_sublime',
                    'toolbar' => [
                        ['name' => 'clipboard', 'items' => ['Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo']],
                        ['name' => 'editing', 'items' => ['Find', 'Replace', '-', 'SelectAll']],
                        ['name' => 'insert', 'items' => ['Image', 'Table', 'HorizontalRule', 'SpecialChar', 'CodeSnippet']],
                        ['name' => 'basicstyles', 'items' => ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat', 'CopyFormatting']],
                        ['name' => 'paragraph', 'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']],
                        ['name' => 'links', 'items' => ['Link', 'Unlink']],
                        ['name' => 'styles', 'items' => ['Format']],
                        ['name' => 'tools', 'items' => ['Maximize']],
                    ],
                    'height' => 300,
                ]
            ]) ?>

            <?= $form->field($model, 'send_day')->dropDownList([
                1 => 'Thứ Hai',
                2 => 'Thứ Ba',
                3 => 'Thứ Tư',
                4 => 'Thứ Năm',
                5 => 'Thứ Sáu',
                6 => 'Thứ Bảy',
                7 => 'Chủ Nhật',
            ], ['prompt' => 'Chọn ngày']) ?>


            <?= $form->field($model, 'send_hour')->dropDownList(
                $hours,
                ['prompt' => 'Chọn giờ']
            ) ?>

            <?= $form->field($model, 'status')->dropDownList([
                'on' => 'Bật',
                'off' => 'Tắt',
            ], ['prompt' => 'Chọn Trạng Thái']) ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-save mr-2"></i> Tạo', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
        </div>
    </div>
</main>