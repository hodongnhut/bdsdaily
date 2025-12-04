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
        <a href="<?= Yii::$app->homeUrl ?>" class="flex items-center">
        <img src="<?= Yii::getAlias('@web') ?>/img/logo.webp" alt="BDSDaily" class="h-10 sm:h-12 w-auto flex-shrink-0">
            <div class="min-w-0"> 
                <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 leading-none">
                    BDSDaily
                </h1>
                <p class="text-sm sm:text-base md:text-lg font-medium text-gray-600 leading-tight mt-0.5 logo-slogan mb-0 text-muted fst-italic">
                    Phần Mềm Nhà Phố
                </p>
            </div>
        </a>
        
        <!-- Desktop Menu Links -->
        <div class="hidden md:flex space-x-6 text-sm font-medium items-center">
            <a href="https://bdsdaily.com/#gioi-thieu" class="text-gray-600 hover:text-indigo-600 transition duration-150">Giới Thiệu</a>
            <a href="https://bdsdaily.com/#du-lieu" class="text-gray-600 hover:text-indigo-600 transition duration-150">Dữ Liệu Của Chúng Tôi</a>
            <a href="https://bdsdaily.com/#dich-vu" class="text-gray-600 hover:text-indigo-600 transition duration-150">Dịch Vụ</a>
            <a href="https://bdsdaily.com/#goi-dich-vu" class="text-gray-600 hover:text-indigo-600 transition duration-150">Gói Dịch Vụ</a>
            <a href="https://bdsdaily.com/#phan-mem-nha-pho" class="text-gray-600 hover:text-indigo-600 transition duration-150">Thành Phố</a>
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
                <a href="#phan-mem-nha-pho" class="hover:text-indigo-400">Thành Phố</a>
                <a href="<?= Yii::getAlias('@web') ?>/privacy-policy.html" class="hover:text-indigo-400">Chính sách bảo mật</a>
                <a href="#document" class="hover:text-indigo-400">Tài Liệu</a>
                <a href="#app-mobile" class="hover:text-indigo-400">App Mobile</a>
                <a href="#zalo" class="hover:text-indigo-400">Zalo B2B</a>
                <a href="#lien-he" class="hover:text-indigo-400">Liên Hệ</a>
                <a href="https://bdsdaily.com/tin-tuc.html" class="hover:text-indigo-400">Daily News</a>
            </div>
        </div>
        <div class="border-t border-gray-700 pt-6 text-sm text-gray-400">
            Copyright ©2025 All rights reserved | The Company <b><a href="https://stonenetworktech.com/"
                target="_blank" rel="nofollow noopener" title="StoneNetwork">StoneNetwork</a></b>

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



<div id="app-notification-dialog" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="dialog-title" aria-hidden="true" role="dialog">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        <div class="relative w-full max-w-md transform overflow-hidden rounded-lg bg-white p-6 text-left align-middle shadow-xl transition-all sm:my-8 sm:max-w-lg">
            <button id="close-dialog" class="float-right text-gray-400 hover:text-gray-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="mt-2 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center">
                    <svg class="kOqhQd" aria-hidden="true" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0,0h40v40H0V0z"></path><g><path d="M19.7,19.2L4.3,35.3c0,0,0,0,0,0c0.5,1.7,2.1,3,4,3c0.8,0,1.5-0.2,2.1-0.6l0,0l17.4-9.9L19.7,19.2z" fill="#EA4335"></path><path d="M35.3,16.4L35.3,16.4l-7.5-4.3l-8.4,7.4l8.5,8.3l7.5-4.2c1.3-0.7,2.2-2.1,2.2-3.6C37.5,18.5,36.6,17.1,35.3,16.4z" fill="#FBBC04"></path><path d="M4.3,4.7C4.2,5,4.2,5.4,4.2,5.8v28.5c0,0.4,0,0.7,0.1,1.1l16-15.7L4.3,4.7z" fill="#4285F4"></path><path d="M19.8,20l8-7.9L10.5,2.3C9.9,1.9,9.1,1.7,8.3,1.7c-1.9,0-3.6,1.3-4,3c0,0,0,0,0,0L19.8,20z" fill="#34A853"></path></g></svg>
                </div>
                <h3 id="dialog-title" class="text-lg font-medium leading-6 text-gray-900 mt-4">App Mới Lên Google Store!</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">Ứng dụng Bất Động Sản Daily đã chính thức có mặt trên Google Play. Tải ngay để cập nhật dữ liệu bất động sản nhanh chóng, tiện lợi hơn!</p>
                </div>
                
                <div class="mt-4 flex justify-center space-x-3">
                    <button id="download-app" class="inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                        Tải Ngay
                    </button>
                    <button id="dismiss-dialog" class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const dialog = document.getElementById('app-notification-dialog');
    const closeBtn = document.getElementById('close-dialog');
    const dismissBtn = document.getElementById('dismiss-dialog');
    const downloadBtn = document.getElementById('download-app');
    
    if (!dialog) return;
    
    // Kiểm tra localStorage: hiển thị nếu chưa xem hôm nay
    const today = new Date().toDateString();
    const lastShown = localStorage.getItem('appNotificationShown');
    if (lastShown !== today) {
        dialog.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Ngăn scroll khi dialog mở
    }
    
    // Đóng dialog
    const closeDialog = () => {
        dialog.classList.add('hidden');
        document.body.style.overflow = ''; // Khôi phục scroll
        localStorage.setItem('appNotificationShown', today);
    };
    
    // Event listeners
    closeBtn?.addEventListener('click', closeDialog);
    dismissBtn?.addEventListener('click', closeDialog);
    
    // Tải app: mở Google Play (thay URL thực tế của app)
    downloadBtn?.addEventListener('click', () => {
        window.open('https://play.google.com/store/apps/details?id=com.bdsdaily', '_blank');
        closeDialog(); // Đóng sau khi click
    });
    
    // Đóng khi click backdrop
    dialog.addEventListener('click', (e) => {
        if (e.target === dialog) closeDialog();
    });
    
    // Đóng bằng ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !dialog.classList.contains('hidden')) {
            closeDialog();
        }
    });
});
</script>

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
