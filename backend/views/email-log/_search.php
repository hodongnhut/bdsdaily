<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EmailLogSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="email-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'status')->dropDownList(
                [
                    '' => 'All',
                    'failed' => 'Failed',
                    'sent' => 'Sent',
                ],
                ['prompt' => 'Select Status']
            ) ?>
        </div>
    </div>

    <div class="form-group mt-[10px]">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
