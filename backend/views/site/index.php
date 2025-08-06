<?php
use Yii;
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = 'BDS Daily - Giải Pháp Dữ Liệu Bất Động Sản B2B<';

$role_code = Yii::$app->user->identity->jobTitle->role_code;
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', [
    'position' => \yii\web\View::POS_BEGIN,
]);
$this->registerCssFile(
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
    ['position' => \yii\web\View::POS_BEGIN]
);
?>

<!-- Location Prompt Modal for Non-Manager/Super Admin Roles -->
<?php if (isset($locationRequired) && $locationRequired): ?>
<div id="locationModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Yêu cầu vị trí</h2>
        <p class="text-gray-600 mb-4">Vui lòng bật dịch vụ định vị để sử dụng ứng dụng. Điều này giúp chúng tôi cung cấp dịch vụ phù hợp với vị trí của bạn.</p>
        <div class="flex justify-between">
            <button id="allowLocation" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-md transition-colors duration-200">
                Cho phép định vị
            </button>
            <button id="retryLocation" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md shadow-md transition-colors duration-200 hidden">
                Thử lại
            </button>
        </div>
        <p id="locationError" class="text-red-600 mt-4 hidden"></p>
        <a href="<?= \yii\helpers\Url::to(['site/logout']) ?>" class="text-blue-600 hover:text-blue-900 mt-4 block" data-method="post">Đăng xuất</a>
    </div>
</div>
<?php endif; ?>

<!-- Header -->
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Xem Dữ Liệu Nhà Đất</div>
    <div class="relative flex items-center space-x-4">
        <button
            id="userMenuButton"
            class="w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-md transition-colors duration-200"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <i class="fas fa-user"></i>
        </button>
        <div
            id="userMenu"
            class="absolute right-0 mt-20 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-10 hidden"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="userMenuButton"
        >
            <a href="<?= \yii\helpers\Url::to(['/login-version']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Phiên Đăng Nhập</a>
            <a href="<?= \yii\helpers\Url::to(['/change-password']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đổi Mật Khẩu</a>
            <?= Html::a('Đăng Xuất', ['/site/logout'], [
                'data-method' => 'post',
                'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100',
                'role' => 'menuitem'
            ]) ?>
        </div>
    </div>
</header>

