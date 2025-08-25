<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SeoTopics $model */

$this->title = 'Update Seo Topics: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Seo Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seo-topics-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
