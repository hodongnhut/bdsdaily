<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\NewsExtranaly $model */

$this->title = 'Create News Extranaly';
$this->params['breadcrumbs'][] = ['label' => 'News Extranalies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-extranaly-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
