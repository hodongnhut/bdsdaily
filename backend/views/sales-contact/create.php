<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SalesContact $model */

$this->title = 'Create Sales Contact';
$this->params['breadcrumbs'][] = ['label' => 'Sales Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Tin Tức SEO</div>
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
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</main>
