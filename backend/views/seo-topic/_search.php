<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SeoTopicSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="seo-topics-search">

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
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status') ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Tìm Kiếm', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Đặt Lại', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
