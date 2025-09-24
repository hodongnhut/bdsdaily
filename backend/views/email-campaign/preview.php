<?php
use yii\helpers\Html;

$this->title = 'Preview Email for Campaign: ' . Html::encode($campaign->subject);
$this->params['breadcrumbs'][] = ['label' => 'Email Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Xem Bản Tin Nội Bộ</div>
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
    <div class="email-campaign-preview">
        <h1><?= Html::encode($this->title) ?></h1>
        <h3>Contact: <?= Html::encode($contact->name) ?> (<?= Html::encode($contact->email) ?>)</h3>
        <div style="border: 1px solid #ccc; padding: 20px; background: #f9f9f9;">
            <h4>Subject: <?= Html::encode($campaign->subject) ?></h4>
            <div><?= $content ?></div>
        </div>
        <p>
            <?= Html::a('Back to Campaigns', ['index'], ['class' => 'btn btn-primary']) ?>
            <?php if ($contact->id): ?>
                <?= Html::a('Test Send', ['test-send', 'id' => $campaign->id, 'contact_id' => $contact->id], ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </p>
    </div>
</main>