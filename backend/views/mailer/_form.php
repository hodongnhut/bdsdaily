<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MailerConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mailer-config-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'driver')->dropDownList(['dsn' => 'DSN (Resend, Mailgun, etc.)', 'array' => 'Config mảng (SMTP thông thường)'], ['prompt' => '— Chọn loại —']) ?>

    <div class="dsn-fields">
        <?= $form->field($model, 'dsn')->textarea(['rows' => 3, 'placeholder' => 'smtp://user:pass@host:port']) ?>
    </div>

    <?= $form->field($model, 'host')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>


    <div class="array-fields" style="display:none;">
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'port')->textInput() ?>
        <?= $form->field($model, 'encryption')->dropDownList(['' => 'Không', 'ssl' => 'SSL', 'tls' => 'TLS'], ['prompt' => '— Chọn —']) ?>
    </div>

    <?= $form->field($model, 'priority')->textInput()->hint('Số càng cao → càng được ưu tiên dùng trước') ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>

            <?php if (!$model->isNewRecord): ?>
                <?= Html::a('Gửi Mail Test', ['test', 'id' => $model->id], [
                    'class' => 'btn btn-warning btn-flat',
                    'data' => [
                        'confirm' => 'Gửi mail test đến email của bạn?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs(<<<JS
$(document).on('change', '#mailerconfig-driver', function() {
    if ($(this).val() === 'dsn') {
        $('.dsn-fields').show();
        $('.array-fields').hide();
    } else {
        $('.dsn-fields').hide();
        $('.array-fields').show();
    }
}).trigger('change');
JS
);
?>