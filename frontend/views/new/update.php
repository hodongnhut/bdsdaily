<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\NewsExtranaly $model */

$this->title = 'Update News Extranaly: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'News Extranalies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="news-extranaly-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
