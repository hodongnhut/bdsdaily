<?php
use yii\helpers\Html;
$this->title = 'Lịch Âm Dương - Xem Lịch Âm Dương Chính Xác Nhất';

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/lunar-javascript/1.6.13/lunar.js', [
    'position' => \yii\web\View::POS_HEAD, 
]);

$this->registerJsFile('@web/js/calendar.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->registerCssFile('@web/css/calendar.css');
?>

<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Lịch Âm Dương - Xem Lịch Âm Dương Chính Xác Nhất</div>
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

<!-- breadcrumb start-->
<main class="flex-1 p-6 overflow-auto">
<!-- breadcrumb start-->
<div id="calendar">
    <div class="header">
        <button id="prevMonth">❮</button>
        <span id="monthYear"></span>
        <button id="nextMonth">❯</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>Chủ Nhật</th>
                <th>Thứ Hai</th>
                <th>Thứ Ba</th>
                <th>Thứ Tư</th>
                <th>Thứ Năm</th>
                <th>Thứ Sáu</th>
                <th>Thứ Bảy</th>
            </tr>
        </thead>
        <tbody id="calendar-body">
            <!-- Calendar content will be inserted here -->
        </tbody>
    </table>
</div>
</main>