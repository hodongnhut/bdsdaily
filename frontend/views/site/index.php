<?php

/** @var yii\web\View $this */

$this->title = 'Phần Mềm Nhà Phố';


$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'phần mềm nhà phố, phan mem nha pho, phần mềm giỏ hàng nhà phố, phan mem gio hang nha pho, phần mềm BDSDaily, phan mem bds nha pho, phần mềm quản lý nhà phố, phan mem nha pho hcm, app nhà phố, app nha pho', 
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Phần mềm bất động sản BDSDaily giành riêng cho nhà phố, Giải pháp chuẩn hóa từ quản lý Nhân sự, Quản lý KPI Kinh Doanh, Quản lý sản phẩm giỏ hàng, trang bị công cụ tiện ích bản đồ quy hoạch, marketing ...  tối ưu cho mô hình kinh doanh bất động sản nhà phố'
]);

$this->registerMetaTag([
    'property' => 'og:description',
    'content' => 'Phần mềm bất động sản BDSDaily giành riêng cho nhà phố, Giải pháp chuẩn hóa từ quản lý Nhân sự, Quản lý KPI Kinh Doanh, Quản lý sản phẩm giỏ hàng, trang bị công cụ tiện ích bản đồ quy hoạch, marketing ...  tối ưu cho mô hình kinh doanh bất động sản nhà phố'
]);

$this->registerMetaTag([
    'property' => 'og:title',
    'content' => 'Phần Mềm Nhà Phố - BDSDaily'
]);

$this->registerMetaTag([
    'property' => 'og:site_name',
    'content' => 'Phần Mềm Nhà Phố - BDSDaily'
]);

$this->registerMetaTag([
    'property' => 'og:image',
    'content' => 'https://bdsdaily.com/img/logo.webp'
]);

$this->registerMetaTag([
    'property' => 'og:url',
    'content' => 'https://bdsdaily.com/'
]);
?>


<?= $this->render('_feed') ?>

<?= $this->render('_intro') ?>

<!-- Our Data Section -->
<section id="du-lieu" class="py-20 bg-gray-50">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Dữ Liệu Đột Phá, Quyết Định Chính Xác</h2>
        <p class="text-lg text-gray-600 max-w-4xl mx-auto mb-12">
            Chúng tôi sở hữu kho dữ liệu bất động sản nhà phố lớn nhất, được cập nhật và phân tích liên tục, giúp
            bạn có cái nhìn toàn diện và sâu sắc về thị trường.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-indigo-600">
                <div class="text-5xl font-bold text-indigo-600 mb-2">200K+</div>
                <h3 class="text-xl font-semibold mb-2">Dữ liệu nhà phố</h3>
                <p class="text-gray-600">Tập trung vào các khu vực trọng điểm: TP.HCM, Vũng Tàu, Bình Dương.</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-teal-500">
                <div class="text-5xl font-bold text-teal-500 mb-2">3 Khu Vực</div>
                <h3 class="text-xl font-semibold mb-2">Phủ sóng rộng</h3>
                <p class="text-gray-600">Đa dạng về vị trí, giá cả và loại hình bất động sản.</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-yellow-500">
                <div class="text-5xl font-bold text-yellow-500 mb-2">Phân Tích</div>
                <h3 class="text-xl font-semibold mb-2">Báo cáo chuyên sâu</h3>
                <p class="text-gray-600">Cung cấp các báo cáo xu hướng, biến động giá và tiềm năng đầu tư.</p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section id="dich-vu" class="py-20">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Các Dịch Vụ Giá Trị Gia Tăng</h2>
        <p class="text-lg text-gray-600 max-w-4xl mx-auto mb-12">
            Chúng tôi không chỉ cung cấp dữ liệu, mà còn là đối tác chiến lược giúp doanh nghiệp bạn thành công.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <svg class="w-12 h-12 mx-auto text-indigo-600 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6m-6 0v-6a2 2 0 012-2h2a2 2 0 012 2v6m0 0V9a2 2 0 00-2-2h-2a2 2 0 00-2 2v10M9 21h6">
                    </path>
                </svg>
                <h4 class="text-lg font-bold mb-2">Phân Tích Thị Trường</h4>
                <p class="text-sm text-gray-600">Báo cáo chuyên sâu về giá, xu hướng và tiềm năng từng khu vực.</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <svg class="w-12 h-12 mx-auto text-indigo-600 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-2.485 0-4.5 2.015-4.5 4.5S9.515 17 12 17s4.5-2.015 4.5-4.5S14.485 8 12 8z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15M4.5 12h15">
                    </path>
                </svg>
                <h4 class="text-lg font-bold mb-2">Tích Hợp API</h4>
                <p class="text-sm text-gray-600">Tích hợp dữ liệu của chúng tôi trực tiếp vào hệ thống của bạn.</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <svg class="w-12 h-12 mx-auto text-indigo-600 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.485 9.49 5 8 5c-3.141 0-4.5 3.003-4.5 4.5S4.859 14 8 14c1.49 0 2.832-.485 4-1.253M12 6.253c1.168-.768 2.51-1.253 4-1.253 3.141 0 4.5 3.003 4.5 4.5S19.141 14 16 14c-1.49 0-2.832-.485-4-1.253m0-6.747v13">
                    </path>
                </svg>
                <h4 class="text-lg font-bold mb-2">Đào Tạo & Tư Vấn</h4>
                <p class="text-sm text-gray-600">Đào tạo nhân sự và tư vấn chiến lược dựa trên dữ liệu.</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <svg class="w-12 h-12 mx-auto text-indigo-600 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c1.657 0 3-1.343 3-3s-1.343-3-3-3S9 3.343 9 5s1.343 3 3 3z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 14c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 21c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"></path>
                </svg>
                <h4 class="text-lg font-bold mb-2">Báo Cáo Tùy Chỉnh</h4>
                <p class="text-sm text-gray-600">Tạo báo cáo theo yêu cầu riêng biệt của doanh nghiệp bạn.</p>
            </div>
        </div>
    </div>
