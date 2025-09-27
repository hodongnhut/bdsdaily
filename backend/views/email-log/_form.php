<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EmailLog $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="email-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'campaign_id')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'sent' => 'Sent', 'failed' => 'Failed', 'pending' => 'Pending', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'sent_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
