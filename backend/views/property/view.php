<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\HtmlLogHelper;

/** @var yii\web\View $this */
/** @var common\models\Properties $model */

$this->title = "Xem Dữ Liệu Nhà Đất [". $model->property_id . "]";
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


$this->registerCssFile('/css/history.css', [
    'rel' => 'stylesheet',
]);

$this->registerCssFile('/css/Property.css', [
    'rel' => 'stylesheet',
]);
function formatPriceUnit($number) {
    if (!is_numeric($number) || $number <= 0) {
        return 'Thỏa thuận';
    }

    $billion = 1000000000;
    $million = 1000000;

    if ($number >= $billion) {
        $result = $number / $billion;
        $formatted_result = rtrim(rtrim(number_format($result, 2, '.', ''), '0'), '.');
        return $formatted_result . ' Tỷ';
    }

    if ($number >= $million) {
        $result = $number / $million;
        $formatted_result = round($result);
        return $formatted_result . ' Triệu';
    }
    
    return number_format($number) . ' VNĐ';
}

function formatNumber($number) {
    if ($number === null) {
        return null;
    }
    if ($number == (int)$number) {
        return (int)$number;
    }
    
    return (float)$number;
}
?>

<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">
        <a href="<?= \yii\helpers\Url::to(['/property']) ?>" class="px-4 py-2 bg-blue-500 text-white rounded-full  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" role="menuitem"><i class="fas fa-home"></i></a>
        <?= Html::a('<i class="fas fa-arrow-left"></i>', Yii::$app->request->referrer ?: ['index'], [
        'class' => 'px-4 py-2 bg-blue-500 text-white rounded-full  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500']) ?>    
        <i class="fas fa-database text-xl"></i> Dữ Liệu Nhà Đất [Mã: <?= $model->property_id ?> - Loại Giao Dịch: <?= $model->listingType->name ?>]
    </div>
    <div class="relative flex items-center space-x-4">
        <div class="flex space-x-2">
        <?= Html::a('<i class="fas fa-pencil-alt"></i> Cập Nhật', Url::to(['/property/update', 'property_id' => $model->property_id]), [
                'class' => 'px-4 py-2 bg-orange-600 text-white rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500'
            ]) ?>
        </div>
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


