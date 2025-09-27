<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Email Campaigns';
?>
<!-- Header -->
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Danh Sách Mẫu Email</div>
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
        <p class="text-sm text-gray-500 mb-2">Màn hình chính /<?= Html::encode($this->title) ?></p>
        <div class="flex space-x-4 items-right mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Danh Sách Mẫu Email</h2>
            <?= Html::a('<i class="fas fa-plus mr-2"></i> Tạo Mẫu', ['create'], ['class' => 'items-right bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md flex items-center transition-colors duration-200']) ?>
            <?= Html::a('<i class="fas fa-eye mr-2"></i> Logs', ['./email-log'], ['class' => 'items-right bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md flex items-center transition-colors duration-200']) ?>
        </div>
       

        <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => \common\models\EmailCampaign::find(),
        ]),
        'headerRowOptions' => ['class' => 'bg-gray-50'],
        'rowOptions' => ['class' => 'bg-white'],
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'subject',
            'send_day' => [
                'attribute' => 'send_day',
                'value' => function ($model) {
                    $days = [ 
                        1 => 'Thứ Hai',
                        2 => 'Thứ Ba',
                        3 => 'Thứ Tư',
                        4 => 'Thứ Năm',
                        5 => 'Thứ Sáu',
                        6 => 'Thứ Bảy',
                        7 => 'Chủ Nhật'
                    ];
                    return $days[$model->send_day] ?? $model->send_day;
                },
            ],
            'send_hour' => [
                'attribute' => 'send_hour',
                'value' => function ($model) {
                    return $model->send_hour . ':00';
                },
            ],
            'created_at:datetime',
            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{preview} {update} {delete} {toggle}',
                    'buttons' => [
                        'preview' => function ($url, $model) {
                            return Html::a(
                                '<i class="fas fa-eye text-primary text-xl"></i>',
                                ['preview', 'id' => $model->id],
                                [
                                    'title' => 'Xem trước',
                                    'data-pjax' => '0',
                                    'encode' => false,
                                    'class' => 'inline-block px-2',
                                ]
                            );
                        },
                        'toggle' => function ($url, $model) {
                            $icon = $model->status === 'on' 
                                ? '<i class="fa fa-toggle-on text-success text-xl"></i>' 
                                : '<i class="fa fa-toggle-off text-muted text-xl"></i>';
                
                            return Html::a(
                                $icon,
                                ['toggle-status', 'id' => $model->id],
                                [
                                    'title' => $model->status === 'on' ? 'Tắt' : 'Bật',
                                    'data-pjax' => '0',
                                    'encode' => false,
                                ]
                            );
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>

    
</main>