<?php
/** @var \yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\Html;
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

    <!-- PWA Manifest & Icons -->
    <link rel="manifest" href="<?= Yii::$app->request->baseUrl ?>/manifest.json">
    <meta name="theme-color" content="#0d47a1">

    <link rel="icon" sizes="192x192" href="<?= Yii::$app->request->baseUrl ?>/img/icon-192x192.png">
    <link rel="apple-touch-icon" href="<?= Yii::$app->request->baseUrl ?>/img/icon-192x192.png">
    <meta name="msapplication-TileColor" content="#0d47a1">
    <meta name="msapplication-TileImage" content="<?= Yii::$app->request->baseUrl ?>/img/icon-192x192.png">

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- CSS cho nút Install PWA - đẹp lung linh, fixed góc dưới phải -->
    <style>
        #install-pwa-btn {
            @apply fixed bottom-6 right-6 z-50 flex items-center gap-3 px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-full shadow-2xl transition-all duration-500 opacity-0 translate-y-20;
        }
        #install-pwa-btn.show {
            @apply opacity-100 translate-y-0;
        }
        #install-pwa-btn:hover {
            @apply from-blue-700 to-blue-800 shadow-3xl -translate-y-1;
        }
        #install-pwa-btn.installed {
            @apply opacity-0 translate-y-20 pointer-events-none;
        }
        @media (max-width: 640px) {
            #install-pwa-btn { @apply px-4 py-4 bottom-4 right-4; }
            #install-pwa-btn .btn-text { @apply hidden; }
        }
    </style>
</head>
<body class="flex min-h-screen bg-gray-100">
<?php $this->beginBody() ?>

    <!-- Mobile menu button -->
    <button id="mobile-sidebar-toggle" class="md:hidden fixed top-4 left-4 z-50 p-2 rounded-full bg-blue-600 text-white shadow-lg">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside id="main-sidebar" class="flex flex-col items-start py-4">
        <!-- Logo + Menu của bạn giữ nguyên 100% -->
        <div class="mb-8 px-3 group">
            <div class="h-13 w-13 rounded-lg flex items-center justify-center text-white text-xl font-bold transition-transform duration-300">
                <img src="<?= Yii::$app->request->baseUrl ?>/img/logo.webp" alt="King Land" class="h-full w-full object-contain img-logo">
            </div>
        </div>
        <nav class="flex flex-col space-y-2 w-full">
            <!-- Tất cả menu của bạn giữ nguyên ở đây -->
            <a href="<?= Yii::$app->homeUrl ?>" class="nav-item <?= Yii::$app->request->pathInfo === '' ? 'bg-blue-100 text-blue-600' : '' ?>">
                <i class="fas fa-tachometer text-xl"></i><span>Màn hình chính</span>
            </a>
            <!-- ... các menu khác của bạn ... -->
            <!-- (mình giữ nguyên như file bạn gửi) -->
        </nav>
    </aside>

    <div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

    <!-- NÚT CÀI ĐẶT PWA SIÊU ĐẸP -->
    <button id="install-pwa-btn" title="Cài đặt ứng dụng vào Desktop">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="7 10 12 15 17 10"></polyline>
            <line x1="12" y1="15" x2="12" y2="3"></line>
            <rect x="4" y="20" width="16" height="2" rx="1"></rect>
        </svg>
        <span class="btn-text">Cài vào Desktop</span>
    </button>

    <div class="flex-1 flex flex-col">
        <?= $content ?>
    </div>

    <!-- FIX TAILWIND PURGE - Dòng này bắt buộc để class show/installed không bị xóa -->
    <div class="hidden show installed opacity-100 translate-y-0 pointer-events-none"></div>

    <!-- Script Sidebar Mobile -->
    <script>
        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        const mainSidebar = document.getElementById('main-sidebar');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');

        function toggleSidebar() {
            mainSidebar.classList.toggle('aside-open');
            sidebarBackdrop.classList.toggle('show');
        }
        mobileSidebarToggle?.addEventListener('click', toggleSidebar);
        sidebarBackdrop?.addEventListener('click', toggleSidebar);
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && mainSidebar.classList.contains('aside-open')) toggleSidebar();
        });
    </script>

    <!-- PWA Install Script - HOÀN CHỈNH -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('SW registered'))
                    .catch(err => console.log('SW error:', err));
            });
        }

        let deferredPrompt;
        const installButton = document.getElementById('install-pwa-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            installButton.classList.add('show');
        });

        installButton?.addEventListener('click', async () => {
            if (!deferredPrompt) return;
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            if (outcome === 'accepted') {
                installButton.classList.remove('show');
                installButton.classList.add('installed');
            }
            deferredPrompt = null;
        });

        window.addEventListener('appinstalled', () => {
            installButton.classList.remove('show');
            installButton.classList.add('installed');
        });
    </script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>