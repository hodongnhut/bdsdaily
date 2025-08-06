<?php
use yii\helpers\Html;

$this->title = 'Vị trí nhân viên: ' . Html::encode($model->full_name);

$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCss('
    #map {
        height: 400px;
        width: 100%;
        border-radius: 8px;
    }
    .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px;
        border-radius: 4px;
        border: 1px solid;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        z-index: 1000;
    }
    .custom-alert.show {
        opacity: 1;
    }
');
?>

<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Vị trí nhân viên: <?= Html::encode($model->full_name) ?></div>
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
    <div id="custom-alert-box" class="custom-alert"></div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Vị trí nhân viên: <?= Html::encode($model->full_name) ?></h2>

        <div class="mb-4 text-center">
            <p class="text-lg text-gray-700">
                <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                Vĩ độ: <span id="latitude" class="font-semibold text-blue-600"><?= Html::encode($model->latitude ? number_format($model->latitude, 6) : 'Chưa có dữ liệu') ?></span>
            </p>
            <p class="text-lg text-gray-700 mt-2">
                <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                Kinh độ: <span id="longitude" class="font-semibold text-blue-600"><?= Html::encode($model->longitude ? number_format($model->longitude, 6) : 'Chưa có dữ liệu') ?></span>
            </p>
            <p class="text-lg text-gray-700 mt-2">
                <i class="fas fa-map-pin text-red-500 mr-2"></i>
                Địa chỉ: <span id="address" class="font-semibold text-blue-600">Đang tải địa chỉ...</span>
            </p>
            <p id="location-status" class="text-sm text-gray-500 mt-4"><?= $model->latitude && $model->longitude ? 'Vị trí hiện tại của nhân viên.' : 'Chưa có vị trí được lưu.' ?></p>
        </div>

        <div id="map" class="mt-6"></div>

        <div class="flex justify-center pt-6">
            <a href="<?= \yii\helpers\Url::to(['site/index']) ?>" class="ml-4 px-5 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
            </a>
        </div>
    </div>
</main>

<script>
// Define initMap globally before Google Maps API loads
window.initMap = function () {
    const employeeLocation = {
        lat: <?= $model->latitude ?: 10.762622 ?>,
        lng: <?= $model->longitude ?: 106.660172 ?>
    };
    window.map = new google.maps.Map(document.getElementById('map'), {
        center: employeeLocation,
        zoom: <?= $model->latitude && $model->longitude ? 15 : 12 ?>,
        mapTypeId: 'roadmap'
    });
    window.marker = new google.maps.Marker({
        position: employeeLocation,
        map: window.map,
        title: '<?= Html::encode($model->full_name) ?>'
    });

    // Perform reverse geocoding on page load
    if (employeeLocation.lat !== 10.762622 || employeeLocation.lng !== 106.660172) {
        reverseGeocode(employeeLocation.lat, employeeLocation.lng);
    } else {
        document.getElementById('address').textContent = 'Chưa có dữ liệu địa chỉ';
    }
};