<main class="flex-1 p-6 overflow-y-auto hide-scrollbar">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-lg shadow-md border-orange-600-custom">


                <div class="bg-white rounded-lg mb-2 flex items-center justify-between">
                    <div>                    
                        <p class="text-sm text-gray-500">Mã BĐS: <span class="font-semibold text-gray-800"><?= Html::encode($model->property_id) ?></span></p>
                        <p class="text-sm text-gray-500">Ngày Nhập: <span class="font-semibold text-gray-800"><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?> (<?= Yii::$app->formatter->asDate($model->created_at, 'php:d-m-Y') ?>)</span></p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div>
                            <p class="text-sm text-gray-500">Người Nhập:</p>
                            <p class="font-semibold text-gray-800"><?= Yii::$app->user->identity->username ?> <i class="fas fa-info-circle text-gray-400 text-xs"></i></p>
                        </div>
                    </div>
                </div>

                <button id="openDialog" class="mb-2 px-3 py-1.5 rounded-lg bg-yellow-600 hover:bg-yellow-700 text-white shadow-md flex items-center space-x-1.5 text-sm transition-colors duration-200">
                    <i class="fas fa-eye fa-sm mr-1"></i>
                    <span>Lịch sử tương tác</span>
                </button>

                <div class="flex-grow border border-red-500 p-4 rounded ">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-lg font-bold text-orange-600"><?= Html::encode($model->listingType->name ?? '') ?></span>
                            <?= Html::tag('div', $model->propertyType->type_name ?? null, [
                                'class' => 'tab-sub-button px-4 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200'
                                ]) 
                            ?>
                            <?php if ($model->transactionStatus && $model->transactionStatus->transaction_status_id !== 0): ?>
                                <span class="px-2 py-1 text-xs font-medium rounded-full <?= Html::encode($model->transactionStatus->class_css) ?>">
                                    <?= Html::encode($model->transactionStatus->status_name) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <p class="text-xl font-bold text-gray-800 mb-2"><?= Html::encode($model->title) ?></p>
                    
                    <?= Html::a(
                            '<i class="fas fa-map mr-1"></i> Xem bản đồ',
                            "https://maps.google.com/?q=".$model->title,
                            [
                                'target' => '_blank',
                                'class' => 'px-4 py-2 text-sm font-medium rounded-full bg-blue-100 text-blue-700',
                                'encode' => false,
                            ]
                        )
                    ?>
                    <?= $model->new_district
                        ? Html::tag('span', $model->new_district, [
                            'class' => 'capitalize px-4 py-2 text-sm font-medium rounded-full bg-green-100 text-green-700'])
                        : '';
                    ?>
                    
                    <div class="grid grid-cols-4 gap-4 mb-4 mt-4">
                        <?php
                            $totalPrice = $model->price; 
                            $totalArea = $model->area_total;
                            $pricePerSqM_Text = '';

                            if ($totalArea > 0 && $totalPrice > 0) {
                                $pricePerSqM_VND = $totalPrice / $totalArea;
                                $pricePerSqM_Text = formatPriceUnit($pricePerSqM_VND);
                            }
                        ?>

                        <div>
                            <p class="text-sm text-gray-500">Mức giá</p>
                            <p class="text-lg font-bold text-gray-800">
                                <?= formatPriceUnit($model->price) ?>
                            </p>
                            <p class="text-xs text-gray-500">
                                ~ <?= $pricePerSqM_Text ?>/m²
                            </p>
                        </div>
                        <? if (!empty($model->final_price) && $model->final_price > 0):  ?>
                            <?php
                            $totalFinalPrice = $model->final_price; 
                            $totalArea = $model->area_total;
                            $pricePerSqM_Text = '';

                            if ($totalArea > 0 && $totalFinalPrice > 0) {
                                $pricePerSqM_VND = $totalFinalPrice / $totalArea;
                                $pricePerSqM_Text = formatPriceUnit($pricePerSqM_VND);
                            }
                            ?>
                            <div>
                                <p class="text-sm text-gray-500">Giá chốt</p>
                                <p class="text-lg font-bold text-gray-800">
                                    <?= formatPriceUnit($model->final_price) ?>
                                </p>
                                <p class="text-xs text-gray-500">
                                    ~ <?= $pricePerSqM_Text ?>/m²
                                </p>
                            </div>
                        <?php endif; ?>
                        <div>
                            <p class="text-sm text-gray-500">Diện tích</p>
                            <p class="text-lg font-bold text-gray-800">
                                <?= formatNumber($model->area_total) ?> m²
                            </p>
                            <p class="text-xs text-gray-500">
                                (<?= formatNumber($model->area_width) ?>m × <?= formatNumber($model->area_length) ?>m)
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Thử Đất Số: </p>
                            <p class="text-lg font-bold text-gray-800">
                                <?= $model->plot_number ?? 'N/A' ?>
                            </p>
                            <? if (empty($model->plot_number)):  ?>
                                <p class="text-xs text-gray-500"> Vui Lòng check Sổ Bên dưới</p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Số Tờ: </p>
                            <p class="text-lg font-bold text-gray-800">
                                <?= $model->sheet_number ?? 'N/A' ?>
                            </p>
                            <? if (empty($model->sheet_number)):  ?>
                                <p class="text-xs text-gray-500"> Vui Lòng check Sổ Bên dưới</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <?php foreach ($model->ownerContacts as $contact): ?>
                            <?php
                            $iconClass = match ($contact->gender_id) {
                                2 => 'fas fa-venus text-pink-500',
                                1 => 'fas fa-mars text-blue-600',
                                default => 'fas fa-user text-gray-500',
                            };
                            $phoneDisplay = $contact->phone_number ? '<i class="fas fa-eye fa-sm mr-1"></i> •••••••' . substr($contact->phone_number, -3) : 'N/A';
                            ?>
                            <div class="flex items-center font-medium contact-entry" data-contact-id="<?= Html::encode($contact->contact_id) ?>">
                                <i class="<?= $iconClass ?> mr-2 w-4 text-center" aria-hidden="true"></i>
                                <span class="text-gray-800 contact-info cursor-pointer hover:text-blue-600" 
                                    title="Nhấp để hiển thị số điện thoại" 
                                    aria-label="Contact <?= Html::encode($contact->contact_name) ?>">
                                    <?= Html::encode($contact->contact_name) ?> 
                                    <span class="phone-display"><?= $phoneDisplay ?></span>
                                    <span class="zalo-link hidden ml-2" title="Chat on Zalo">
                                        <a href="#" class="zalo-anchor" target="_blank">
                                            <img src="/img/zalo.png" alt="Zalo" class="zalo-icon">
                                        </a>
                                    </span>
                                    <span class="error-message text-red-600 text-xs ml-2 hidden"></span>
                                </span>
                                <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                                    <?= Html::encode($contact->role->name ?? 'Chủ nhà') ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="space-y-2  mb-4 mt-4" >
                    <nav class="flex space-x-4 mb-4 ">
                        <button class="tab-sub-button px-4 py-2 text-sm font-medium rounded-full bg-orange-100 text-orange-700" data-target="vi-tri-mat-tien">Vị Trí <?= Html::encode($model->locationTypes->type_name ?? '') ?></button>
                        <?php
                            $assetTypeName = 'chưa có thông tin';
                            if ($model->assetType && $model->assetType->asset_type_id !== 0) {
                                $assetTypeName = $model->assetType->type_name;
                            }
                        ?>

                        <button class="tab-sub-button px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200" data-target="loai-tai-san-ca-nhan">
                            Loại Tài Sản <?= Html::encode($assetTypeName) ?>
                        </button>
                    </nav>
                    
                    <div id="vi-tri-mat-tien" class="tab-sub-content space-y-4">
                        <div class="flex items-start justify-between">
                            <p class="text-gray-700 copy-text" id="vi-tri-text">
                                Nhà  <b><?= formatPriceUnit($model->price) ?> </b> có diện tích <?= formatNumber($model->area_width) ?>m × <?= formatNumber($model->area_length) ?>m 
                                <?php if (!empty($model->propertyAdvantages)): ?>
                                    <?php
                                        echo ', ';
                                        $advantages = array_map(function($item) {
                                            return $item->advantage->name;
                                        }, $model->propertyAdvantages);

                                        echo implode(', ', $advantages);
                                    ?>
                                <?php endif; ?>
                                <?php if (!empty($model->propertyDisadvantages)): ?>
                                    <?php
                                        echo ', ';
                                        $advantages = array_map(function($item) {
                                            return $item->disadvantage->disadvantage_name; 
                                        }, $model->propertyDisadvantages);

                                        echo implode(', ', $advantages);
                                    ?>
                                <?php endif; ?>
                            </p>
                            <button class="ml-4 text-gray-500 hover:text-gray-700 flex items-center text-sm copy-btn" data-copy-target="#vi-tri-text">
                                <i class="far fa-copy mr-1"></i> Copy
                            </button>
                        </div>
                        <?php if (!empty($model->transaction_description)): ?>
                            <div class="flex space-x-4 mb-4 ">
                                <button class="tab-sub-button px-4 py-2 text-sm font-medium rounded-full bg-orange-100 text-orange-700">Ghi chú</button>
                            </div>
                            <div class="flex items-start" >
                                <p  class="ml-4" > <?= \yii\helpers\Html::decode($model->transaction_description) ?> </p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div id="loai-tai-san-ca-nhan" class="tab-sub-content hidden space-y-4">
                        <p class="text-gray-700">Thông tin chi tiết về loại tài sản cá nhân sẽ được hiển thị tại đây.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-md font-semibold text-gray-800 mb-3">SỔ HỒNG | GIẤY TỜ PHÁP LÝ</h3>
                <?php if (!empty($model->propertyImages)): ?>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 uploaded-images">
                        <?php
                            $baseUrl = 'https://app.bdsdaily.com/image-proxy';
                            $images = $model->propertyImages;
                            foreach ($images as $image) {
                                if ($image->image_type == 1) {
                                    $imagePath = $image->image_path;
                                    if ($image->status_external  === 1) {
                                        $urlLocal = 'http://app.bdsdaily.com';
                                        if (strpos($imagePath, '/') === 0) {
                                            $imageUrl = $urlLocal . $imagePath;
                                        } else {
                                            $imageUrl = $urlLocal . '/' . $imagePath;
                                        }
                                        echo "<div class='relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200 image-container'>";
                                        echo "<img src='{$imageUrl}' loading='lazy' alt='" . Html::encode($image->image_path) . "' class='view-image-button cursor-pointer object-cover w-full h-full' data-image-url='{$imageUrl}'>";
                                        echo "</div>";
                                    } else {
                                        if (strpos($imagePath, '/') === 0) {
                                            $imageUrl = $baseUrl . $imagePath;
                                        } else {
                                            $imageUrl = $baseUrl . '/' . $imagePath;
                                        }
                                        echo "<div class='relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200 image-container'>";
                                        echo "<img src='{$imageUrl}' loading='lazy' alt='" . Html::encode($image->image_path) . "' class='view-image-button cursor-pointer object-cover w-full h-full' data-image-url='{$imageUrl}'>";
                                        echo "</div>";
                                    }
                                }
                            }
                        ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        Chưa có hình ảnh nào cho BĐS này.
                    </div>
                <?php endif; ?>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-md font-semibold text-gray-800 mb-3">HÌNH ẢNH BỔ SUNG</h3>
                <?php if (!empty($model->propertyImages)): ?>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 uploaded-images">
                        <?php
                            $baseUrl = 'https://app.bdsdaily.com/image-proxy';
                            $images = $model->propertyImages;
                            foreach ($images as $image) {
                                if ($image->image_type == 0) {
                                    $imagePath = $image->image_path;
                                    if ($image->status_external  === 1) {
                                        $urlLocal = 'http://app.bdsdaily.com';
                                        if (strpos($imagePath, '/') === 0) {
                                            $imageUrl = $urlLocal . $imagePath;
                                        } else {
                                            $imageUrl = $urlLocal . '/' . $imagePath;
                                        }
                                        echo "<div class='relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200 image-container'>";
                                        echo "<img src='{$imageUrl}' loading='lazy' alt='" . Html::encode($image->image_path) . "' class='view-image-button cursor-pointer object-cover w-full h-full' data-image-url='{$imageUrl}'>";
                                        echo "</div>";
                                    } else {
                                        if (strpos($imagePath, '/') === 0) {
                                            $imageUrl = $baseUrl . $imagePath;
                                        } else {
                                            $imageUrl = $baseUrl . '/' . $imagePath;
                                        }
                                        echo "<div class='relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200 image-container'>";
                                        echo "<img src='{$imageUrl}' loading='lazy' alt='" . Html::encode($image->image_path) . "' class='view-image-button cursor-pointer object-cover w-full h-full' data-image-url='{$imageUrl}'>";
                                        echo "</div>";
                                    }
                                }
                            }
                        ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        Chưa có hình ảnh nào cho BĐS này.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div id="imageViewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 hidden">
            <div id="modalContent" class="relative p-4 bg-white rounded-lg shadow-xl overflow-auto flex flex-col transition-all duration-200">
                <button id="closeImageViewModal" class="absolute top-2 right-2 p-2 text-gray-600 hover:text-gray-900 text-2xl z-10" aria-label="Close image modal">
                    &times;
                </button>
                <div class="flex-grow flex items-center justify-center overflow-hidden relative">
                    <img id="modalImageView" src="" alt="Property Image" class="max-w-full max-h-[80vh] object-contain mx-auto my-0 transition-transform duration-200 cursor-move" style="transform-origin: center;">
                    <button id="downloadImageButton" class="absolute top-2 right-2 p-2 bg-gray-100 bg-opacity-75 text-gray-800 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 z-10" aria-label="Download image">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
                <footer class="flex justify-center mt-4 space-x-4 py-2">
                    <button id="zoomInButton" class="p-2 bg-gray-100 bg-opacity-75 text-gray-800 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500" aria-label="Zoom in">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <button id="zoomOutButton" class="p-2 bg-gray-100 bg-opacity-75 text-gray-800 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500" aria-label="Zoom out">
                        <i class="fas fa-search-minus"></i>
                    </button>
                    <button id="rotateLeftButton" class="p-2 bg-gray-100 bg-opacity-75 text-gray-800 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500" aria-label="Xoay trái">
                        <i class="fas fa-undo"></i>
                    </button>
                </footer>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <?php if (!empty($model->propertyUpdateLogs)): ?>
                <?= $this->render('_history', ['modelLog' => $model->propertyUpdateLogs]) ?>
            <?php endif; ?>
            

            <?php if (!empty($model->propertyLogs)): ?>
                <?= $this->render('_history_extent', ['modelLog' => $model->propertyLogs]) ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<div id="dialog" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto mx-4 my-2 sm:mx-6 sm:my-4">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Lịch sử tương tác</h3>
            <button id="cancelIcon" class="text-gray-500 hover:text-gray-700" type="button" aria-label="Close dialog">
                <i class="fas fa-times-circle text-xl"></i>
            </button>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="space-y-6">
                <?php if (count($modelActionPhone)): ?>
                    <?php foreach ($modelActionPhone as $action): ?>
                        <div class="flex items-start space-x-4">
                            <img src="https://placehold.co/40x40/E5E7EB/4B5563?text=<?= $action->user ? $action->user->username : 'Admin' ?>" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-500 text-xs"><?= $action->timestamp ?></span>
                                        <span class="font-semibold text-gray-900"><?= $action->user ? $action->user->full_name : 'Admin'?></span>
                                        <span class="px-2 py-0.5 bg-gray-800 text-white text-xs rounded-md font-medium"><?= $action->user ? $action->user->username : 'Admin' ?></span>
                                    </div>
                                </div>
                                <div class="mt-2 pl-2 border-l-2 border-gray-200">
                                    <div class="flex flex-col items-start p-2 bg-gray-50 rounded-lg">
                                        <?php if ($action->action == 'create'): ?>
                                            <button class="flex items-center text-blue-500 hover:text-blue-700 transition-colors mt-2">
                                                <i class="fas fa-plus-square mr-2"></i>
                                                Thêm mới
                                            </button>
                                        <?php else: ?>
                                            <button class="flex items-center text-blue-500 hover:text-blue-700 transition-colors mb-2">
                                                <i class="fas fa-phone-alt mr-2"></i>
                                                Xem số điện thoại
                                            </button>
                                        <?php endif; ?>
                                        <span class="text-gray-700"><?= $action->user ? $action->user->full_name : 'Admin' ?>: <span class="text-red-600 font-medium"><?= HtmlLogHelper::maskPhoneNumber($action->phone_number)?></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="flex items-start space-x-4">
                        <span class="text-gray-700">Chưa có tương tác</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openDialogButton = document.getElementById('openDialog');
        const dialog = document.getElementById('dialog');
        const cancelIcon = document.getElementById('cancelIcon');

        openDialogButton.addEventListener('click', () => {
            dialog.classList.remove('hidden');
        });

        cancelIcon.addEventListener('click', () => {
            dialog.classList.add('hidden');
            inputField.value = ''; 
        });


        dialog.addEventListener('click', (e) => {
            if (e.target === dialog) {
                dialog.classList.add('hidden');
                inputField.value = ''; 
            }
        });

        const imageViewModal = document.getElementById('imageViewModal');
        const modalContent = document.getElementById('modalContent');
        const modalImageView = document.getElementById('modalImageView');
        const closeImageViewModalButton = document.getElementById('closeImageViewModal');
        const zoomInButton = document.getElementById('zoomInButton');
        const zoomOutButton = document.getElementById('zoomOutButton');
        const downloadImageButton = document.getElementById('downloadImageButton');
        const rotateLeftButton = document.getElementById('rotateLeftButton');
        const viewImageButtons = document.querySelectorAll('.view-image-button');

        let zoomLevel = 1; // Initial zoom level
        const zoomStep = 0.2; // Zoom increment/decrement
        const minZoom = 0.5; // Minimum zoom level
        const maxZoom = 3; // Maximum zoom level
        let isDragging = false;
        let startX, startY, translateX = 0, translateY = 0;
        let rotation = 0; // Track rotation in degrees
        let currentImageIndex = 0; // Track current image
        const imageUrls = Array.from(viewImageButtons).map(button => button.getAttribute('data-image-url')); // Array of image URLs

        // Function to update modal size based on image dimensions
        function updateModalSize() {
            if (!modalImageView || !modalContent) return;

            const img = modalImageView;
            const naturalWidth = img.naturalWidth || 800; // Fallback width
            const naturalHeight = img.naturalHeight || 600; // Fallback height
            const angle = Math.abs(rotation % 360);

            let width, height;
            if (angle === 0 || angle === 180) {
                width = naturalWidth * zoomLevel;
                height = naturalHeight * zoomLevel;
            } else {
                width = naturalHeight * zoomLevel; // Swap for 90°/270°
                height = naturalWidth * zoomLevel;
            }

            const padding = 16 * 2; // Left + right
            const footerHeight = 60; // Approximate footer height
            const maxWidth = window.innerWidth * 0.9; // 90% of viewport width
            const maxHeight = window.innerHeight * 0.9; // 90% of viewport height

            modalContent.style.width = `${Math.min(width + padding, maxWidth)}px`;
            modalContent.style.height = `${Math.min(height + padding + footerHeight, maxHeight)}px`;
        }

        // Function to update image transform
        function updateTransform() {
            if (modalImageView) {
                modalImageView.style.transform = `rotate(${rotation}deg) scale(${zoomLevel}) translate(${translateX}px, ${translateY}px)`;
                modalImageView.style.cursor = zoomLevel > 1 ? 'move' : 'default';
                updateModalSize();
            }
        }

        // Function to open the image modal
        function openImageViewModal(index) {
            if (modalImageView && imageViewModal && imageUrls[index]) {
                currentImageIndex = index;
                modalImageView.src = imageUrls[index];
                zoomLevel = 1;
                translateX = 0;
                translateY = 0;
                rotation = 0;
                modalImageView.onload = updateTransform;
                imageViewModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        // Function to close the image modal
        function closeImageViewModal() {
            if (imageViewModal) {
                imageViewModal.classList.add('hidden');
                modalImageView.src = '';
                zoomLevel = 1;
                translateX = 0;
                translateY = 0;
                rotation = 0;
                currentImageIndex = 0;
                modalContent.style.width = '';
                modalContent.style.height = '';
                updateTransform();
                document.body.style.overflow = '';
            }
        }

        // Function to show previous image
        function showPreviousImage() {
            if (imageUrls.length > 0) {
                currentImageIndex = (currentImageIndex - 1 + imageUrls.length) % imageUrls.length; // Wrap around
                modalImageView.src = imageUrls[currentImageIndex];
                zoomLevel = 1;
                translateX = 0;
                translateY = 0;
                rotation = 0;
                modalImageView.onload = updateTransform;
            }
        }

        // Function to show next image
        function showNextImage() {
            if (imageUrls.length > 0) {
                currentImageIndex = (currentImageIndex + 1) % imageUrls.length; // Wrap around
                modalImageView.src = imageUrls[currentImageIndex];
                zoomLevel = 1;
                translateX = 0;
                translateY = 0;
                rotation = 0;
                modalImageView.onload = updateTransform;
            }
        }

        // Add navigation buttons
        const footer = modalContent.querySelector('footer');
        const prevButton = document.createElement('button');
        prevButton.className = 'p-2 bg-gray-100 bg-opacity-75 text-gray-800 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500';
        prevButton.innerHTML = '<i class="fas fa-arrow-left"></i>';
        prevButton.setAttribute('aria-label', 'Previous image');
        footer.insertBefore(prevButton, footer.firstChild);

        const nextButton = document.createElement('button');
        nextButton.className = 'p-2 bg-gray-100 bg-opacity-75 text-gray-800 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500';
        nextButton.innerHTML = '<i class="fas fa-arrow-right"></i>';
        nextButton.setAttribute('aria-label', 'Next image');
        footer.appendChild(nextButton);

        // Add click listener to each view button
        viewImageButtons.forEach((button, index) => {
            button.addEventListener('click', function() {
                openImageViewModal(index);
            });
        });

        // Previous button click
        prevButton.addEventListener('click', function(event) {
            event.stopPropagation();
            showPreviousImage();
        });

        // Next button click
        nextButton.addEventListener('click', function(event) {
            event.stopPropagation();
            showNextImage();
        });

        // Zoom in button
        if (zoomInButton) {
            zoomInButton.addEventListener('click', function(event) {
                event.stopPropagation();
                zoomLevel = Math.min(zoomLevel + zoomStep, maxZoom);
                updateTransform();
            });
        }

        // Zoom out button
        if (zoomOutButton) {
            zoomOutButton.addEventListener('click', function(event) {
                event.stopPropagation();
                zoomLevel = Math.max(zoomLevel - zoomStep, minZoom);
                translateX = 0;
                translateY = 0;
                updateTransform();
            });
        }

        // Download button
        if (downloadImageButton) {
            downloadImageButton.addEventListener('click', function(event) {
                event.stopPropagation();
                const imageUrl = modalImageView.src;
                if (imageUrl) {
                    const link = document.createElement('a');
                    link.href = imageUrl;
                    link.download = `property-image-${currentImageIndex + 1}.jpg`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            });
        }

        // Rotate left button
        if (rotateLeftButton) {
            rotateLeftButton.addEventListener('click', function(event) {
                event.stopPropagation();
                rotation = (rotation - 90) % 360;
                updateTransform();
            });
        }

        // Drag-and-drop logic
        if (modalImageView) {
            modalImageView.addEventListener('mousedown', function(event) {
                if (zoomLevel > 1) {
                    event.preventDefault();
                    isDragging = true;
                    startX = event.clientX - translateX;
                    startY = event.clientY - translateY;
                }
            });

            modalImageView.addEventListener('mousemove', function(event) {
                if (isDragging && zoomLevel > 1) {
                    translateX = event.clientX - startX;
                    translateY = event.clientY - startY;
                    const maxTranslate = Math.max(modalImageView.naturalWidth, modalImageView.naturalHeight) * zoomLevel * 0.5;
                    translateX = Math.max(-maxTranslate, Math.min(maxTranslate, translateX));
                    translateY = Math.max(-maxTranslate, Math.min(maxTranslate, translateY));
                    updateTransform();
                }
            });

            modalImageView.addEventListener('mouseup', function() {
                isDragging = false;
            });

            modalImageView.addEventListener('mouseleave', function() {
                isDragging = false;
            });
        }

        // Close modal button
        if (closeImageViewModalButton) {
            closeImageViewModalButton.addEventListener('click', closeImageViewModal);
        }

        // Close modal if clicked outside the content
        if (imageViewModal) {
            imageViewModal.addEventListener('click', function(event) {
                if (event.target === imageViewModal) {
                    closeImageViewModal();
                }
            });
        }

        // Handle keyboard navigation
        document.addEventListener('keydown', function(event) {
            if (!imageViewModal.classList.contains('hidden')) {
                if (event.key === 'Escape') {
                    closeImageViewModal();
                } else if (event.key === 'ArrowLeft') {
                    event.preventDefault();
                    showPreviousImage();
                } else if (event.key === 'ArrowRight') {
                    event.preventDefault();
                    showNextImage();
                }
            }
        });

        modalImageView.addEventListener('wheel', function(event) {
            event.preventDefault();
            const delta = event.deltaY > 0 ? -zoomStep : zoomStep;
            zoomLevel = Math.max(minZoom, Math.min(zoomLevel + delta, maxZoom));
            if (zoomLevel <= 1) {
                translateX = 0;
                translateY = 0;
            }
            updateTransform();
        }, { passive: false });

        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.querySelector(button.getAttribute('data-copy-target'));
                if (target) {
                    const text = target.textContent;
                    navigator.clipboard.writeText(text).then(() => {
                        alert('Đã sao chép!');
                    }).catch(err => {
                        alert('Không thể sao chép!');
                        console.error(err);
                    });
                }
            });
        });



        const contactEntries = document.querySelectorAll('.contact-entry');
            contactEntries.forEach(entry => {
                const contactInfo = entry.querySelector('.contact-info');
                contactInfo.addEventListener('click', function() {
                    const contactId = entry.getAttribute('data-contact-id');
                    const phoneDisplay = entry.querySelector('.phone-display');
                    const zaloLink = entry.querySelector('.zalo-link');
                    const zaloAnchor = entry.querySelector('.zalo-anchor');
                    const errorMessage = entry.querySelector('.error-message');
                    const originalPhoneText = phoneDisplay.textContent; 

                    if (phoneDisplay.classList.contains('revealed')) {
                        return;
                    }

                    phoneDisplay.textContent = 'Đang tải...';

                    fetch('/property/get-phone', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': yii.getCsrfToken()
                        },
                        body: JSON.stringify({
                            contact_id: contactId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.phone_number) {
                            phoneDisplay.textContent = data.phone_number;
                            phoneDisplay.classList.add('revealed');
                            if (zaloLink && zaloAnchor) {
                                zaloLink.classList.remove('hidden');
                                zaloAnchor.href = `https://zalo.me/${data.phone_number}`;
                            }
                        } else {
                            phoneDisplay.textContent = originalPhoneText; 
                            if (errorMessage) {
                                errorMessage.textContent = data.error || 'Không thể lấy số điện thoại';
                                errorMessage.classList.remove('hidden');
                            }
                            if (zaloLink) {
                                zaloLink.classList.add('hidden');
                            }
                            console.error('Error:', data.error || 'Unknown error');
                        }
                    })
                    .catch(error => {
                        phoneDisplay.textContent = originalPhoneText; 
                        if (errorMessage) {
                            errorMessage.textContent = 'Lỗi kết nối máy chủ';
                            errorMessage.classList.remove('hidden');
                        }
                        if (zaloLink) {
                            zaloLink.classList.add('hidden');
                        }
                        console.error('Fetch error:', error);
                    });
                });
            });
    });

    const imageViewModal = document.getElementById('imageViewModal');
    const modalImageView = document.getElementById('modalImageView');
    const closeImageViewModalButton = document.getElementById('closeImageViewModal');
    const zoomInButton = document.getElementById('zoomInButton');
    const zoomOutButton = document.getElementById('zoomOutButton');
    const viewImageButtons = document.querySelectorAll('.view-image-button');

    let zoomLevel = 1; // Initial zoom level
    const zoomStep = 0.2; // Zoom increment/decrement
    const minZoom = 0.5; // Minimum zoom level
    const maxZoom = 3; // Maximum zoom level

    // Function to update zoom
    function updateZoom() {
        if (modalImageView) {
            modalImageView.style.transform = `scale(${zoomLevel})`;
        }
    }

    // Function to open the image modal
    function openImageViewModal(imageUrl) {
        if (modalImageView && imageViewModal) {
            modalImageView.src = imageUrl;
            zoomLevel = 1; // Reset zoom level when opening
            updateZoom();
            imageViewModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    // Function to close the image modal
    function closeImageViewModal() {
        if (imageViewModal) {
            imageViewModal.classList.add('hidden');
            modalImageView.src = '';
            zoomLevel = 1; // Reset zoom level when closing
            updateZoom();
            document.body.style.overflow = '';
        }
    }

    // Add click listener to each view button
    viewImageButtons.forEach(button => {
        button.addEventListener('click', function() {
            const imageUrl = this.getAttribute('data-image-url');
            if (imageUrl) {
                openImageViewModal(imageUrl);
            }
        });
    });

    // Zoom in button
    if (zoomInButton) {
        zoomInButton.addEventListener('click', function() {
            zoomLevel = Math.min(zoomLevel + zoomStep, maxZoom);
            updateZoom();
        });
    }

    // Zoom out button
    if (zoomOutButton) {
        zoomOutButton.addEventListener('click', function() {
            zoomLevel = Math.max(zoomLevel - zoomStep, minZoom);
            updateZoom();
        });
    }

    // Close modal button
    if (closeImageViewModalButton) {
        closeImageViewModalButton.addEventListener('click', closeImageViewModal);
    }

    // Close modal if clicked outside the content
    if (imageViewModal) {
        imageViewModal.addEventListener('click', function(event) {
            if (event.target === imageViewModal) {
                closeImageViewModal();
            }
        });
    }


    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !imageViewModal.classList.contains('hidden')) {
            closeImageViewModal();
        }
    });

    document.querySelectorAll('.jCopyTextTarget').forEach(copyBtn => {
        copyBtn.addEventListener('click', function() {
        const targetSelector = this.dataset.target;
        const targetText = document.querySelector(targetSelector)?.innerText || '';
        navigator.clipboard.writeText(targetText).then(() => {
            alert('Đã sao chép: ' + targetText);
        }).catch(err => {
            console.error('Không thể sao chép!', err);
        });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.copy-info').forEach(function (el) {
      el.addEventListener('click', function () {
        const text = el.innerText.trim();

        navigator.clipboard.writeText(text).then(() => {
          alert('Đã sao chép: ' + text);
        }).catch(err => {
          console.error('Lỗi khi sao chép:', err);
          alert('Không thể sao chép nội dung.');
        });
      });
    });
  });
    
    function toggleDetails(element) {
        const details = element.nextElementSibling;
        const arrow = element.querySelector('.toggle-arrow');
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            arrow.textContent = '▲';
        } else {
            details.classList.add('hidden');
            arrow.textContent = '▼';
        }
    }

</script>