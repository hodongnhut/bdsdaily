<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string|null Recipient name from SalesContact */
/* @var $email string Recipient email for unsubscribe link */
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu BDSdaily - Nền tảng Bất động sản Dành cho Sales</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto bg-white p-6 my-6 rounded-lg shadow-lg">
        <!-- Header -->
        <div class="text-center">
            <a href="https://bdsdaily.com"  target="_blank">
                <img src="https://bdsdaily.com/img/logo.webp" alt="BDSdaily Logo" class="h-12 mx-auto mb-4">
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Chào mừng bạn đến với BDSdaily!</h1>
            <p class="text-gray-600 mt-2">Nền tảng hỗ trợ Sales bất động sản chốt giao dịch nhanh chóng</p>
        </div>

        <!-- Main Content -->
        <div class="mt-6">
            <p class="text-gray-600 mb-4">Kính gửi anh/chị <?= Html::encode($name ?: 'Quý Sales') ?>,</p>
            <p class="text-gray-600 mb-4">
                Bạn đang tìm kiếm công cụ để tối ưu hóa công việc kinh doanh bất động sản? <strong>BDSdaily</strong> là giải pháp dành cho anh/chị! Chúng tôi cung cấp <strong>giỏ hàng bất động sản đã được xác minh</strong>, bao gồm thông tin giá, diện tích, vị trí, và số điện thoại chủ nhà, giúp bạn tiết kiệm thời gian và tăng tỷ lệ chốt giao dịch.
            </p>
            <h2 class="text-xl font-semibold text-gray-800 mt-4">Tại sao chọn BDSdaily?</h2>
            <ul class="list-disc pl-5 text-gray-600 mb-4">
                <li><strong>Dữ liệu chính xác:</strong> Thông tin bất động sản được thu thập từ các nguồn uy tín (batdongsan.com.vn, chotot.com ...) và Nhân viên <strong>BDSDaily</strong> xác minh kỹ lưỡng.</li>
                <li><strong>Liên hệ trực tiếp:</strong> Cung cấp số điện thoại chủ nhà, giúp bạn kết nối nhanh chóng với khách hàng tiềm năng.</li>
                <li><strong>Cập nhật liên tục:</strong> Dự án mới được cập nhật hàng ngày, đảm bảo bạn luôn nắm bắt cơ hội.</li>
                <li><strong>Đồng bộ qua zalo Group:</strong> Khi có giỏ hàng mới tự động gửi qua Zalo Group.</li>
                <img src="https://bdsdaily.com//img/slider4.webp" alt="BDSdaily Logo" class="mb-4 mt-4">
                <li><strong>Hỗ trợ Bản Đồ Quy Hoạch:</strong> Bản Đồ Quy hoạch có sẵn check Số thửa ....</li>
                <img src="https://bdsdaily.com//img/slider2.webp" alt="BDSdaily Logo" class="mb-4 mt-4">
                <li><strong>Hỗ trợ App Mobile:</strong> Support App mobile</li>
                <img src="https://bdsdaily.com//img/slider1.webp" alt="BDSdaily Logo" class="mb-4 mt-4">
                <li><strong>Dễ sử dụng:</strong> Giao diện thân thiện, hỗ trợ tìm kiếm theo vị trí, giá, và loại hình bất động sản.</li>
                <img src="https://bdsdaily.com//img/slider3.webp" alt="BDSdaily Logo" class="mb-4 mt-4">
                <li><strong>Tham Gia Group Zalo:</strong> Tham gia nhận tin Group Zalo Daily.</li>
                <img src="https://sf-static.upanhlaylink.com/img/image_202508124c45842813c1e72ea4f16dd9513aa754.jpg" alt="BDSdaily Logo" class="mx-auto mb-4 mt-4">
                <li><strong>Dùng thử 7 ngày :</strong> Gói membership được Free 7 ngày.</li>
            </ul>
            <div class="text-center">
                <a href="https://bdsdaily.com"  target="_blank" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">Tìm hiểu thêm</a>
            </div>
        </div>


        <!-- Footer -->
        <div class="mt-6 text-center text-gray-500 text-sm">
            <p>© 2025 BDSdaily. Tất cả quyền được bảo lưu.</p>
            <p>Bạn nhận được email này vì đã đăng ký trên BDSdaily.</p>
            <p>
                <a href="https://bdsdaily.com/unsubscribe?email=<?= urlencode($email) ?>" class="text-blue-600 hover:underline">Hủy đăng ký nhận email</a> |
                <a href="https://bdsdaily.com/privacy-policy.php" class="text-blue-600 hover:underline">Chính sách Quyền riêng tư</a>
            </p>
            <p>Liên hệ: <a href="mailto:nhuthd@bdsdaily.com" class="text-blue-600 hover:underline">nhuthd@bdsdaily.com</a> | +84 934 880 855</p>
        </div>
    </div>
</body>
</html>