// Reverse geocoding function to get address
function reverseGeocode(lat, lng) {
    const geocoder = new google.maps.Geocoder();
    const latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };
    const addressElement = document.getElementById('address');

    geocoder.geocode({ location: latlng }, (results, status) => {
        if (status === 'OK' && results[0]) {
            addressElement.textContent = results[0].formatted_address;
        } else {
            addressElement.textContent = 'Không thể lấy địa chỉ';
            showCustomAlert('Không thể lấy địa chỉ từ tọa độ.', 'error');
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Update Location Logic
    const refreshButton = document.getElementById('refresh-location');
    const latElement = document.getElementById('latitude');
    const lngElement = document.getElementById('longitude');
    const addressElement = document.getElementById('address');
    const statusElement = document.getElementById('location-status');

    if (refreshButton && latElement && lngElement && addressElement && statusElement) {
        function showCustomAlert(message, type = 'error') {
            const alertBox = document.getElementById('custom-alert-box');
            if (alertBox) {
                alertBox.textContent = message;
                alertBox.className = `custom-alert show ${type === 'success' ? 'bg-green-100 text-green-700 border-green-400' : 'bg-red-100 text-red-700 border-red-400'}`;
                setTimeout(() => {
                    alertBox.classList.remove('show');
                }, 3000);
            }
        }

        refreshButton.addEventListener('click', function () {
            if (!navigator.geolocation) {
                showCustomAlert('Trình duyệt của bạn không hỗ trợ Geolocation API.', 'error');
                statusElement.textContent = 'Trình duyệt không hỗ trợ định vị.';
                return;
            }

            latElement.textContent = 'Đang tải...';
            lngElement.textContent = 'Đang tải...';
            addressElement.textContent = 'Đang tải địa chỉ...';
            statusElement.textContent = 'Đang cố gắng lấy vị trí mới...';

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const userId = refreshButton.getAttribute('data-user-id');

                    fetch('<?= \yii\helpers\Url::to(['site/update-user-location']) ?>?id=' + userId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                        },
                        body: 'latitude=' + userLat + '&longitude=' + userLng
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            latElement.textContent = userLat.toFixed(6);
                            lngElement.textContent = userLng.toFixed(6);
                            statusElement.textContent = 'Vị trí của nhân viên đã được cập nhật.';
                            showCustomAlert('Cập nhật vị trí thành công!', 'success');

                            const newLocation = { lat: userLat, lng: userLng };
                            window.map.setCenter(newLocation);
                            window.marker.setPosition(newLocation);
                            window.map.setZoom(15);

                            // Update address after successful location save
                            reverseGeocode(userLat, userLng);
                        } else {
                            latElement.textContent = '<?= Html::encode($model->latitude ? number_format($model->latitude, 6) : 'Chưa có dữ liệu') ?>';
                            lngElement.textContent = '<?= Html::encode($model->longitude ? number_format($model->longitude, 6) : 'Chưa có dữ liệu') ?>';
                            addressElement.textContent = '<?= $model->latitude && $model->longitude ? 'Đang tải địa chỉ...' : 'Chưa có dữ liệu địa chỉ' ?>';
                            statusElement.textContent = 'Không thể cập nhật vị trí.';
                            showCustomAlert(data.message || 'Không thể cập nhật vị trí. Vui lòng thử lại.', 'error');

                            // Retry reverse geocoding for stored coordinates
                            if (<?= $model->latitude ?: 'null' ?> && <?= $model->longitude ?: 'null' ?>) {
                                reverseGeocode(<?= $model->latitude ?>, <?= $model->longitude ?>);
                            }
                        }
                    })
                    .catch(error => {
                        latElement.textContent = '<?= Html::encode($model->latitude ? number_format($model->latitude, 6) : 'Chưa có dữ liệu') ?>';
                        lngElement.textContent = '<?= Html::encode($model->longitude ? number_format($model->longitude, 6) : 'Chưa có dữ liệu') ?>';
                        addressElement.textContent = '<?= $model->latitude && $model->longitude ? 'Đang tải địa chỉ...' : 'Chưa có dữ liệu địa chỉ' ?>';
                        statusElement.textContent = 'Lỗi khi cập nhật vị trí.';
                        showCustomAlert('Lỗi khi cập nhật vị trí: ' + error.message, 'error');

                        // Retry reverse geocoding for stored coordinates
                        if (<?= $model->latitude ?: 'null' ?> && <?= $model->longitude ?: 'null' ?>) {
                            reverseGeocode(<?= $model->latitude ?>, <?= $model->longitude ?>);
                        }
                    });
                },
                (error) => {
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
                    latElement.textContent = '<?= Html::encode($model->latitude ? number_format($model->latitude, 6) : 'Chưa có dữ liệu') ?>';
                    lngElement.textContent = '<?= Html::encode($model->longitude ? number_format($model->longitude, 6) : 'Chưa có dữ liệu') ?>';
                    addressElement.textContent = '<?= $model->latitude && $model->longitude ? 'Đang tải địa chỉ...' : 'Chưa có dữ liệu địa chỉ' ?>';
                    statusElement.textContent = 'Không thể lấy vị trí mới.';
                    showCustomAlert(errorMessage, 'error');

                    // Retry reverse geocoding for stored coordinates
                    if (<?= $model->latitude ?: 'null' ?> && <?= $model->longitude ?: 'null' ?>) {
                        reverseGeocode(<?= $model->latitude ?>, <?= $model->longitude ?>);
                    }
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        });
    } else {
        console.warn('One or more required elements (refresh-location, latitude, longitude, address, location-status) not found.');
    }

    // Error handling for Google Maps API
    window.onerror = function(message) {
        if (message.includes('google')) {
            showCustomAlert('Không thể tải Google Maps. Vui lòng kiểm tra kết nối mạng hoặc API key.', 'error');
        }
    };
});
</script>

<?php
    $googleMapsApiKey = Yii::$app->params['googleMapsApiKey'];
    $this->registerJsFile("https://maps.googleapis.com/maps/api/js?key={$googleMapsApiKey}&callback=initMap", ['async' => true, 'defer' => true]);
?>