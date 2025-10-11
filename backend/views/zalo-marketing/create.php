<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ZaloContact $model */

$this->title = 'Create Zalo Contact';
$this->params['breadcrumbs'][] = ['label' => 'Zalo Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zalo-contact-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
