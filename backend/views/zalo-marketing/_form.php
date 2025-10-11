<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ZaloContact $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="zalo-contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Sending' => 'Sending', 'Success' => 'Success', 'Failed' => 'Failed', 'NotYet' => 'NotYet', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'uuid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'threadid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zalo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
