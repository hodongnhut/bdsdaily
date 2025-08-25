<?php
// File: backend/views/email-campaign/email-template.php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string|null Recipient name from SalesContact */
/* @var $email string Recipient email for unsubscribe link */
/* @var $subject string Campaign subject */
/* @var $content string Campaign content */
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu BDSdaily - Nền tảng Bất động sản Dành cho Sales</title>
</head>
<body style="background-color: #f3f4f6; margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; margin: 20px auto; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <!-- Header -->
        <tr>
            <td align="center" style="padding-bottom: 20px;">
                <a href="https://bdsdaily.com" target="_blank">
                    <img src="https://bdsdaily.com/img/logo.webp" alt="BDSdaily Logo" style="height: 48px; display: block; margin: 0 auto;">
                </a>
                <h1 style="font-size: 24px; font-weight: bold; color: #1f2937; margin: 16px 0 8px;">Chào mừng bạn đến với BDSdaily!</h1>
                <p style="font-size: 16px; color: #6b7280; margin: 0;">Nền tảng hỗ trợ Sales bất động sản chốt giao dịch nhanh chóng</p>
            </td>
        </tr>

        <!-- Main Content -->
        <tr>
            <td style="padding: 0 20px 20px;">
                <p style="font-size: 16px; color: #6b7280; margin: 0 0 16px;">Kính gửi anh/chị <?= Html::encode($name ?: 'Quý Sales') ?>,</p>
                <p style="font-size: 16px; color: #6b7280; margin: 0 0 16px;">
                    Bạn đang tìm kiếm công cụ để tối ưu hóa công việc kinh doanh bất động sản? <strong>BDSdaily</strong> là giải pháp dành cho anh/chị! Chúng tôi cung cấp <strong>giỏ hàng bất động sản đã được xác minh</strong>, bao gồm thông tin giá, diện tích, vị trí, và số điện thoại chủ nhà, giúp bạn tiết kiệm thời gian và tăng tỷ lệ chốt giao dịch.
                </p>
                <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin: 16px 0;">Tại sao chọn BDSdaily?</h2>
                <ul style="font-size: 16px; color: #6b7280; margin: 0 0 16px; padding-left: 20px;">
                    <li><strong>Dữ liệu chính xác:</strong> Thông tin bất động sản được thu thập từ các nguồn uy tín (batdongsan.com.vn, chotot.com ...) và Nhân viên <strong>BDSDaily</strong> xác minh kỹ lưỡng.</li>
                    <li><strong>Liên hệ trực tiếp:</strong> Cung cấp số điện thoại chủ nhà, giúp bạn kết nối nhanh chóng với khách hàng tiềm năng.</li>
                    <li><strong>Cập nhật liên tục:</strong> Dự án mới được cập nhật hàng ngày, đảm bảo bạn luôn nắm bắt cơ hội.</li>
                    <li><strong>Đồng bộ qua Zalo Group:</strong> Khi có giỏ hàng mới tự động gửi qua Zalo Group.</li>
                    <li><img src="https://bdsdaily.com/img/slider4.webp" alt="BDSdaily Feature" style="display: block; margin: 16px 0; max-width: 100%;"></li>
                    <li><strong>Hỗ trợ Bản Đồ Quy Hoạch:</strong> Bản Đồ Quy hoạch có sẵn check Số thửa ....</li>
                    <li><img src="https://bdsdaily.com/img/slider2.webp" alt="BDSdaily Feature" style="display: block; margin: 16px 0; max-width: 100%;"></li>
                    <li><strong>Hỗ trợ App Mobile:</strong> Support App mobile</li>
                    <li><img src="https://bdsdaily.com/img/slider1.webp" alt="BDSdaily Feature" style="display: block; margin: 16px 0; max-width: 100%;"></li>
                    <li><strong>Dễ sử dụng:</strong> Giao diện thân thiện, hỗ trợ tìm kiếm theo vị trí, giá, và loại hình bất động sản.</li>
                    <li><img src="https://bdsdaily.com/img/slider3.webp" alt="BDSdaily Feature" style="display: block; margin: 16px 0; max-width: 100%;"></li>
                    <li><strong>Tham Gia Group Zalo:</strong> Tham gia nhận tin Group Zalo Daily.</li>
                    <li><img src="https://sf-static.upanhlaylink.com/img/image_202508124c45842813c1e72ea4f16dd9513aa754.jpg" alt="Zalo Group QR" style="display: block; margin: 16px auto; max-width: 100%;"></li>
                    <li><strong>Dùng thử 7 ngày:</strong> Gói membership được Free 7 ngày.</li>
                </ul>
                <div style="text-align: center; margin: 20px 0;">
                    <a href="https://bdsdaily.com" target="_blank" style="display: inline-block; background-color: #2563eb; color: #ffffff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-size: 16px;">Tìm hiểu thêm</a>
                </div>
                <!-- Custom Content from Campaign -->
                
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="text-align: center; padding: 20px; font-size: 14px; color: #6b7280;">
                <p style="margin: 0 0 8px;">© 2025 BDSdaily. Tất cả quyền được bảo lưu.</p>
                <p style="margin: 0 0 8px;">Bạn nhận được email này vì đã đăng ký trên BDSdaily.</p>
                <p style="margin: 0 0 8px;">
                    <a href="https://bdsdaily.com/unsubscribe?email=<?= urlencode($email) ?>" style="color: #2563eb; text-decoration: underline;">Hủy đăng ký nhận email</a> |
                    <a href="https://bdsdaily.com/privacy-policy.php" style="color: #2563eb; text-decoration: underline;">Chính sách Quyền riêng tư</a>
                </p>
                <p style="margin: 0;">Liên hệ: <a href="mailto:nhuthd@bdsdaily.com" style="color: #2563eb; text-decoration: underline;">nhuthd@bdsdaily.com</a> | +84 934 880 855</p>
            </td>
        </tr>
    </table>
</body>
</html>