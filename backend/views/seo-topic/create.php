<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SeoTopics $model */

$this->title = 'Create Seo Topics';
$this->params['breadcrumbs'][] = ['label' => 'Seo Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-topics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
