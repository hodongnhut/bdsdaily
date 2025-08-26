<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/** @var yii\web\View $this */
/** @var common\models\NewsExtranaly $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="news-extranaly-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{hint}\n{error}",
            'options' => ['class' => 'mb-3'],
            'labelOptions' => ['class' => 'form-label'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'invalid-feedback d-block'], 
            'hintOptions' => ['class' => 'form-text text-muted'],
        ],
        ]); 
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

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
            'height' => 250,
        ]
    ]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'keywords')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'news_keywords')->textarea(['rows' => 4]) ?>
        </div>
    </div>


    <?= $form->field($model, 'thumb_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag')->textInput(['maxlength' => true]) ?>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
