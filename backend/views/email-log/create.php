<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EmailLog $model */

$this->title = 'Create Email Log';
$this->params['breadcrumbs'][] = ['label' => 'Email Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
