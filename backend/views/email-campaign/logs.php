// File: backend/views/email-campaign/logs.php
<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Email Logs';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => \common\models\EmailLog::find(),
    ]),
    'columns' => [
        'id',
        'campaign_id',
        'email',
        'status',
        'sent_at:datetime',
    ],
]); ?>