</section>


<!-- Pricing Packages Section -->
<section id="goi-dich-vu" class="py-20 bg-gray-50">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Các Gói Dịch Vụ Của Chúng Tôi</h2>
        <p class="text-lg text-gray-600 max-w-4xl mx-auto mb-12">
            Lựa chọn giải pháp phù hợp nhất với nhu cầu cá nhân hoặc doanh nghiệp của bạn.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mx-auto">
            <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-indigo-600 scale-105 transform">
                <h3 class="text-2xl font-bold mb-2 text-indigo-600">Gói Miễn Phí</h3>
                <p class="text-4xl font-bold text-indigo-600 mb-4">0 Đồng <span class="text-base font-normal">/tháng</span></p>
                <ul class="text-left text-gray-600 space-y-2 mb-6">
                    <li>
                        ✔️ <a href="https://www.facebook.com/groups/753117670978352" target="_blank" rel="noopener noreferrer">
                            Đăng Bài Miễn Phí Trên Nhóm Facebook "<b>BẤT ĐỘNG SẢN TP.HCM</b>"
                            </a>
                    </li>
                    <li>
                    ✔️ <a href="https://zalo.me/g/ktfwjs927" target="_blank" rel="noopener noreferrer">
                        Nhận tin 5 tin/ngày qua Zalo Group "<b>BDSDaily</b>" 
                        </a>
                    </li>
                    <li>✔️ Nhận tin tức cập nhật miễn phí từ Website</li>
                    <li>
                    ✔️ <a href="https://www.youtube.com/@bdsdaily247" target="_blank" rel="noopener noreferrer">
                        Nhận tin tức cập nhật miễn phí từ "<b>Youtube BDSDaily</b>" 
                        </a>
                    </li>
                    <li>✔️ Nhận hỗ trợ check quy hoạch miễn phí </li>
                    <li>✔️ Tư vấn thiết kế APP - Website BDS miễn phí</li>
                    <li>✔️ Tư vấn SEO Miễn Phí</li>
                    <li>✔️ Tư Vấn Tên miền - Hosting - Email Miễn Phí</li>
                    <li>✔️ Báo cáo phân tích thị trường cơ bản</li>
                    <li>✔️ Hỗ trợ kỹ thuật 24/7</li>
                    <li>✔️ Bảo Hành Trọn Đời</li>
                </ul>
                <a href="https://zalo.me/0845528145" class="inline-block w-full bg-indigo-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-indigo-700 transition-colors duration-300">
                    Đăng Ký Gói Cơ Bản
                </a>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-teal-600 scale-105 transform">
                <h3 class="text-2xl font-bold mb-2 text-indigo-600">Gói Cơ Bản (Dành cho Member)</h3>
                <p class="text-4xl font-bold text-indigo-600 mb-4">500.000 VNĐ <span class="text-base font-normal">/tháng</span></p>
                <ul class="text-left text-gray-600 space-y-2 mb-6">
                    <li>✔️ Truy cập dữ liệu nhà phố đầy đủ (200K+)</li>
                    <li>✔️ Cập nhật tin tức thị trường hàng ngày</li>
                    <li>
                    ✔️ <a href="https://zalo.me/g/ktfwjs927" target="_blank" rel="noopener noreferrer">
                        Nhận tin qua Zalo Group "<b>BDSDaily</b>" Không Giới Hạn
                        </a>
                    </li>
                    <li>✔️ Dữ liệu được xác thực liên tục </li>
                    <li>✔️ Sử dụng hệ thống giỏ hàng</li>
                    <li>✔️ Hỗ trợ Xem Số Chủ Nhà 500 số/ ngày</li>
                    <li>✔️ Hỗ trợ Phần Mềm Trên Cài Trên Máy Tính</li>
                    <li>✔️ Hỗ trợ bản đồ quy hoạch Tp.HCM</li>
                    <li>✔️ Hỗ trợ dự toán khoản vay</li>
                    <li>✔️ Xem lịch âm dương</li>
                    <li>✔️ Hỗ trợ bản đồ quy hoạch Tp.HCM</li>
                    <li>✔️ Hỗ trợ App mobile</li>
                    <li>✔️ Báo cáo phân tích thị trường nâng cao</li>
                    <li>✔️ Hỗ trợ kỹ thuật 24/7</li>
                    <li>✔️ Hỗ trợ sài thử 7 ngày</li>
                    <li>✔️ Bảo Hành Trọn Đời</li>
                </ul>
                <a href="https://zalo.me/0845528145" class="inline-block w-full bg-indigo-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-indigo-700 transition-colors duration-300">
                    Đăng Ký Gói Cơ Bản
                </a>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-yellow-500 scale-105 transform">
                <h3 class="text-2xl font-bold mb-2 text-gray-800">Gói Cài Đặt Full (Doanh Nghiệp)</h3>
                <p class="text-4xl font-bold text-gray-800 mb-4">Liên Hệ <span class="text-base font-normal">để báo giá</span></p>
                <ul class="text-left text-gray-600 space-y-2 mb-6">
                    <li>✔️ Build Website, App Mobile, CRM, Dashboard</li>
                    <li>✔️ Tích hợp toàn bộ 200K+ dữ liệu nhà phố </li>
                    <li>✔️ Dữ liệu được xác thực liên tục </li>
                    <li>✔️ Setup Xem Số Chủ Nhà theo doanh nghiệp</li>
                    <li>✔️ Hỗ trợ bản đồ quy hoạch Tp.HCM</li>
                    <li>✔️ Hỗ trợ App mobile Doanh Nghiệp</li>
                    <li>✔️ Hệ thống tự động gửi tin qua Zalo Group B2B</li>
                    <li>✔️ Giải pháp định vị và quản lý nhân viên</li>
                    <li>✔️ Tích hợp AI phân tích dữ liệu chuyên sâu</li>
                    <li>✔️ Đào tạo và tư vấn chiến lược độc quyền</li>
                    <li>✔️ Hỗ trợ tích hợp Email Marketing</li>
                    <li>✔️ Hỗ trợ tích hợp ZALO Marketing</li>
                    <li>✔️ Hỗ trợ Viết Bài SEO Website Bằng AI</li>
                    <li>✔️ Hỗ trợ ưu tiên 24/7 và bảo trì hệ thống</li>
                    <li>✔️ Bảo Hành Trọn Đời</li>
                </ul>
                <a href="https://zalo.me/0845528145" class="inline-block w-full bg-teal-500 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-teal-600 transition-colors duration-300">
                    Yêu Cầu Tư Vấn
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Mobile App Section -->
<section id="app-mobile" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="md:flex md:items-center md:space-x-12">
            <div class="md:w-1/2">
                <img src="/img/slider1.webp"
                    alt="BDSDaily Mobile App" class="rounded-xl shadow-lg mb-8 md:mb-0">
            </div>
            <div class="md:w-1/2 text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Ứng Dụng Di Động BDSDaily</h2>
                <p class="text-lg text-gray-600 max-w-xl mx-auto md:mx-0 mb-8">
                    Truy cập kho dữ liệu khổng lồ của chúng tôi mọi lúc, mọi nơi ngay trên chiếc điện thoại của bạn.
                    Cập nhật thông tin thị trường, quản lý danh sách sản phẩm và kết nối với đối tác dễ dàng hơn bao
                    giờ hết.
                </p>
                <div class="flex justify-center space-x-4 mx-auto px-6 text-center">
                    <a href="javascript:void(0);"
                        onclick="alert('Vui lòng đăng ký gói Member để được sài ứng dụng!')"
                        class="inline-block bg-indigo-600 text-white font-bold py-3 px-6 rounded-full text-lg shadow-lg hover:bg-indigo-700 transition-colors duration-300">
                        Tải Về Cho iOS
                    </a>
                    <a href="https://play.google.com/store/apps/details?id=com.bdsdaily"
                        class="inline-block bg-gray-800 text-white font-bold py-3 px-6 rounded-full text-lg shadow-lg hover:bg-gray-700 transition-colors duration-300">
                        Tải Về Cho Android
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Zalo B2B Section -->
<section id="zalo" class="py-20">
    <div class="container mx-auto px-6">
        <div class="md:flex md:items-center md:space-x-12">
            <div class="md:w-1/2 text-center md:text-left order-2 md:order-1 mb-2">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Hệ Thống Gửi Tin Tự Động qua Zalo</h2>
                <p class="text-lg text-gray-600 max-w-xl mx-auto md:mx-0 mb-8">
                    Tự động cập nhật các tin rao nhà phố mới nhất đến nhóm Zalo của bạn. Hệ thống của chúng tôi sẽ
                    giúp bạn và đối tác luôn nắm bắt được các cơ hội đầu tư một cách nhanh chóng và kịp thời.
                </p>
                <a href="https://zalo.me/g/ktfwjs927"
                    class="inline-block bg-green-500 text-white font-bold py-3 px-8 rounded-full text-lg shadow-lg hover:bg-green-600 transition-colors duration-300">
                    Đăng Ký Nhận Tin
                </a>
            </div>
            <div class="md:w-1/2 order-1 md:order-2">
                <!-- Placeholder for Zalo icon/image -->
                <img src="/img/slider4.webp"
                    alt="Zalo B2B Integration" class="rounded-xl shadow-lg mb-8 md:mb-0">
            </div>
        </div>
    </div>