<main class="flex-1 p-6 overflow-auto">

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Top Hoạt Động Trong 7 ngày qua</h2>
        <div class="chart-container" style="position: relative; height: 60vh;">
            <canvas id="activityChart"></canvas>
            <div id="noDataMessage" class="text-center text-gray-600 mt-4 hidden">Không có dữ liệu hoạt động để hiển thị.</div>
        </div>
        <div class="flex flex-wrap justify-center gap-4 mt-6 text-sm text-gray-600">
            <div class="flex items-center"><span class="inline-block w-4 h-4 rounded-full bg-[#6EE7B7] mr-2"></span> Thêm mới</div>
            <div class="flex items-center"><span class="inline-block w-4 h-4 rounded-full bg-[#3B82F6] mr-2"></span> Xem số điện thoại</div>
            <div class="flex items-center"><span class="inline-block w-4 h-4 rounded-full bg-[#F59E0B] mr-2"></span> Bổ sung thông tin nhà</div>
            <div class="flex items-center"><span class="inline-block w-4 h-4 rounded-full bg-[#6B7280] mr-2"></span> Tải File</div>
        </div>
    </div>

    <? if ($role_code === 'manager' ||  $role_code == 'super_admin'):  ?>
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Danh sách nhân viên</h2>
                <a href="/user/create" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md flex items-center transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Thêm nhân viên mới
                </a>
            </div>

            <!-- Search and Filter Section -->
            <div class="mb-6 flex flex-col gap-4">
                <?= Html::beginForm(['site/index'], 'get', ['class' => 'flex flex-col md:flex-row gap-4']) ?>
                    <input type="text" name="UserSearch[full_name]" value="<?= Html::encode($searchModel->full_name) ?>" placeholder="Tìm kiếm theo tên..." class="flex-1 form-input border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                    <select name="UserSearch[job_title_id]" class="form-select border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả chức vụ</option>
                        <option value="1" <?= $searchModel->job_title_id == 1 ? 'selected' : '' ?>>Quản lý</option>
                        <option value="2" <?= $searchModel->job_title_id == 2 ? 'selected' : '' ?>>Nhân viên kinh doanh</option>
                        <option value="3" <?= $searchModel->job_title_id == 3 ? 'selected' : '' ?>>Hỗ trợ kỹ thuật</option>
                        <option value="4" <?= $searchModel->job_title_id == 4 ? 'selected' : '' ?>>Quản trị viên</option>
                        <option value="5" <?= $searchModel->job_title_id == 5 ? 'selected' : '' ?>>Kế toán</option>
                    </select>
                    <select name="UserSearch[status]" class="form-select border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả trạng thái</option>
                        <option value="10" <?= $searchModel->status == 10 ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="9" <?= $searchModel->status == 9 ? 'selected' : '' ?>>Nghỉ việc</option>
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-md">Tìm kiếm</button>
                <?= Html::endForm() ?>
            </div>

            <!-- Staff Table -->
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã nhân viên</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Họ tên</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chức vụ</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($dataProvider->getModels() as $user): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= Html::encode($user->username) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= Html::encode($user->full_name) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= Html::encode($user->email) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= Html::encode($user->jobTitle->title_name ?? 'N/A') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $user->status == 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $user->status == 10 ? 'Hoạt động' : 'Nghỉ việc' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <? if ($role_code != $user->jobTitle->role_code ||  $role_code != $user->jobTitle->role_code):  ?>
                                    <?= Html::a('<i class="fas fa-map"></i> Xem Vị trí', ['user/map', 'id' => $user->id], [
                                        'class' => 'text-blue-600 hover:text-blue-900 mr-3',
                                        'title' => 'Xem Vị trí',
                                        'data-method' => 'get',
                                        'target' => '_blank',
                                    ]) ?>
                                <?php endif; ?>  
                                <?= Html::a('<i class="fas fa-edit"></i>', ['user/update', 'id' => $user->id], [
                                    'class' => 'text-blue-600 hover:text-blue-900 mr-3',
                                    'title' => 'Chỉnh sửa',
                                    'data-method' => 'get'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-trash-alt"></i>', ['user/delete', 'id' => $user->id], [
                                    'class' => 'text-red-600 hover:text-red-900',
                                    'title' => 'Xóa',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Bạn có chắc chắn muốn xóa nhân viên này?'
                                ]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-6 rounded-lg shadow-sm">
                <div class="flex flex-1 justify-between sm:hidden">
                    <a href="<?= $dataProvider->pagination->createUrl($dataProvider->pagination->getPage() - 1) ?>" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 <?= $dataProvider->pagination->getPage() <= 0 ? 'hidden' : '' ?>">Trước</a>
                    <a href="<?= $dataProvider->pagination->createUrl($dataProvider->pagination->getPage() + 1) ?>" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 <?= $dataProvider->pagination->getPage() >= $dataProvider->pagination->getPageCount() - 1 ? 'hidden' : '' ?>">Sau</a>
                </div>
                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Hiển thị <span class="font-medium"><?= ($dataProvider->pagination->getPage() * $dataProvider->pagination->getPageSize()) + 1 ?></span> đến <span class="font-medium"><?= min(($dataProvider->pagination->getPage() + 1) * $dataProvider->pagination->getPageSize(), $dataProvider->getTotalCount()) ?></span> của
                            <span class="font-medium"><?= $dataProvider->getTotalCount() ?></span> kết quả
                        </p>
                    </div>
                    <div>
                        <?= LinkPager::widget([
                            'pagination' => $dataProvider->pagination,
                            'options' => ['class' => 'isolate inline-flex -space-x-px rounded-md shadow-sm'],
                            'linkOptions' => ['class' => 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0'],
                            'activePageCssClass' => 'z-10 bg-blue-600 text-white',
                            'prevPageCssClass' => 'relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0',
                            'nextPageCssClass' => 'relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0',
                            'prevPageLabel' => '<span class="sr-only">Trước</span><i class="fas fa-chevron-left"></i>',
                            'nextPageLabel' => '<span class="sr-only">Sau</span><i class="fas fa-chevron-right"></i>',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</main>

<!-- JavaScript for Dropdown Menu -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('userMenuButton');
        const menu = document.getElementById('userMenu');

        button.addEventListener('click', function (e) {
            e.preventDefault();
            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', !expanded);
            menu.classList.toggle('hidden');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (e) {
            if (!button.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
                button.setAttribute('aria-expanded', 'false');
            }
        });
    });

    // Location Prompt Logic
    const locationModal = document.getElementById('locationModal');
    const allowLocationBtn = document.getElementById('allowLocation');
    const retryLocationBtn = document.getElementById('retryLocation');
    const locationError = document.getElementById('locationError');
    const mainContent = document.querySelector('main');

    if (locationModal && allowLocationBtn && retryLocationBtn && locationError && mainContent) {
        if (!locationModal.classList.contains('hidden')) {
            requestLocation();
        }

        allowLocationBtn.addEventListener('click', requestLocation);
        retryLocationBtn.addEventListener('click', requestLocation);

        function requestLocation() {
            if (!navigator.geolocation) {
                locationError.textContent = 'Trình duyệt của bạn không hỗ trợ định vị.';
                locationError.classList.remove('hidden');
                retryLocationBtn.classList.remove('hidden');
                allowLocationBtn.classList.add('hidden');
                return;
            }

            locationError.classList.add('hidden');
            retryLocationBtn.classList.add('hidden');
            allowLocationBtn.classList.add('hidden');

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Detect device information (basic detection)
                    const deviceType = /Mobi|Android|iPhone/i.test(navigator.userAgent) ? 'Điện thoại' : 'Máy Tính';
                    const os = navigator.platform || 'Unknown';
                    const browser = navigator.userAgent.match(/(Chrome|Firefox|Safari|Edge)/i)?.[1] || 'Unknown';
                    const sessionId = '<?= Yii::$app->session->id ?>'; // Yii2 session ID

                    fetch('<?= \yii\helpers\Url::to(['site/save-location']) ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                        },
                        body: 'latitude=' + latitude + '&longitude=' + longitude +
                              '&device_type=' + encodeURIComponent(deviceType) +
                              '&os=' + encodeURIComponent(os) +
                              '&browser=' + encodeURIComponent(browser) +
                              '&session_id=' + encodeURIComponent(sessionId)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            locationModal.classList.add('hidden');
                            mainContent.classList.remove('hidden');
                            fetch('<?= \yii\helpers\Url::to(['site/clear-location-prompt']) ?>', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                                }
                            }).then(() => {
                                // Optional: Reload only if needed
                                // window.location.reload();
                            });
                        } else {
                            locationError.textContent = data.message || 'Không thể lưu vị trí. Vui lòng thử lại.';
                            locationError.classList.remove('hidden');
                            retryLocationBtn.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        locationError.textContent = 'Lỗi khi lưu vị trí: ' + error.message;
                        locationError.classList.remove('hidden');
                        retryLocationBtn.classList.remove('hidden');
                    });
                },
                function(error) {
                    let errorMessage = 'Vui lòng bật dịch vụ định vị để tiếp tục.';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Bạn đã từ chối chia sẻ vị trí. Vui lòng bật định vị trong cài đặt trình duyệt.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Không thể lấy được vị trí. Vui lòng kiểm tra kết nối mạng.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Yêu cầu vị trí đã hết thời gian. Vui lòng thử lại.';
                            break;
                    }
                    locationError.textContent = errorMessage;
                    locationError.classList.remove('hidden');
                    retryLocationBtn.classList.remove('hidden');
                    allowLocationBtn.classList.add('hidden');
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }
    }

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // Detect device information (basic detection)
            const deviceType = /Mobi|Android|iPhone/i.test(navigator.userAgent) ? 'Điện thoại' : 'Máy Tính';
            const os = navigator.platform || 'Unknown';
            const browser = navigator.userAgent.match(/(Chrome|Firefox|Safari|Edge)/i)?.[1] || 'Unknown';
            const sessionId = '<?= Yii::$app->session->id ?>'; // Yii2 session ID

            fetch('<?= \yii\helpers\Url::to(['site/save-location']) ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                },
                body: 'latitude=' + latitude + '&longitude=' + longitude +
                        '&device_type=' + encodeURIComponent(deviceType) +
                        '&os=' + encodeURIComponent(os) +
                        '&browser=' + encodeURIComponent(browser) +
                        '&session_id=' + encodeURIComponent(sessionId)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    locationModal.classList.add('hidden');
                    mainContent.classList.remove('hidden');
                    fetch('<?= \yii\helpers\Url::to(['site/clear-location-prompt']) ?>', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                        }
                    }).then(() => {
                        // Optional: Reload only if needed
                        // window.location.reload();
                    });
                } else {
                    locationError.textContent = data.message || 'Không thể lưu vị trí. Vui lòng thử lại.';
                    locationError.classList.remove('hidden');
                    retryLocationBtn.classList.remove('hidden');
                }
            })
            .catch(error => {
                locationError.textContent = 'Lỗi khi lưu vị trí: ' + error.message;
                locationError.classList.remove('hidden');
                retryLocationBtn.classList.remove('hidden');
            });
        },
        function(error) {
            let errorMessage = 'Vui lòng bật dịch vụ định vị để tiếp tục.';
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = 'Bạn đã từ chối chia sẻ vị trí. Vui lòng bật định vị trong cài đặt trình duyệt.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = 'Không thể lấy được vị trí. Vui lòng kiểm tra kết nối mạng.';
                    break;
                case error.TIMEOUT:
                    errorMessage = 'Yêu cầu vị trí đã hết thời gian. Vui lòng thử lại.';
                    break;
            }
            locationError.textContent = errorMessage;
            locationError.classList.remove('hidden');
            retryLocationBtn.classList.remove('hidden');
            allowLocationBtn.classList.add('hidden');
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );

    // Chart.js Configuration
    const wrapLabels = (label, maxWidth) => {
        if (label.length <= maxWidth) return label;
        const words = label.split(' ');
        const lines = [];
        let currentLine = '';
        words.forEach(word => {
            if ((currentLine + ' ' + word).length > maxWidth && currentLine !== '') {
                lines.push(currentLine.trim());
                currentLine = word;
            } else {
                currentLine += (currentLine === '' ? '' : ' ') + word;
            }
        });
        lines.push(currentLine.trim());
        return lines;
    };


    const ctx = document.getElementById('activityChart').getContext('2d');
    
    const tooltipTitleCallback = (tooltipItems) => {
        const item = tooltipItems[0];
        let label = item.chart.data.labels[item.dataIndex];
        if (Array.isArray(label)) return label.join(' ');
        return label;
    };

    fetch('<?= \yii\helpers\Url::to(['site/activity-data']) ?>', {
        method: 'GET',
        headers: {
            'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.labels.length === 0) {
            document.getElementById('noDataMessage').classList.remove('hidden');
            return;
        }
        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 14, family: 'Inter, sans-serif' }, padding: 20 } },
                    tooltip: {
                        callbacks: { title: tooltipTitleCallback, label: (context) => `${context.dataset.label}: ${context.raw}` },
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: { size: 16 },
                        bodyFont: { size: 14 },
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: { stacked: true, grid: { display: false }, ticks: { font: { family: 'Inter, sans-serif' } } },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        title: { display: true, text: 'Số lượng hoạt động', font: { size: 14, family: 'Inter, sans-serif' } },
                        ticks: { font: { family: 'Inter, sans-serif' } }
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error('Error fetching chart data:', error);
        document.getElementById('noDataMessage').classList.remove('hidden');
    });
</script>
