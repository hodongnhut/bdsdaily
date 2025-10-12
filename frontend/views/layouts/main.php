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

<header class="bg-white shadow-lg sticky top-0 z-50">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <a href="/" class="flex items-center">
            <!-- Đảm bảo ảnh logo được đặt trong thư mục @web/img/ -->
            <img src="<?= Yii::getAlias('@web') ?>/img/logo.webp" alt="Bất Động Sản Daily" class="h-12 sm:h-14 w-auto">
        </a>
        
        <!-- Desktop Menu Links -->
        <div class="hidden md:flex space-x-6 text-sm font-medium items-center">
            <a href="https://bdsdaily.com/#gioi-thieu" class="text-gray-600 hover:text-indigo-600 transition duration-150">Giới Thiệu</a>
            <a href="https://bdsdaily.com/#du-lieu" class="text-gray-600 hover:text-indigo-600 transition duration-150">Dữ Liệu Của Chúng Tôi</a>
            <a href="https://bdsdaily.com/#dich-vu" class="text-gray-600 hover:text-indigo-600 transition duration-150">Dịch Vụ</a>
            <a href="https://bdsdaily.com/#goi-dich-vu" class="text-gray-600 hover:text-indigo-600 transition duration-150">Gói Dịch Vụ</a>
            <a href="https://bdsdaily.com/#document" class="text-gray-600 hover:text-indigo-600 transition duration-150">Tài Liệu</a>
            <a href="https://bdsdaily.com/#app-mobile" class="text-gray-600 hover:text-indigo-600 transition duration-150">App Mobile</a>
            <a href="https://bdsdaily.com/#zalo" class="text-gray-600 hover:text-indigo-600 transition duration-150">Zalo B2B</a>
            <a href="https://bdsdaily.com/tin-tuc.html" class="text-gray-600 hover:text-indigo-600 transition duration-150">Daily News</a>
            <a href="https://bdsdaily.com/#lien-he"
                class="text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-full shadow-md transition-colors duration-300 transform hover:scale-[1.03]">Liên
                Hệ</a>
        </div>
        
        <!-- Mobile Menu Button with ID for JS interaction -->
        <button id="mobile-menu-button" class="md:hidden text-gray-600 focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition">
            <svg id="menu-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </nav>

    <!-- Mobile Menu Container (Initially hidden on all screens, controlled by JS on mobile) -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-md pb-4">
        <div class="flex flex-col space-y-2 px-6 pt-3 text-base font-medium">
            <!-- Mirroring desktop links for mobile view -->
            <a href="https://bdsdaily.com/#gioi-thieu" class="text-gray-700 hover:bg-indigo-50 px-3 py-2 rounded-lg transition duration-150">Giới Thiệu</a>
            <a href="https://bdsdaily.com/#du-lieu" class="text-gray-700 hover:bg-indigo-50 px-3 py-2 rounded-lg transition duration-150">Dữ Liệu Của Chúng Tôi</a>
            <a href="https://bdsdaily.com/#dich-vu" class="text-gray-700 hover:bg-indigo-50 px-3 py-2 rounded-lg transition duration-150">Dịch Vụ</a>
            <a href="https://bdsdaily.com/#goi-dich-vu" class="text-gray-700 hover:bg-indigo-50 px-3 py-2 rounded-lg transition duration-150">Gói Dịch Vụ</a>
            <a href="https://bdsdaily.com/#document" class="text-gray-700 hover:bg-indigo-50 px-3 py-2 rounded-lg transition duration-150">Tài Liệu</a>
            <a href="https://bdsdaily.com/#app-mobile" class="text-gray-700 hover:bg-indigo-50 px-3 py-2 rounded-lg transition duration-150">App Mobile</a>
            <a href="https://bdsdaily.com/#zalo" class="text-gray-700 hover:bg-indigo-50 px-3 py-2 rounded-lg transition duration-150">Zalo B2B</a>
            <a href="https://bdsdaily.com/tin-tuc.html" class="text-gray-700 hover:bg-indigo-50 px-3 py-2 rounded-lg transition duration-150">Daily News</a>
            
            <!-- Link Liên Hệ (Button style) -->
            <a href="https://bdsdaily.com/#lien-he" 
                class="text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-2 rounded-lg text-center mt-2 shadow-md transition duration-150">Liên Hệ
            </a>
        </div>
    </div>
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
                <a href="https://bdsdaily.com/tin-tuc.html" class="hover:text-indigo-400">Daily News</a>
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
<!-- JavaScript cho Mobile Menu Toggle -->
<script>
    // Đảm bảo DOM đã tải xong trước khi gắn sự kiện
    document.addEventListener('DOMContentLoaded', () => {
        const button = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');

        if (button && menu && iconOpen && iconClose) {
            button.addEventListener('click', () => {
                // Toggle ẩn/hiện menu
                menu.classList.toggle('hidden');
                
                // Toggle icon (Hamburger <-> X)
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');
            });
            
            // Tự động ẩn menu khi nhấp vào một liên kết (giả định liên kết là anchor links)
            const mobileLinks = menu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (!menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                        iconOpen.classList.remove('hidden');
                        iconClose.classList.add('hidden');
                    }
                });
            });

            // Xử lý khi resize cửa sổ (chắc chắn menu ẩn trên desktop)
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) { // 768px là breakpoint 'md:' của Tailwind
                    menu.classList.add('hidden');
                    iconOpen.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                }
            });
        }
    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
