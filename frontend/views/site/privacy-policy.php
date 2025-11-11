<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Chính sách Quyền riêng tư - BDSdaily';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container mx-auto max-w-3xl bg-white p-6 my-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold text-gray-800 text-center mb-4">Chính sách Quyền riêng tư của BDSdaily</h1>
    <p class="text-gray-600 text-center mb-6"><strong>Cập nhật lần cuối: 11/11/2025</strong></p>

    <div class="prose prose-lg mx-auto text-gray-700">
        <h2 class="text-xl font-semibold text-gray-800 mt-8">1. Giới thiệu</h2>
        <p>
            BDSdaily là ứng dụng hỗ trợ Sales bất động sản tìm kiếm giỏ hàng, giá, diện tích, <strong>vị trí chính xác</strong>, và số điện thoại chủ nhà. 
            Chúng tôi cam kết bảo vệ dữ liệu cá nhân của Sales và chủ nhà, tuân thủ <strong>Luật An ninh mạng Việt Nam</strong> và <strong>chính sách Google Play</strong>.
        </p>

        <h2 class="text-xl font-semibold text-gray-800 mt-8">2. Dữ liệu chúng tôi thu thập</h2>
        <p>Chúng tôi thu thập các loại dữ liệu sau để cung cấp dịch vụ:</p>

        <ul class="list-disc pl-6 space-y-3">
            <li>
                <strong>Dữ liệu bất động sản:</strong>
                <ul class="list-disc pl-6 mt-1 space-y-1">
                    <li>Giá bán, diện tích, <strong>vị trí GPS chính xác</strong>, số điện thoại chủ nhà – thu thập từ batdongsan.com.vn, chotot.com hoặc đối tác.</li>
                </ul>
            </li>
            <li>
                <strong>Dữ liệu của Sales:</strong>
                <ul class="list-disc pl-6 mt-1 space-y-1">
                    <li>Tên, email, số điện thoại khi đăng ký hoặc liên hệ hỗ trợ.</li>
                    <li><strong>Lịch sử tìm kiếm, bất động sản đã xem hoặc lưu (App activity)</strong>.</li>
                    <li><strong>Vị trí chính xác (GPS, độ lệch dưới 10m)</strong> – chỉ khi bạn bật để gợi ý giỏ hàng gần nhất.</li>
                </ul>
            </li>
            <li>
                <strong>Dữ liệu thiết bị:</strong>
                <ul class="list-disc pl-6 mt-1 space-y-1">
                    <li><strong>ID thiết bị, hệ điều hành, phiên bản ứng dụng</strong> – để tối ưu hiệu suất và phân tích lỗi.</li>
                </ul>
            </li>
        </ul>

        <h2 class="text-xl font-semibold text-gray-800 mt-8">3. Nguồn dữ liệu & xác minh</h2>
        <p class="mb-2">Chúng tôi thu thập từ:</p>
        <ul class="list-disc pl-6 space-y-1">
            <li>Nền tảng công khai: batdongsan.com.vn, chotot.com, v.v.</li>
            <li>Đối tác hợp pháp: chủ đầu tư, công ty môi giới.</li>
        </ul>
        <p class="mt-3 mb-2">Dữ liệu được xác minh qua:</p>
        <ul class="list-disc pl-6 space-y-1">
            <li>Liên hệ trực tiếp với chủ nhà (nếu có).</li>
            <li>Đối chiếu với dữ liệu thị trường từ nguồn uy tín.</li>
        </ul>
        <p class="mt-3"><strong>Chỉ sử dụng dữ liệu hợp pháp và có sự đồng ý của chủ nhà (nếu cần).</strong></p>

        <h2 class="text-xl font-semibold text-gray-800 mt-8">4. Mục đích sử dụng</h2>
        <ul class="list-disc pl-6 space-y-2">
            <li>Hiển thị <strong>giỏ hàng gần nhất (dùng GPS chính xác)</strong> để Sales tư vấn nhanh.</li>
            <li>Cải thiện ứng dụng qua phân tích <strong>dữ liệu ẩn danh</strong> (Google Analytics, Firebase).</li>
            <li>Gửi thông báo dự án mới, cập nhật giá (nếu bạn bật).</li>
        </ul>

        <h2 class="text-xl font-semibold text-gray-800 mt-8">5. Chia sẻ dữ liệu</h2>
        <ul class="list-disc pl-6 space-y-2">
            <li><strong>Sales:</strong> Số điện thoại chủ nhà – chỉ khi dữ liệu hợp pháp hoặc có sự đồng ý.</li>
            <li><strong>Đối tác phân tích:</strong> Dữ liệu <strong>ẩn danh</strong> (không nhận diện cá nhân).</li>
            <li><strong>Không bán, không chia sẻ dữ liệu cá nhân</strong> cho bên thứ 3 không liên quan.</li>
        </ul>

        <h2 class="text-xl font-semibold text-gray-800 mt-8">6. Bảo mật & lưu trữ</h2>
        <ul class="list-disc pl-6 space-y-1">
            <li>Dữ liệu được mã hóa <strong>SSL/TLS</strong> toàn bộ.</li>
            <li>Lưu trữ <strong>tối đa 12 tháng</strong> hoặc đến khi bạn yêu cầu xóa.</li>
            <li>Số điện thoại chủ nhà được <strong>mã hóa nghiêm ngặt</strong> để tránh rò rỉ.</li>
        </ul>

        <h2 class="text-xl font-semibold text-gray-800 mt-8">7. Quyền của bạn</h2>
        <ul class="list-disc pl-6 space-y-2">
            <li><strong>Sales:</strong> Truy cập, sửa, xóa dữ liệu → Email: <a href="mailto:bdsdaily247@gmail.com" class="text-blue-600 hover:underline">bdsdaily247@gmail.com</a></li>
            <li><strong>Chủ nhà:</strong> Yêu cầu xóa số điện thoại hoặc thông tin liên hệ.</li>
            <li><strong>Phản hồi trong 7 ngày làm việc</strong>.</li>
        </ul>

        <h2 class="text-xl font-semibold text-gray-800 mt-8">8. Thông tin liên hệ</h2>
        <ul class="list-disc pl-6 space-y-1">
            <li>Email: <a href="mailto:bdsdaily247@gmail.com" class="text-blue-600 hover:underline">bdsdaily247@gmail.com</a></li>
            <li>SĐT: <a href="tel:+84845528145" class="text-blue-600 hover:underline">+84 845 528 145</a></li>
            <li>Privacy Policy: <a href="https://bdsdaily.com/privacy-policy.html" target="_blank" class="text-blue-600 hover:underline">https://bdsdaily.com/privacy</a></li>
        </ul>

        <h2 class="text-xl font-semibold text-gray-800 mt-8">9. Cập nhật chính sách</h2>
        <p>Chúng tôi sẽ <strong>thông báo trong ứng dụng + email</strong> khi có thay đổi.</p>
    </div>

    <div class="text-center mt-10 text-gray-500 text-sm">
        <p>© 2025 BDSdaily. Tất cả quyền được bảo lưu.</p>
    </div>
</div>