<?php $this->title = 'Không có kết nối mạng'; ?>
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="text-center">
        <img src="<?= Yii::$app->request->baseUrl ?>/img/offline-banner.jpg" alt="Offline" class="w-64 mx-auto mb-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Không có kết nối Internet</h1>
        <p class="text-gray-600 mb-8">Ứng dụng vẫn hoạt động offline. Vui lòng kiểm tra kết nối để cập nhật dữ liệu mới nhất.</p>
        <button onclick="location.reload()" class="px-8 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition">
            Thử lại
        </button>
    </div>
</div>