</section>
<section id="document" class="py-20">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Mẫu Hợp Đồng Mua Bán, Cọc, Cho Thuê ...</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <svg class="w-12 h-12 mx-auto text-indigo-600 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6m-6 0v-6a2 2 0 012-2h2a2 2 0 012 2v6m0 0V9a2 2 0 00-2-2h-2a2 2 0 00-2 2v10M9 21h6">
                    </path>
                </svg>
                <h4 class="text-lg font-bold mb-2">MẪU HỢP ĐỒNG ĐẶT CỌC BDS</h4>
                <p class="text-sm text-gray-600">Linh động điền thông tin, được thiết kế phù hợp với nhiều phát sinh trong lúc đặt cọc mua bán</p>
                <a href="https://bdsdaily.com/pdf/Hop-dong-dat-coc-mua-nha_3108085012.pdf" class="inline-block bg-green-500 text-white font-bold py-3 px-8 rounded-full text-lg shadow-lg hover:bg-green-600 transition-colors duration-300">
                    Tải Về
                </a>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <svg class="w-12 h-12 mx-auto text-indigo-600 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-2.485 0-4.5 2.015-4.5 4.5S9.515 17 12 17s4.5-2.015 4.5-4.5S14.485 8 12 8z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15M4.5 12h15">
                    </path>
                </svg>
                <h4 class="text-lg font-bold mb-2">MẪU HỢP ĐỒNG MUA BÁN BDS</h4>
                <p class="text-sm text-gray-600">Linh động điền thông tin, được thiết kế phù hợp với nhiều phát sinh trong lúc đặt cọc mua bán</p>
                <a href="https://bdsdaily.com/pdf/Hop-dong-mua-ban-nha-dat_3005191758.pdf" class="inline-block bg-green-500 text-white font-bold py-3 px-8 rounded-full text-lg shadow-lg hover:bg-green-600 transition-colors duration-300">
                    Tải Về
                </a>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <svg class="w-12 h-12 mx-auto text-indigo-600 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.485 9.49 5 8 5c-3.141 0-4.5 3.003-4.5 4.5S4.859 14 8 14c1.49 0 2.832-.485 4-1.253M12 6.253c1.168-.768 2.51-1.253 4-1.253 3.141 0 4.5 3.003 4.5 4.5S19.141 14 16 14c-1.49 0-2.832-.485-4-1.253m0-6.747v13">
                    </path>
                </svg>
                <h4 class="text-lg font-bold mb-2">MẪU HỢP ĐỒNG THUÊ NHÀ</h4>
                <p class="text-sm text-gray-600">Giúp tiết kiệm thời gian, được thiết kế phù hợp với nhiều phát sinh trong lúc đặt cọc cho thuê nhà</p>
                <a href="https://bdsdaily.com/pdf/hop-dong-thue-nha.pdf" class="inline-block bg-green-500 text-white font-bold py-3 px-8 rounded-full text-lg shadow-lg hover:bg-green-600 transition-colors duration-300">
                    Tải Về
                </a>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <svg class="w-12 h-12 mx-auto text-indigo-600 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c1.657 0 3-1.343 3-3s-1.343-3-3-3S9 3.343 9 5s1.343 3 3 3z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 14c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 21c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"></path>
                </svg>
                <h4 class="text-lg font-bold mb-2">MẪU HỢP ĐỒNG GÓP VỐN MUA ĐẤT </h4>
                <p class="text-sm text-gray-600">Giúp tiết kiệm thời gian, được thiết kế phù hợp với nhiều phát sinh trong lúc góp vốn mua đất </p>
                <a href="https://bdsdaily.com/pdf/mau-hop-dong-gop-von-mua-dat.pdf" class="inline-block bg-green-500 text-white font-bold py-3 px-8 rounded-full text-lg shadow-lg hover:bg-green-600 transition-colors duration-300">
                    Tải Về
                </a>
            </div>
        </div>
    </div>

