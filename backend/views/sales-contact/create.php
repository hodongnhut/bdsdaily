<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SalesContact $model */

$this->title = 'Create Sales Contact';
$this->params['breadcrumbs'][] = ['label' => 'Sales Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-contact-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
