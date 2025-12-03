<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Không có kết nối Internet</title>
    <link rel="manifest" href="<?= Yii::$app->request->baseUrl ?>/manifest.json">
    <link rel="icon" sizes="192x192" href="<?= Yii::$app->request->baseUrl ?>/img/icon-192x192.png">
    <meta name="theme-color" content="#2563eb">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <img src="<?= Yii::$app->request->baseUrl ?>/img/offline-banner.png" 
             alt="Offline" 
             class="w-64 mx-auto mb-8 drop-shadow-lg"
             onerror="this.src='<?= Yii::$app->request->baseUrl ?>/img/offline-banner.png'">
        
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Không có Internet</h1>
        <p class="text-lg text-gray-600 mb-8">
            Ứng dụng vẫn hoạt động offline.<br>
            Kết nối lại để nhận dữ liệu mới nhất.
        </p>

        <div class="space-x-4">
            <button onclick="window.location.reload()" 
                    class="px-8 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg">
                Thử lại
            </button>
            <button onclick="window.history.back()" 
                    class="px-8 py-3 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 transition">
                Quay lại
            </button>
        </div>

        <p class="text-sm text-gray-500 mt-12">
            BDS Daily - Phần Mềm Nhà Phố
        </p>
    </div>
</body>
</html>