</section>

<section id="khach-hang" class="py-20 bg-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Khách Hàng Nói Về Chúng Tôi</h2>
        <p class="text-lg text-gray-600 max-w-4xl mx-auto mb-12">
            Sự hài lòng của đối tác là thước đo thành công lớn nhất của chúng tôi.
        </p>
        <div class="relative w-full overflow-hidden">
            <div id="testimonials-slider" class="flex transition-transform duration-700 ease-in-out">
                <!-- Testimonial Item 1 -->
                <div class="flex-shrink-0 w-full md:w-1/2 p-4 testimonial-item">
                    <div class="bg-gray-50 p-8 rounded-xl shadow-md flex flex-col items-center text-center">
                        <img src="img/avatar/Samland.jpg" alt="Avatar Nguyễn Văn A" class="w-20 h-20 rounded-full mb-4 object-cover">
                        <p class="italic text-gray-600 mb-4">"Dữ liệu của BDSDaily đã giúp chúng tôi định hướng chiến lược
                            đầu tư một cách hiệu quả hơn bao giờ hết. Thông tin chính xác và kịp thời là chìa khóa thành
                            công."</p>
                        <div class="font-semibold text-gray-800">- Ông Tứ Land, Sàn giao dịch Bất động sản Tứ Land</div>
                    </div>
                </div>
                <!-- Testimonial Item 2 -->
                <div class="flex-shrink-0 w-full md:w-1/2 p-4 testimonial-item">
                    <div class="bg-gray-50 p-8 rounded-xl shadow-md flex flex-col items-center text-center">
                        <img src="img/avatar/thanhthuy.jpg" alt="Avatar Nguyễn Thị Thanh Thúy" class="w-20 h-20 rounded-full mb-4 object-cover">
                        <p class="italic text-gray-600 mb-4">"Chúng tôi đã tích hợp API của BDSDaily vào hệ thống của mình
                            và nhận thấy hiệu suất làm việc của đội ngũ môi giới tăng lên đáng kể. Một dịch vụ tuyệt vời!"
                        </p>
                        <div class="font-semibold text-gray-800">- Bà Nguyễn Thị Thanh Thúy, Công ty CP Đầu tư Địa ốc Bến Thành</div>
                    </div>
                </div>
                <!-- Testimonial Item 3 -->
                <div class="flex-shrink-0 w-full md:w-1/2 p-4 testimonial-item">
                    <div class="bg-gray-50 p-8 rounded-xl shadow-md flex flex-col items-center text-center">
                        <img src="/img/avatar/tienphat.jpg" alt="Avatar Khách hàng C" class="w-20 h-20 rounded-full mb-4 object-cover">
                        <p class="italic text-gray-600 mb-4">"BDSDaily đã thay đổi cách chúng tôi tiếp cận thị trường. Các báo cáo chuyên sâu giúp chúng tôi đưa ra quyết định đầu tư thông minh và nhanh chóng."</p>
                        <div class="font-semibold text-gray-800">- Ông Tiến Phát, Chuyên gia Đầu tư</div>
                    </div>
                </div>
                <!-- Testimonial Item 4 -->
                <div class="flex-shrink-0 w-full md:w-1/2 p-4 testimonial-item">
                    <div class="bg-gray-50 p-8 rounded-xl shadow-md flex flex-col items-center text-center">
                        <img src="/img/avatar/Kieunguen.jpg" alt="Avatar Khách hàng D" class="w-20 h-20 rounded-full mb-4 object-cover">
                        <p class="italic text-gray-600 mb-4">"Dịch vụ hỗ trợ khách hàng của BDSDaily rất tuyệt vời. Mọi thắc mắc đều được giải đáp nhanh chóng và chuyên nghiệp, giúp chúng tôi yên tâm phát triển kinh doanh."</p>
                        <div class="font-semibold text-gray-800">- Bà Kiều Ngân, Trưởng phòng Kinh doanh</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slider Navigation Buttons -->
        <div class="flex justify-center mt-8 space-x-4">
            <button class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700 transition-colors duration-300" onclick="changeTestimonialSlide(-1)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700 transition-colors duration-300" onclick="changeTestimonialSlide(1)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section id="lien-he" class="bg-indigo-600 py-20">
    <div class="container mx-auto px-6 text-center text-white">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Sẵn Sàng Nâng Tầm Doanh Nghiệp Bạn?</h2>
        <p class="text-lg max-w-2xl mx-auto mb-8">
            Hãy liên hệ với chúng tôi ngay hôm nay để nhận tư vấn miễn phí và khám phá sức mạnh của dữ liệu bất động
            sản.
        </p>
        <a href="mailto:bdsdaily247@gmail.com"
            class="inline-block bg-white text-indigo-600 font-bold py-3 px-8 rounded-full text-lg shadow-lg hover:bg-gray-100 transition-colors duration-300">
            Liên Hệ Ngay
        </a>
    </div>
