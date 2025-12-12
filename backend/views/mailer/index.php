<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý Mailer';
$this->params['breadcrumbs'][] = $this->title;
?>

<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800"><?= Html::encode($this->title) ?></div>
    <div class="relative flex items-center space-x-4">
        <button
            id="userMenuButton"
            class="w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-md transition-colors duration-200"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <i class="fas fa-user"></i>
        </button>
        <div
            id="userMenu"
            class="absolute right-0 mt-20 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-10 hidden"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="userMenuButton"
        >
        <a href="<?= \yii\helpers\Url::to(['/login-version']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Phiên Đăng Nhập</a>
            <a href="<?= \yii\helpers\Url::to(['/change-password']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đổi Mật Khẩu</a>
            <?= Html::a('Đăng Xuất', ['/site/logout'], [
                'data-method' => 'post',
                'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100',
                'role' => 'menuitem'
            ]) ?>
        </div>
    </div>
</header>
<main class="flex-1 p-6 overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="mailer-config-index box box-primary">
            <div class="box-header with-border">
                <div class="box-tools pull-right">
                    <?= Html::a('<i class="fa fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
                </div>
            </div>
            <br>
            <div class="box-body table-responsive no-padding">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'name',
                        'driver',
                        [
                            'attribute' => 'is_active',
                            'format' => 'raw',
                            'value' => fn($model) => $model->is_active
                                ? '<span class="label label-success">Bật</span>'
                                : '<span class="label label-danger">Tắt</span>',
                        ],
                        'priority',
                        [
                            'attribute' => 'host',
                            'value' => fn($model) => $model->host ?: '—',
                        ],
                        [
                            'attribute' => 'username',
                            'value' => fn($model) => $model->username ?: '—',
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {test} {delete}',
                            'buttons' => [
                                'test' => function ($url, $model) {
                                    return Html::a(
                                        '<i class="fa fa-paper-plane"></i>',
                                        ['test', 'id' => $model->id],
                                        [
                                            'title' => 'Gửi mail test',
                                            'class' => 'btn btn-warning btn-xs btn-flat',
                                            'data' => [
                                                'confirm' => 'Gửi mail test đến email admin?',
                                                'method' => 'post',
                                            ],
                                        ]
                                    );
                                },
                            ],
                            'contentOptions' => ['style' => 'width:130px; text-align:center'],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</main>
