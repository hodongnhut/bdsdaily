<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Chính sách Quyền riêng tư - BDSdaily';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container mx-auto max-w-3xl bg-white p-6 my-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold text-gray-800 text-center mb-4">Chính sách Quyền riêng tư của BDSdaily</h1>
    <p class="text-gray-600 mb-6"><strong>Cập nhật lần cuối: 12/08/2025</strong></p>

    <h2 class="text-xl font-semibold text-gray-800 mt-6">1. Giới thiệu</h2>
    <p class="text-gray-600">BDSdaily là ứng dụng hỗ trợ Sales bất động sản tìm kiếm giỏ hàng, giá, diện tích, vị trí, và số điện thoại chủ nhà. Chúng tôi cam kết bảo vệ dữ liệu cá nhân của Sales và chủ nhà, đồng thời đảm bảo minh bạch trong việc thu thập và sử dụng dữ liệu.</p>

    <h2 class="text-xl font-semibold text-gray-800 mt-6">2. Dữ liệu chúng tôi thu thập</h2>
    <p class="text-gray-600 mb-2">Chúng tôi thu thập các loại dữ liệu sau để cung cấp dịch vụ:</p>
    <ul class="list-disc pl-5 text-gray-600">
        <li><strong>Dữ liệu bất động sản:</strong>
            <ul class="list-disc pl-5">
                <li>Giá bán, diện tích, vị trí, và số điện thoại chủ nhà, được thu thập từ các nền tảng công khai (như batdongsan.com.vn, chotot.com) hoặc đối tác (chủ đầu tư, công ty môi giới).</li>
            </ul>
        </li>
        <li><strong>Dữ liệu của Sales:</strong>
            <ul class="list-disc pl-5">
                <li>Thông tin cá nhân: Tên, email, số điện thoại khi đăng ký tài khoản hoặc liên hệ hỗ trợ.</li>
                <li>Dữ liệu hành vi: Lịch sử tìm kiếm giỏ hàng, bất động sản đã xem hoặc lưu.</li>
                <li>Dữ liệu vị trí (nếu bật): Vị trí GPS để hiển thị giỏ hàng gần khu vực của bạn.</li>
            </ul>
        </li>
        <li><strong>Dữ liệu thiết bị:</strong>
            <ul class="list-disc pl-5">
                <li>ID thiết bị, hệ điều hành để tối ưu hóa hiệu suất ứng dụng.</li>
            </ul>
        </li>
    </ul>

    <h2 class="text-xl font-semibold text-gray-800 mt-6">3. Nguồn dữ liệu và quy trình xác minh</h2>
    <p class="text-gray-600 mb-2">Chúng tôi thu thập thông tin bất động sản từ:</p>
    <ul class="list-disc pl-5 text-gray-600">
        <li>Các nền tảng công khai như batdongsan.com.vn, chotot.com, hoặc các website bất động sản khác.</li>
        <li>Đối tác hợp pháp như chủ đầu tư hoặc công ty môi giới.</li>
    </ul>
    <p class="text-gray-600 mt-2 mb-2">Dữ liệu (giá bán, diện tích, vị trí, số điện thoại chủ nhà) được xác minh thông qua:</p>
    <ul class="list-disc pl-5 text-gray-600">
        <li>Liên hệ trực tiếp với chủ nhà (nếu có).</li>
        <li>Đối chiếu với dữ liệu thị trường từ các nguồn uy tín.</li>
    </ul>
    <p class="text-gray-600">Chúng tôi đảm bảo chỉ sử dụng dữ liệu được thu thập hợp pháp và có sự đồng ý của chủ nhà (nếu cần).</p>

    <h2 class="text-xl font-semibold text-gray-800 mt-6">4. Mục đích sử dụng dữ liệu</h2>
    <p class="text-gray-600">Chúng tôi sử dụng dữ liệu để:</p>
    <ul class="list-disc pl-5 text-gray-600">
        <li>Cung cấp giỏ hàng bất động sản, giá, và số điện thoại chủ nhà để Sales liên hệ và tư vấn.</li>
        <li>Cải thiện trải nghiệm ứng dụng thông qua phân tích dữ liệu ẩn danh.</li>
        <li>Gửi thông báo về dự án mới hoặc cập nhật giá (nếu bạn đồng ý nhận thông báo).</li>
    </ul>

    <h2 class="text-xl font-semibold text-gray-800 mt-6">5. Chia sẻ dữ liệu</h2>
    <p class="text-gray-600">Chúng tôi có thể chia sẻ dữ liệu trong các trường hợp sau:</p>
    <ul class="list-disc pl-5 text-gray-600">
        <li>Số điện thoại chủ nhà được chia sẻ với Sales để hỗ trợ liên hệ, nhưng chỉ khi dữ liệu được thu thập hợp pháp hoặc có sự đồng ý của chủ nhà.</li>
        <li>Dữ liệu ẩn danh được chia sẻ với đối tác phân tích (như Google Analytics, Firebase) để cải thiện ứng dụng.</li>
        <li>Chúng tôi không bán hoặc chia sẻ dữ liệu cá nhân cho các bên không liên quan.</li>
    </ul>

    <h2 class="text-xl font-semibold text-gray-800 mt-6">6. Bảo mật và lưu trữ dữ liệu</h2>
    <p class="text-gray-600">
        - Dữ liệu được lưu trữ trên máy chủ an toàn với mã hóa SSL.<br>
        - Chúng tôi lưu dữ liệu trong 12 tháng hoặc đến khi bạn yêu cầu xóa.<br>
        - Số điện thoại chủ nhà được bảo vệ nghiêm ngặt để tránh rò rỉ hoặc lạm dụng.
    </p>

    <h2 class="text-xl font-semibold text-gray-800 mt-6">7. Quyền của người dùng</h2>
    <p class="text-gray-600">
        - <strong>Sales:</strong> Bạn có thể truy cập, chỉnh sửa, hoặc yêu cầu xóa dữ liệu cá nhân bằng cách liên hệ qua email <a href="mailto:nhuthd@bdsdaily.com" class="text-blue-600 hover:underline">nhuthd@bdsdaily.com</a>.<br>
        - <strong>Chủ nhà:</strong> Bạn có quyền yêu cầu xóa số điện thoại hoặc thông tin liên hệ của mình.<br>
        - Chúng tôi sẽ phản hồi yêu cầu trong vòng 7 ngày làm việc.
    </p>

    <h2 class="text-xl font-semibold text-gray-800 mt-6">8. Thông tin liên hệ</h2>
    <p class="text-gray-600">Nếu có câu hỏi về quyền riêng tư, vui lòng liên hệ:</p>
    <ul class="list-disc pl-5 text-gray-600">
        <li>Email: <a href="mailto:nhuthd@bdsdaily.com" class="text-blue-600 hover:underline">nhuthd@bdsdaily.com</a></li>
        <li>Số điện thoại: +84 934 880 855</li>
    </ul>

    <h2 class="text-xl font-semibold text-gray-800 mt-6">9. Cập nhật chính sách</h2>
    <p class="text-gray-600">Chúng tôi có thể cập nhật chính sách này và sẽ thông báo qua email hoặc trong ứng dụng.</p>

    <div class="text-center mt-6 text-gray-500 text-sm">
        <p>&copy; 2025 BDSdaily. Tất cả quyền được bảo lưu.</p>
    </div>
</div>