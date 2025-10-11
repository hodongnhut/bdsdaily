<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ZaloContact $model */

$this->title = 'Update Zalo Contact: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Zalo Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="zalo-contact-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
