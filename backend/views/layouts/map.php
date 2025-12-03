<?php

/** @var yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php $this->registerCsrfMetaTags() ?>

    <link rel="manifest" href="<?= Yii::$app->request->baseUrl ?>/manifest.json">
    <meta name="theme-color" content="#000000">

    <link rel="icon" sizes="192x192" href="<?= Yii::$app->request->baseUrl ?>/img/icon-192x192.png">
    <link rel="apple-touch-icon" href="<?= Yii::$app->request->baseUrl ?>/img/icon-192x192.png">

    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-TileImage" content="<?= Yii::$app->request->baseUrl ?>/img/icon-192x192.png">

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
    #install-pwa-btn {
        position: fixed;
        right: 20px;
        bottom: 20px;
        z-index: 9999;
        background: linear-gradient(135deg, #0d47a1, #1976d2);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 14px 20px;
        font-size: 15px;
        font-weight: 600;
        box-shadow: 0 8px 25px rgba(13, 71, 161, 0.4);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: inherit;
        opacity: 0;
        transform: translateY(100px);
    }


    #install-pwa-btn.show {
        opacity: 1;
        transform: translateY(0);
    }

    #install-pwa-btn:hover {
        background: linear-gradient(135deg, #1976d2, #42a5f5);
        transform: translateY(-3px) !important;
        box-shadow: 0 12px 30px rgba(13, 71, 161, 0.5);
    }

    @media (max-width: 768px) {
        #install-pwa-btn {
            padding: 12px 16px;
            font-size: 14px;
            right: 15px;
            bottom: 15px;
        }

        .btn-text {
            display: none;
        }
    }


    #install-pwa-btn.installed {
        opacity: 0;
        pointer-events: none;
        transform: translateY(100px);
    }
        </style>
</head>
<body>
<?php $this->beginBody() ?>

    <?= $content ?>

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
