<?php

/** @var \yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\Nav;
use yii\bootstrap5\Html;
use common\widgets\Alert;
use yii\bootstrap5\NavBar;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <!-- Thư viện Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Phông chữ Inter từ Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="text-gray-800">
<?php $this->beginBody() ?>

<header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="flex items-center">
            <img src="<?= Yii::getAlias('@web') ?>/img/logo.webp" alt="Bất Động Sản Daily" class="h-14 w-auto">
        </a>
        <div class="hidden md:flex space-x-6 text-sm font-medium">
            <a href="https://bdsdaily.com/#gioi-thieu" class="text-gray-600 hover:text-indigo-600">Giới Thiệu</a>
            <a href="https://bdsdaily.com/#du-lieu" class="text-gray-600 hover:text-indigo-600">Dữ Liệu Của Chúng Tôi</a>
            <a href="https://bdsdaily.com/#dich-vu" class="text-gray-600 hover:text-indigo-600">Dịch Vụ</a>
            <a href="https://bdsdaily.com/#goi-dich-vu" class="text-gray-600 hover:text-indigo-600">Gói Dịch Vụ</a>
            <a href="https://bdsdaily.com/#document" class="text-gray-600 hover:text-indigo-600">Tài Liệu</a>
            <a href="https://bdsdaily.com/#app-mobile" class="text-gray-600 hover:text-indigo-600">App Mobile</a>
            <a href="https://bdsdaily.com/#zalo" class="text-gray-600 hover:text-indigo-600">Zalo B2B</a>
            <a href="https://bdsdaily.com/#lien-he"
                class="text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-full transition-colors duration-300">Liên
                Hệ</a>
        </div>
        <!-- Mobile Menu Button -->
        <button class="md:hidden text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
    </nav>
</header>

<main role="main" class="flex-shrink-0">
    <?= $content ?>
</main>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-6 text-center">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 mb-8">
            <a href="/" class="flex items-center">
                <img src="<?= Yii::getAlias('@web') ?>/img/logo_footer.webp" alt="Bất Động Sản Daily" class="h-14 w-auto">
            </a>
            <div class="space-x-6 text-sm font-medium">
                <a href="#gioi-thieu" class="hover:text-indigo-400">Giới Thiệu</a>
                <a href="#du-lieu" class="hover:text-indigo-400">Dữ Liệu</a>
                <a href="#dich-vu" class="hover:text-indigo-400">Dịch Vụ</a>
                <a href="#goi-dich-vu" class="hover:text-indigo-400">Gói Dịch Vụ</a>
                <a href="<?= Yii::getAlias('@web') ?>/privacy-policy.html" class="hover:text-indigo-400">Chính sách bảo mật</a>
                <a href="#document" class="hover:text-indigo-400">Tài Liệu</a>
                <a href="#app-mobile" class="hover:text-indigo-400">App Mobile</a>
                <a href="#zalo" class="hover:text-indigo-400">Zalo B2B</a>
                <a href="#lien-he" class="hover:text-indigo-400">Liên Hệ</a>
            </div>
        </div>
        <div class="border-t border-gray-700 pt-6 text-sm text-gray-400">
            Copyright ©2025 All rights reserved | The Company <b><a href="https://bdsdaily.com/"
                target="_blank" rel="nofollow noopener" title="BDSDaily">BDSDaily</a></b>

        </div>
    </div>
</footer>

<div id="button-contact-vr">
    <div id="gom-all-in-one">
        <div id="zalo-vr" class="button-contact">
            <div class="phone-vr">
                <div class="phone-vr-circle-fill"></div>
                <div class="phone-vr-img-circle">
                    <a target="_blank" href="https://zalo.me/0845528145 ">
                        <img alt="Zalo" src="https://bdsdaily.com/img/zalo.png">
                    </a>
                </div>
            </div>
        </div>
        <div id="phone-vr" class="button-contact">
            <div class="phone-vr">
                <div class="phone-vr-circle-fill"></div>
                <div class="phone-vr-img-circle">
                    <a href="tel:0845528145">
                        <img alt="Phone" src="https://bdsdaily.com/img/phone.png">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
