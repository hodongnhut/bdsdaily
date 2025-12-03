<?php

/** @var \yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\Nav;
use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;
use backend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="manifest" href="<?= Yii::$app->request->baseUrl ?>/manifest.json">
    <meta name="theme-color" content="#000000">

    <link rel="icon" sizes="192x192" href="<?= Yii::$app->request->baseUrl ?>/img/icon-192x192.png">
    <link rel="apple-touch-icon" href="<?= Yii::$app->request->baseUrl ?>/img/icon-192x192.png">

    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-TileImage" content="<?= Yii::$app->request->baseUrl ?>/img/icon-192x192.png">

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
        #install-pwa-btn {
            @apply fixed bottom-6 right-6 bg-blue-600 text-white px-5 py-3 rounded-full shadow-2xl flex items-center space-x-3 hover:bg-blue-700 transition z-50 opacity-0 invisible;
        }
        #install-pwa-btn.show {
            @apply opacity-100 visible;
        }
        #install-pwa-btn.installed {
            @apply bg-green-600 hover:bg-green-700;
        }
        #install-pwa-btn .btn-text installed::after {
            content: "Đã cài đặt";
        }
        </style>
</head>
<body class="flex min-h-screen bg-gray-100">
<?php $this->beginBody() ?>
    <button id="mobile-sidebar-toggle" class="md:hidden fixed top-4 left-4 z-50 p-2 rounded-full bg-blue-600 text-white shadow-lg">
        <i class="fas fa-bars"></i>
    </button>
    <aside id="main-sidebar" class="flex flex-col items-start py-4">
        <div class="mb-8 px-3 group">
            <div class="h-13 w-13 rounded-lg flex items-center justify-center text-white text-xl font-bold transition-transform duration-300">
                <img src="<?= Yii::$app->request->baseUrl ?>/img/logo.webp" alt="King Land" class="h-full w-full object-contain img-logo">
            </div>
        </div>
        <nav class="flex flex-col space-y-2 w-full">
            <a href="<?= Yii::$app->homeUrl ?>" class="nav-item <?= Yii::$app->request->pathInfo === '' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="Màn hình chính">
                <i class="fas fa-tachometer text-xl"></i>
                <span>Màn hình chính</span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/news']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'post' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="Bản tin nội bộ">
                <i class="fas fa-newspaper text-xl"></i>
                <span>Bản tin nội bộ</span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/property']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'index' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="Dữ liệu Nhà Đất">
                <i class="fas fa-house text-xl"></i>
                <span>Dữ Liệu Nhà Đất</span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/property/my-favorites']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'my-favorites' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="My Favorites">
                <i class="fas fa-heartbeat text-xl"></i>
                <span>BĐS Yêu Thích</span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/ban-do-quy-hoach']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'map' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="BĐ Quy Hoạch">
                <i class="fas fa-map text-xl"></i>
                <span>Bản Đồ  Quy Hoạch</span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/sales-contact']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'map' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="BĐ Quy Hoạch">
                <i class="fas fa-users text-xl"></i>
                <span>Danh Bạ Sales</span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/loan']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'loan' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="BĐ Quy Hoạch">
                <i class="fas fa-calculator text-xl"></i>
                <span>Check Khoản Vay</span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/calendar']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'calendar' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="BĐ Quy Hoạch">
                <i class="fas fa-calendar text-xl"></i>
                <span>Lịch Âm Dương</span>
            </a>
            <?php if (!Yii::$app->user->isGuest && in_array(Yii::$app->user->identity->jobTitle->role_code, ['manager', 'super_admin'])): ?>
                <a href="<?= \yii\helpers\Url::to(['/property/users']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'users' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="Quản Lý Nhân Viên">
                    <i class="fas fa-users text-xl"></i>
                    <span>Nhân Viên</span>
                </a>
               
                <a href="<?= \yii\helpers\Url::to(['/email-campaign']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'email-campaign' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="Quản Lý Nhân Viên">
                    <i class="fas fa-envelope text-xl"></i>
                    <span>Email Marketing</span>
                </a>

                <a href="<?= \yii\helpers\Url::to(['/news-extranaly']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'email-campaign' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="Chủ để SEO ">
                    <i class="fas fa-newspaper text-xl"></i>
                    <span>Website Marketing</span>
                </a>

                <a href="<?= \yii\helpers\Url::to(['/zalo-marketing']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'email-campaign' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="Chủ để SEO ">
                    <img src="/img/zalo.png" alt="Zalo" class="zalo-icon-nav text-xl">
                    <span>Zalo Marketing</span>
                </a>
            <?php endif; ?>
            
        </nav>
    </aside>

    <div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>


    <div class="flex-1 flex flex-col">
        <?= $content ?>
    </div>

    <button id="install-pwa-btn" title="Cài đặt ứng dụng vào Desktop">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="7 10 12 15 17 10"></polyline>
            <line x1="12" y1="15" x2="12" y2="3"></line>
            <rect x="4" y="20" width="16" height="2" rx="1"></rect>
        </svg>
        <span class="btn-text">Cài vào Desktop</span>
    </button>

    <script>
        const userMenuButton = document.getElementById('userMenuButton');
        const userMenu = document.getElementById('userMenu');
        let timeoutId;

        userMenuButton.addEventListener('mouseenter', () => {
            clearTimeout(timeoutId);
            userMenu.classList.remove('hidden');
            userMenuButton.setAttribute('aria-expanded', 'true');
        });

        userMenuButton.addEventListener('mouseleave', () => {
            timeoutId = setTimeout(() => {
                userMenu.classList.add('hidden');
                userMenuButton.setAttribute('aria-expanded', 'false');
            }, 300);
        });

        userMenu.addEventListener('mouseenter', () => {
            clearTimeout(timeoutId);
        });

        userMenu.addEventListener('mouseleave', () => {
            timeoutId = setTimeout(() => {
                userMenu.classList.add('hidden');
                userMenuButton.setAttribute('aria-expanded', 'false');
            }, 300);
        });

        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        const mainSidebar = document.getElementById('main-sidebar');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');

        function toggleSidebar() {
            mainSidebar.classList.toggle('aside-open');
            sidebarBackdrop.classList.toggle('show');
        }

        if (mobileSidebarToggle && mainSidebar && sidebarBackdrop) {
            mobileSidebarToggle.addEventListener('click', toggleSidebar);
            sidebarBackdrop.addEventListener('click', toggleSidebar); 

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && mainSidebar.classList.contains('aside-open')) {
                    toggleSidebar();
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) { 
                    mainSidebar.classList.remove('aside-open');
                    sidebarBackdrop.classList.remove('show');
                }
            });
        }

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('SW registered'))
                    .catch(err => console.log('SW failed:', err));
            });
        }

        let deferredPrompt;
        const installBtn = document.getElementById('install-pwa-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            installBtn.classList.add('show');
        });

        installBtn.addEventListener('click', async () => {
            if (!deferredPrompt) return;
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            if (outcome === 'accepted') {
                installBtn.classList.remove('show');
                installBtn.classList.add('installed');
                installBtn.querySelector('.btn-text').textContent = 'Đã cài đặt';
            }
            deferredPrompt = null;
        });

        window.addEventListener('appinstalled', () => {
            installBtn.classList.remove('show');
            installBtn.classList.add('installed');
        });
    </script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
