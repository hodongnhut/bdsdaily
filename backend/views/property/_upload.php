<?php
use yii\helpers\Html;

\yii\web\YiiAsset::register($this);
$baseUrl = 'https://kinglandgroup.vn';
?>

<div id="so-hong-content" class="tab-content bg-white p-6 rounded-lg shadow-md mt-1">
    <h3 class="text-md font-semibold text-gray-800 mb-3">Hình ảnh đã tải lên</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center mb-4">
                <div class="bg-purple-600 text-white p-2 rounded-md mr-3 flex-shrink-0">
                    <i class="fas fa-file-alt text-lg"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">SỔ HỒNG | GIẤY TỜ PHÁP LÝ</h3>
            </div>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-500 hover:border-blue-400 hover:text-blue-600 cursor-pointer transition duration-200 ease-in-out upload-area" data-type="legal">
                <i class="fas fa-cloud-upload-alt text-4xl mb-2"></i>
                <p>Chọn hoặc kéo thả</p>
                <p class="text-xs">File: pdf, jpg, png, jpeg, webp, heic!</p>
                <input type="file" multiple accept=".pdf,.jpg,.png,.jpeg,.webp,.heic" class="hidden upload-input">
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center mb-4">
                <div class="bg-blue-600 text-white p-2 rounded-md mr-3 flex-shrink-0">
                    <i class="fas fa-images text-lg"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">HÌNH ẢNH BỔ SUNG</h3>
            </div>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-500 hover:border-blue-400 hover:text-blue-600 cursor-pointer transition duration-200 ease-in-out upload-area" data-type="additional">
                <i class="fas fa-cloud-upload-alt text-4xl mb-2"></i>
                <p>Chọn hoặc kéo thả</p>
                <p class="text-xs">File: pdf, jpg, png, jpeg, webp, heic!</p>
                <input type="file" multiple accept=".pdf,.jpg,.png,.jpeg,.webp,.heic" class="hidden upload-input">
            </div>
        </div>
    </div>
    <br>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 uploaded-images">
        <?php
        $images = $model->propertyImages;
        foreach ($images as $image) {
            $imagePath = $image->image_path;
            if (strpos($imagePath, '/') === 0) {
                $imageUrl = $baseUrl . $imagePath;
            } else {
                $imageUrl = $baseUrl . '/' . $imagePath;
            }
            echo "<div class='relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200 image-container' data-image-id='{$image->image_id}'>";
            echo "<img src='" .$imageUrl. "' alt='" . Html::encode($image->image_path) . "' class='object-cover w-full h-full'>";
            if (!Yii::$app->user->isGuest && in_array(Yii::$app->user->identity->jobTitle->role_code, ['manager', 'super_admin'])) {
                echo "<button class='absolute top-2 right-2 text-white bg-red-500 hover:bg-red-600 p-2 rounded-full delete-btn opacity-0 group-hover:opacity-100 transition-opacity duration-200' data-image-id='{$image->image_id}'>";
                echo "<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>";
                echo "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'></path>";
                echo "</svg></button>";
            }
            echo "</div>";
        }
        ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadAreas = document.querySelectorAll('.upload-area');
    const uploadInputs = document.querySelectorAll('.upload-input');
    uploadAreas.forEach(area => {
        area.addEventListener('click', function() {
            this.querySelector('.upload-input').click();
        });

        area.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.add('border-blue-400', 'text-blue-600');
        });

        area.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('border-blue-400', 'text-blue-600');
        });

        area.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('border-blue-400', 'text-blue-600');
            const files = e.dataTransfer.files;
            const type = this.dataset.type;
            uploadFiles(files, type);
        });
    });

    uploadInputs.forEach(input => {
        input.addEventListener('change', function() {
            const files = this.files;
            const type = this.closest('.upload-area').dataset.type;
            uploadFiles(files, type);
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-btn')) {
            const button = e.target.closest('.delete-btn');
            const imageId = button.dataset.imageId;
            if (confirm('Bạn có chắc chắn muốn xóa hình ảnh này?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '<?= Yii::$app->urlManager->createUrl(['property/delete-image']) ?>', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-CSRF-Token', yii.getCsrfToken());
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    document.querySelector(`.image-container[data-image-id="${imageId}"]`).remove();
                                    alert('Xóa hình ảnh thành công.');
                                } else {
                                    alert('Xóa hình ảnh thất bại: ' + response.message);
                                }
                            } catch (e) {
                                alert('Lỗi phân tích phản hồi từ server.');
                            }
                        } else {
                            alert('Lỗi khi xóa hình ảnh. Mã lỗi: ' + xhr.status);
                        }
                    }
                };
                xhr.send('image_id=' + encodeURIComponent(imageId));
            }
        }
    });

    function uploadFiles(files, type) {
        if (files.length === 0) {
            alert('Vui lòng chọn ít nhất một file để tải lên.');
            return;
        }

        const formData = new FormData();
        formData.append('type', type);
        formData.append('property_id', '<?= $model->property_id ?>');
        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= Yii::$app->urlManager->createUrl(['property/upload-image']) ?>', true);
        xhr.setRequestHeader('X-CSRF-Token', yii.getCsrfToken());
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            response.images.forEach(image => {
                                const div = document.createElement('div');
                                div.className = 'relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200 image-container';
                                div.dataset.imageId = image.id;
                                div.innerHTML = `
                                    <img src="${image.url}" alt="${image.name}" class="object-cover w-full h-full">
                                    <button class="absolute top-2 right-2 text-white bg-red-500 hover:bg-red-600 p-2 rounded-full delete-btn opacity-0 group-hover:opacity-100 transition-opacity duration-200" data-image-id="${image.id}">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>`;
                                document.querySelector('.uploaded-images').appendChild(div);
                            });
                            alert('Tải lên hình ảnh thành công.');
                        } else {
                            alert('Tải lên thất bại: ' + response.message);
                        }
                    } catch (e) {
                        alert('Lỗi phân tích phản hồi từ server.');
                    }
                } else {
                    alert('Lỗi khi tải lên hình ảnh. Mã lỗi: ' + xhr.status);
                }
            }
        };
        xhr.send(formData);
    }
});
</script>