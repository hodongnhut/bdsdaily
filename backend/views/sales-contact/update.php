<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SalesContact $model */

$this->title = 'Update Sales Contact: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sales Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sales-contact-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
