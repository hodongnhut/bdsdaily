<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SalesContactSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="sales-contact-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{hint}\n{error}",
            'options' => ['class' => 'mb-3'],
            'labelOptions' => ['class' => 'form-label'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'invalid-feedback d-block'],
            'hintOptions' => ['class' => 'form-text text-muted'],
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'company_status') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'phone') ?>
        </div>
    </div>


    <?= $form->field($model, 'address') ?>

    <div class="col-md-6 d-flex align-items-end">
        <div class="form-group">
            <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Đặt lại', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>