</section>

<section id="phan-mem-nha-pho" class="py-20 bg-gradient-to-b from-white to-gray-50 overflow-hidden">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Tiêu đề -->
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                Phần Mềm Quản Lý Nhà Phố 
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">
                    Theo Từng Khu Vực
                </span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Giải pháp tối ưu riêng cho từng tỉnh thành – giúp bạn <strong class="text-blue-600">bán hàng nhanh gấp 3 lần</strong>.
            </p>
        </div>

        <!-- Grid các tỉnh thành + Icon -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <?php
            $areas = [
                ['name' => 'TP. Hồ Chí Minh',   'sub' => 'Quận 1 • Quận 7 • Bình Thạnh', 'slug' => 'ho-chi-minh',   'icon' => 'M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z'], // Landmark 81 / trái tim Sài Gòn
                ['name' => 'Bình Dương',        'sub' => 'Thủ Dầu Một • Dĩ An • Thuận An', 'slug' => 'binh-duong',    'icon' => 'M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm12 8h2v-6h-2v6zm-4-6h2V9h-2v14z'], // Nhà máy công nghiệp
                ['name' => 'Đồng Nai',          'sub' => 'Biên Hòa • Long Thành • Nhơn Trạch', 'slug' => 'dong-nai',      'icon' => 'M4 4h16v12H5.17L4 17.17V4zm4 10h8v-2H8v2zm0-4h8V8H8v2z'], // Cảng + container
                ['name' => 'Hà Nội',            'sub' => 'Cầu Giấy • Nam Từ Liêm • Gia Lâm', 'slug' => 'ha-noi',        'icon' => 'M12 2L2 22h20L12 2zm0 4.5L17.5 18H6.5L12 6.5z'], // Hồ Gươm + tháp Rùa
                ['name' => 'Đà Nẵng',           'sub' => 'Hải Châu • Sơn Trà • Ngũ Hành Sơn', 'slug' => 'da-nang',       'icon' => 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z'], // Cầu Rồng + cầu Vàng
                ['name' => 'Nha Trang',         'sub' => 'Vinpearl • Cam Ranh • Nha Trang', 'slug' => 'nha-trang',     'icon' => 'M12 21s-8-4.5-8-11.8c0-4.4 3.6-8 8-8s8 3.6 8 8c0 7.3-8 11.8-8 11.8z'], // Biển + đảo
                ['name' => 'Vũng Tàu',          'sub' => 'Bà Rịa - Vũng Tàu • Long Hải', 'slug' => 'vung-tau',      'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z M12 6l-4 8h8l-4-8z'], // Tượng Chúa Kitô + biển
                ['name' => 'Hải Phòng',         'sub' => 'Thủy Nguyên • Hải An • Đồ Sơn', 'slug' => 'hai-phong',     'icon' => 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z'], // Cảng biển
                ['name' => 'Cần Thơ',           'sub' => 'Ninh Kiều • Cái Răng • Phong Điền', 'slug' => 'can-tho',       'icon' => 'M12 2C6.48 2 2 5.58 2 10c0 4.42 5.48 10.86 10 14.98C16.52 20.86 22 14.42 22 10c0-4.42-3.58-8-10-8z'], // Chợ nổi Cái Răng
                ['name' => 'Đà Lạt',            'sub' => 'Lâm Đồng • Bảo Lộc • Đức Trọng', 'slug' => 'da-lat',        'icon' => 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7-7z M12 11.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z'], // Hồ Xuân Hương + thông reo
                ['name' => 'Huế',               'sub' => 'Thừa Thiên Huế • Kinh thành', 'slug' => 'hue',           'icon' => 'M12 2L2 12h3v8h14v-8h3L12 2zm0 3.5l7 6.3V18h-4v-4H9v4H5v-6.2L12 5.5z'], // Kinh thành Huế
                ['name' => 'Thủ Dầu Một',       'sub' => 'Trung tâm Bình Dương', 'slug' => 'thu-dau-mot',    'icon' => 'M12 2a10 10 0 00-10 10c0 6 10 12 10 12s10-6 10-12a10 10 0 00-10-10z M12 15c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z'], // Thành phố mới Bình Dương
            ];
            ?>

            <?php foreach ($areas as $area): ?>
            <a href="/phan-mem-nha-pho-<?= $area['slug']; ?>.html"
               class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-gray-100
                      overflow-hidden transform hover:-translate-y-3 transition-all duration-500
                      flex flex-col items-center justify-center h-44 p-6 text-center">

                <!-- Gradient overlay + hiệu ứng -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-cyan-500/10 
                                opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                <!-- Icon SVG riêng cho từng tỉnh -->
                <div class="relative z-10 mb-4">
                    <svg class="w-14 h-14 text-blue-600 drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                        <path d="<?= $area['icon']; ?>"/>
                    </svg>
                </div>

                <h3 class="font-extrabold text-lg text-gray-800 group-hover:text-blue-700 transition">
                    <?= $area['name']; ?>
                </h3>
                <p class="text-xs text-gray-500 mt-2 leading-tight px-2">
                    <?= $area['sub']; ?>
                </p>

                <!-- Mũi tên nhỏ khi hover -->
                <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 
                            transform translate-y-3 group-hover:translate-y-0 transition-all duration-500">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- CTA cuối -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-blue-600 to-cyan-500 rounded-3xl p-10 md:p-12 
                          text-white shadow-2xl max-w-5xl mx-auto">
                <p class="text-xl md:text-2xl font-bold">
                    Đang mở rộng thêm <span class="text-4xl">34 tỉnh/thành</span> trên toàn quốc
                </p>
                <p class="mt-4 text-blue-100 text-lg">
                    Liên hệ ngay để nhận <strong>bản demo miễn phí</strong> được tùy chỉnh riêng cho khu vực bạn đang hoạt động!
                </p>
                <a href="#lien-he" class="inline-flex items-center mt-8 px-10 py-5 bg-white text-blue-600 
                       font-bold text-lg rounded-2xl hover:bg-gray-100 shadow-xl transform hover:scale-105 
                       transition duration-300">
                    Yêu Cầu Demo Ngay Gọi: 0845 528 145
                    <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- About Us & Contact Section -->
<section id="lien-he" class="bg-indigo-600 py-20">
    <div class="container mx-auto px-6 text-center text-white">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Về Chúng Tôi & Liên Hệ</h2>
        <p class="text-lg max-w-2xl mx-auto mb-8">
            BDSDaily là nền tảng hàng đầu cung cấp giải pháp dữ liệu bất động sản toàn diện, giúp các nhà đầu tư và doanh nghiệp đưa ra quyết định sáng suốt. Chúng tôi cam kết mang đến những thông tin chính xác, kịp thời và những công nghệ đột phá để tối ưu hóa hiệu quả kinh doanh của bạn.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left mt-12 max-w-4xl mx-auto">
            <!-- Address -->
            <div class="flex items-center space-x-4">
                <svg class="w-8 h-8 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-xl font-bold">Địa Chỉ</h3>
                    <p class="text-sm">Tòa nhà BCONS POLYGON Tower, 15 Bế Văn Đàn, An Bình, Dĩ An, Tp.HCM</p>
                </div>
            </div>
            <!-- Email -->
            <div class="flex items-center space-x-4">
                <svg class="w-8 h-8 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </svg>
                <div>
                    <h3 class="text-xl font-bold">Email</h3>
                    <p class="text-sm">bdsdaily247@gmail.com</p>
                </div>
            </div>
            <!-- Phone -->
            <div class="flex items-center space-x-4">
                <svg class="w-8 h-8 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.774a11.058 11.058 0 007.862 7.862l.774-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.163 18 3 13.837 3 8V6a1 1 0 011-1z"></path>
                </svg>
                <div>
                    <h3 class="text-xl font-bold">Số Điện Thoại</h3>
                    <p class="text-sm">0845 528 145</p>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
        // Hero Slider logic
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slider-slide');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach(slide => {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0');
            });
            slides[index].classList.add('opacity-100');
            slides[index].classList.remove('opacity-0');
        }

        function changeSlide(direction) {
            currentSlide += direction;
            if (currentSlide >= totalSlides) {
                currentSlide = 0;
            } else if (currentSlide < 0) {
                currentSlide = totalSlides - 1;
            }
            showSlide(currentSlide);
        }
        
        setInterval(() => {
            changeSlide(1);
        }, 5000);

        // Dashboard Tab logic
        function switchTab(tabId) {
            document.querySelectorAll('.dashboard-tab-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(tabId).classList.add('active');

            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('bg-indigo-600', 'text-white');
                button.classList.add('text-gray-600', 'hover:bg-gray-200');
            });
            event.currentTarget.classList.add('bg-indigo-600', 'text-white');
            event.currentTarget.classList.remove('text-gray-600', 'hover:bg-gray-200');
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            const firstTabButton = document.querySelector('.tab-button');
            if (firstTabButton) {
                firstTabButton.classList.add('bg-indigo-600', 'text-white');
                firstTabButton.classList.remove('text-gray-600', 'hover:bg-gray-200');
            }
        });

        // Testimonials Slider logic (Đã được cập nhật để hoạt động trên mobile)
        let currentTestimonialIndex = 0;
        const testimonialsSlider = document.getElementById('testimonials-slider');
        const testimonialItems = document.querySelectorAll('#testimonials-slider .testimonial-item');
        const totalTestimonialItems = testimonialItems.length;
        
        function updateTestimonialSlider() {
            const itemsPerScreen = window.innerWidth >= 768 ? 2 : 1;
            const totalSlides = Math.ceil(totalTestimonialItems / itemsPerScreen);
            const slideWidth = testimonialsSlider.parentElement.offsetWidth;

            if (currentTestimonialIndex >= totalSlides) {
                currentTestimonialIndex = 0;
            } else if (currentTestimonialIndex < 0) {
                currentTestimonialIndex = totalSlides - 1;
            }
            
            testimonialsSlider.style.transform = `translateX(-${currentTestimonialIndex * slideWidth}px)`;
        }

        function changeTestimonialSlide(direction) {
            currentTestimonialIndex += direction;
            updateTestimonialSlider();
        }

        // Tự động chuyển slider sau mỗi 7 giây
        setInterval(() => {
            changeTestimonialSlide(1);
        }, 7000);

        // Cập nhật slider khi thay đổi kích thước màn hình
        window.addEventListener('resize', updateTestimonialSlider);

        // Chạy lần đầu khi trang được tải
        document.addEventListener('DOMContentLoaded', updateTestimonialSlider);
    </script>