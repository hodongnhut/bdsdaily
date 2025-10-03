<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
Use common\models\Directions;
use common\models\LandType;
use common\models\Interiors;
use common\models\Advantages;
use common\models\Disadvantages;
use common\models\AssetTypes;
use common\models\CommissionTypes;
use common\models\TransactionStatuses;

if ($model->listing_types_id === 2) {
    $interiors = Interiors::find()->all();
    $selected = array_column($model->interiors, 'interior_id');
}

$advantages = Advantages::find()->all();
$disadvantages = Disadvantages::find()->all();
$assetTypes = ArrayHelper::map(AssetTypes::find()->where(['<>', 'asset_type_id', 9])->all(), 'asset_type_id', 'type_name');
$commissionTypes = ArrayHelper::map(CommissionTypes::find()->all(), 'id', 'name');
$transactionStatuses = ArrayHelper::map(TransactionStatuses::find()->where(['<>', 'transaction_status_id', 0])->all(), 'transaction_status_id', 'status_name');
$selectedAdvantages = array_column($model->advantages, 'advantage_id');
$selectedDisadvantages = array_column($model->disadvantages, 'disadvantage_id');

/** @var yii\web\View $this */
/** @var common\models\Properties $model */
?>
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg rounded-br-lg">
    <div class="text-lg font-semibold text-gray-800">
    <h2 class="text-lg font-semibold text-gray-800">
            <a href="<?= \yii\helpers\Url::to(['/property']) ?>"><i class="fas fa-database text-xl"></i> Dữ Liệu Nhà Đất</a> / 
            Thêm Dữ Liệu Nhà Đất [Mã: <?= $model->property_id ?> - Loại Giao Dịch: <?= $model->listingType->name ?>]</h2>
    </div>
    <div class="relative flex items-center space-x-4">
        <?php
            if (!empty($model->external_id) || $model->status_review === 0 ) {
                if (in_array(Yii::$app->user->identity->jobTitle->role_code ?? '', ['manager', 'super_admin']) && $model->status_review === 0) { ?>
                    <?= Html::a('<i class="fas fa-check"></i> Duyệt', ['property/review', 'property_id' => $model->property_id], [
                        'class' => 'px-4 py-2 bg-green-600 text-white rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500',
                        'title' => 'Duyệt bài',
                        'data' => [
                            'method' => 'post',
                            'confirm' => 'Vui lòng Kiểm tra thông tin nhập 1 lần nữa . Nếu bạn chắt chắn thì duyệt tin!',
                        ],
                    ]); ?>
            <?php }  ?>
        <?php }  ?>
        <div class="flex space-x-2">
            <?= Html::submitButton('<i class="fas fa-save"></i> Lưu Lại', [
                'onclick' => 'submitPropertyForm()',
                'class' => 'px-4 py-2 bg-orange-600 text-white rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500'
            ]) ?>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Quay lại', Yii::$app->request->referrer ?: ['index'], ['class' => 'px-4 py-2 bg-gray-200 text-gray-800 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500']) ?>
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
<main class="flex-1 p-2 overflow-auto">
   
    <div class="bg-white mt-2 p-4 shadow-md flex items-center justify-between rounded-bl-lg rounded-br-lg rounded-tr-lg rounded-tl-lg">
        <nav class="flex space-x-4">
            <button id="thong-tin-tab" class="px-4 py-2 text-orange-600 border-b-2 border-orange-600 font-medium rounded-t-md">Thông Tin</button>
            <button id="so-hong-tab" class="px-4 py-2 text-gray-600 hover:text-orange-600 hover:border-b-2 hover:border-orange-600 transition-colors duration-200 rounded-t-md">Sổ Hồng & Hình Ảnh</button>
        </nav>
        <div class="text-lg font-semibold text-gray-800">
            Địa Chỉ <span class="text-gray-500 text-sm">→ <?= Html::encode($model->title) ?></span>
        </div>
    </div>

    <div id="thong-tin-content" class="tab-content">
        <?php $form = ActiveForm::begin([
            'id'=> 'property',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{hint}\n{error}",
                'labelOptions' => ['class' => 'form-label'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'invalid-feedback d-block'], 
                'hintOptions' => ['class' => 'form-text text-muted'],
                ],
            ]); 
        ?>

        <?= $form->field($model, 'property_id')->hiddenInput()->label(false) ?>

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md space-y-6">
                <label class="text-md font-semibold text-gray-800 required">Vị Trí BĐS</label>
                <div class="flex space-x-2 mb-4" id="location-type-buttons">
                    <button type="button" data-value="1"
                        class="location-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Mặt Tiền
                    </button>
                    <button type="button" data-value="2"
                        class="location-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Đường Nội Bộ
                    </button>
                    <button type="button" data-value="3"
                        class="location-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Hẻm
                    </button>
                    <button type="button" data-value="4"
                        class="location-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Compound
                    </button>
                </div>
                <?= $form->field($model, 'location_type_id')->hiddenInput(['id' => 'location_type_id'])->label(false) ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1 required">Giá chào</label>
                        <?= $form->field($model, 'price', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'price',
                            'maxlength' => true,
                            'value' => ($model->price !== null && floor($model->price) == $model->price) ? (int)$model->price : $model->price,
                            'class' => 'mt-1 block w-full border rounded-md shadow-sm py-2 px-3 sm:text-sm ' .
                                ($model->hasErrors('price') 
                                    ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                    : 'border-gray-300 focus:border-orange-500 focus:ring-orange-500'),
                        ]) ?>
                        
                        <p id="price-display" class="inline-block mt-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-orange-700"></p>
                    </div>

                    <div>
                        <label for="final_price" class="block text-sm font-medium text-gray-700 mb-1">Giá chốt</label>
                        <?= $form->field($model, 'final_price', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'final_price',
                            'maxlength' => true,
                            'value' => ($model->final_price !== null && floor($model->final_price) == $model->final_price) ? (int)$model->final_price : $model->final_price,
                            'class' => 'mt-1 block w-full border rounded-md shadow-sm py-2 px-3 sm:text-sm ' .
                                ($model->hasErrors('final_price') 
                                    ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                    : 'border-gray-300 focus:border-orange-500 focus:ring-orange-500'),
                        ]) ?>
                        
                        <p id="final-price-display" class="inline-block mt-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-orange-700"></p>
                    </div>
                </div>
                <?php if ($model->listing_types_id != 2) : ?>
                    <div class="grid grid-cols-1">
                        <?= $form->field($model, 'has_rental_contract', [
                                'template' => '{input}{label}{error}',
                            ])->checkbox([
                                'id' => 'has_rental_contract',
                                'class' => 'h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded',
                            ]) ?>
                    </div>
                    <div class="grid grid-cols-1">
                        <div id="rental-details-container" class="hidden mt-2 p-4 border border-gray-200 rounded-md bg-gray-50 space-y-4">
                            <h4 class="font-medium text-gray-800">Chi tiết hợp đồng thuê</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Giá cho thuê</label>
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <?= $form->field($rentalContractModel, 'rent_price', [
                                            'template' => '{input}{error}'
                                        ])->textInput([
                                            'type' => 'number',
                                            'id' => 'rent-price',
                                            'min' => 0,
                                            'class' => 'block w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm pr-24', // Thêm padding phải (pr-24)
                                            'value' => $rentalContractModel->rent_price ? (float)$rentalContractModel->rent_price : null,
                                            'oninput' => "if(this.value < 0) this.value = 0;",
                                        ]) ?>
                                        

                                        <div class="absolute inset-y-0 right-0 flex items-center">
                                            <?= $form->field($rentalContractModel, 'currency_id', [
                                                'template' => '{input}'
                                            ])->dropDownList(
                                                [1 => 'VND', 2 => 'USD'],
                                                [
                                                    'class' => 'h-full rounded-md border-transparent bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                                                ]
                                            ) ?>
                                        </div>
                                    </div>
                                    <p id="rent-price-display" class="inline-block mt-2 px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-orange-700"></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Thời hạn thuê</label>
                                    <?= $form->field($rentalContractModel, 'lease_term', [
                                        'template' => '{input}{error}'
                                    ])->textInput([
                                        'type' => 'number',
                                        'min' => 1,
                                        'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                        'placeholder' => 'Ví dụ: 12',
                                        'oninput' => "if(this.value !== '' && this.value < 1) this.value = 1;",
                                    ]) ?>
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Đơn vị thời hạn</label>
                                    <?= $form->field($rentalContractModel, 'lease_term_unit', [
                                        'template' => '{input}{error}'
                                    ])->dropDownList(
                                        ['month' => 'Tháng', 'year' => 'Năm'],
                                        ['prompt' => 'Chọn đơn vị', 'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm']
                                    ) ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ngày hết hạn</label>
                                    <?= $form->field($rentalContractModel, 'expiry_date', [
                                        'template' => '{input}{error}'
                                    ])->textInput([
                                        'type' => 'date',
                                        'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="plot_number" class="block text-sm font-medium text-gray-700 mb-1">Số Thửa</label>
                        <?= $form->field($model, 'plot_number', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'plot_number',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                        ]) ?>
                    </div>
                    <div>
                        <label for="map_sheet_number" class="block text-sm font-medium text-gray-700 mb-1">Số Tờ</label>
                        <?= $form->field($model, 'sheet_number', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'sheet_number',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                        ]) ?>
                    </div>
                    <div>
                        <label for="lot_number" class="block text-sm font-medium text-gray-700 mb-1">Số Lô</label>
                        <?= $form->field($model, 'lot_number', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'lot_number',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                        ]) ?>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="project_name" class="block text-sm font-medium text-gray-700 mb-1 required">Số Nhà</label>
                        <?= $form->field($model, 'house_number', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'house_number',
                            'maxlength' => true,
                            'class' => 'mt-1 block w-full border rounded-md shadow-sm py-2 px-3 sm:text-sm ' .
                                ($model->hasErrors('house_number')
                                    ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                    : 'border-gray-300 focus:border-orange-500 focus:ring-orange-500'),
                        ]) ?>
                    </div>

                    <div>
                        <label for="project_name" class="block text-sm font-medium text-gray-700 mb-1 required">Đường</label>
                        <?= $form->field($model, 'street_name', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'street_name',
                            'maxlength' => true,
                            'class' => 'mt-1 block w-full border rounded-md shadow-sm py-2 px-3 sm:text-sm ' .
                                ($model->hasErrors('street_name')
                                    ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                    : 'border-gray-300 focus:border-orange-500 focus:ring-orange-500'),
                        ]) ?>
                    </div>
                    <!-- Project Name -->
                    <div>
                        <label for="region" class="block text-sm font-medium text-gray-700 mb-1">Khu vực</label>
                        <?= $form->field($model, 'region', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'region',
                            'maxlength' => true,
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                            'placeholder' => 'Nhập tên khu vực'
                        ]) ?>
                    </div>
                </div>
                <!-- Address Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-1 required">Tỉnh / TP</label>
                        <?= $form->field($model, 'city')->label(label: false) ?>
                    </div>

                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-1 required">Quận / Huyện</label>
                        <?= $form->field($model, 'district_county')->label(label: false) ?>
                    </div>
                
                    <div>
                        <label for="ward" class="block text-sm font-medium text-gray-700 mb-1 required">Phường / Xã</label>
                        <?= $form->field($model, 'ward_commune')->label(false) ?>
                    </div>
                </div>
                
                <!-- Dimensions Section -->
                <h3 class="text-md font-semibold text-gray-800 mt-6 mb-3">Diện Tích Đất</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="frontage" class="block text-sm font-medium text-gray-700 mb-1 required">Ngang</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <?= $form->field($model, 'area_width', options: [
                                'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'area_width',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border rounded-md py-2 px-3 sm:text-sm ' .
                                        ($model->hasErrors('area_width') 
                                            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:ring-orange-500 focus:border-orange-500'),
                                ]) 
                            ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="rearage" class="block text-sm font-medium text-gray-700 mb-1 required">Dài</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <?= $form->field($model, 'area_length', options: [
                                'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'area_length',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border rounded-md py-2 px-3 sm:text-sm ' .
                                        ($model->hasErrors('area_length') 
                                            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:ring-orange-500 focus:border-orange-500'),
                                ]) 
                            ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="planned_back_side" class="block text-sm font-medium text-gray-700 mb-1">Mặt Hậu</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <?= $form->field($model, 'planned_back_side', [
                                'template' => '{input}{error}',
                            ])->textInput([
                                'id' => 'planned_back_side',
                                'maxlength' => true,
                                'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                            ]) ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m²</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="planned_area" class="block text-sm font-medium text-gray-700 mb-1 required">DT Công Nhận</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <?= $form->field($model, 'area_total', [
                                'template' => '{input}{error}',
                            ])->textInput([
                                'id' => 'area_total',
                                'maxlength' => true,
                                'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                'placeholder' => '0.00',
                            ]) ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m²</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($model->listing_types_id != 2) : ?>
                    <h3 class="text-md font-semibold text-gray-800 mt-6 mb-3">Diện Tích Quy Hoạch</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="frontage" class="block text-sm font-medium text-gray-700 mb-1">Ngang</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <?= $form->field($model, 'planned_width', [
                                    'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'planned_width',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                    'placeholder' => '9.00',
                                ]) ?>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">m</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="rearage" class="block text-sm font-medium text-gray-700 mb-1">Dài</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <?= $form->field($model, 'planned_length', [
                                    'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'planned_length',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                    'placeholder' => '11.00',
                                ]) ?>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">m</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="area" class="block text-sm font-medium text-gray-700 mb-1">Mặt Hậu</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <?= $form->field($model, 'planned_back_side', [
                                    'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'planned_back_side',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                    'placeholder' => '115.00',
                                ]) ?>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">m²</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="planned_area" class="block text-sm font-medium text-gray-700 mb-1">DT Xây Dựng</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <?= $form->field($model, 'planned_construction_area', [
                                    'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'planned_construction_area',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                    'placeholder' => '0.00',
                                ]) ?>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">m²</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Characteristics Section -->
                <h3 class="text-md font-semibold text-gray-800 mb-3">Thông Tin Khác</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                    <div>
                        <label for="product_type" class="block text-sm font-medium text-gray-700 mb-1 required">Loại sản phẩm</label>
                        <?= $form->field($model, 'property_type_id', [
                            'template' => '{input}{error}',
                        ])->dropDownList(
                            ArrayHelper::map($modelPropertyTypes, 'property_type_id', 'type_name'),
                            [
                                'prompt' => 'Chọn loại sản phẩm',
                                'id' => 'property_type_id',
                                'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                            ]
                        ) ?>
                    </div>
                    <div>
                        <label for="direction" class="block text-sm font-medium text-gray-700 mb-1">Hướng</label>
                        <?= $form->field($model, 'direction_id', [
                            'template' => '{input}{error}',
                        ])->dropDownList(
                            ArrayHelper::map(Directions::find()->where(['<>', 'id', 0])->all(), 'id', 'name'),
                            [
                                'id' => 'direction_id',
                                'class' => 'mt-1 block w-full border rounded-md shadow-sm py-2 px-3 sm:text-sm ' .
                                    ($model->hasErrors('direction_id') 
                                        ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                        : 'border-gray-300 focus:border-orange-500 focus:ring-orange-500'),
                                'prompt' => 'Chọn Hướng',
                            ]
                        ) ?>
                    </div>
                    <?php if ($model->listing_types_id != 2) : ?>
                        <div>
                            <label for="direction" class="block text-sm font-medium text-gray-700 mb-1">Loại Đất</label>
                            <?= $form->field($model, 'land_type_id', [
                                'template' => '{input}{error}',
                            ])->dropDownList(
                                ArrayHelper::map(LandType::find()->all(), 'id', 'name'),
                                [
                                    'id' => 'land_type',
                                    'prompt' => 'Chọn loại đất',
                                    'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                                ]
                            ) ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <label for="road_width" class="block text-sm font-medium text-gray-700 mb-1">Đường rộng</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                        <?= $form->field($model, 'wide_road', [
                            'template' => '{input}{error}',
                            ])->textInput([
                                'id' => 'wide_road',
                                'maxlength' => true,
                                'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                'placeholder' => '2',
                            ]) 
                        ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="usable_area" class="block text-sm font-medium text-gray-700 mb-1">DT Sử dụng</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <?= $form->field($model, 'usable_area', [
                                'template' => '{input}{error}',
                            ])->textInput([
                                'id' => 'usable_area',
                                'maxlength' => true,
                                'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                'placeholder' => '2'
                            ]) ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m²</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="num_floors" class="block text-sm font-medium text-gray-700 mb-1">Số Tầng</label>
                        <?= $form->field($model, 'num_floors', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'num_floors',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                            'placeholder' => '0'
                        ]) ?>
                    </div>
                    <div>
                        <label for="num_bedrooms" class="block text-sm font-medium text-gray-700 mb-1">Số phòng ngủ</label>
                        <?= $form->field($model, 'num_bedrooms', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'num_bedrooms',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                            'placeholder' => '0'
                        ]) ?>
                    </div>
                    <div>
                        <label for="num_bathrooms" class="block text-sm font-medium text-gray-700 mb-1">Số WC</label>
                        <?= $form->field($model, 'num_toilets', [
                                'template' => '{input}{error}',
                            ])->textInput([
                                'id' => 'num_toilets',
                                'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                'placeholder' => '0',
                            ]) ?>
                    </div>
                    <div>
                        <label for="num_basements" class="block text-sm font-medium text-gray-700 mb-1">Số tầng hầm</label>
                        <?= $form->field($model, 'num_basements', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'num_basements',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                            'placeholder' => '0',
                        ]) ?>
                    </div>

                </div>
                <?php if ($model->listing_types_id === 2) : ?>
                    <h3 class="text-md font-semibold text-gray-800 mb-3">Nội Thất</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-2 text-sm text-gray-700">
                    <?php foreach ($interiors as $interior): ?>
                        <label class="flex items-center">
                            <input 
                                type="checkbox"
                                name="interiors[]" 
                                value="<?= $interior->interior_id ?>"
                                class="form-checkbox h-4 w-4 text-orange-600 rounded"
                                <?= in_array($interior->interior_id, $selected) ? 'checked' : '' ?>
                            >
                            <span class="ml-2"><?= htmlspecialchars($interior->name) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>  
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm text-gray-700">
                    <!-- Column 1: Ưu Điểm -->
                    <div>
                        <h3 class="text-md font-semibold text-gray-800 mb-3">Ưu Điểm</h3>
                        <?php foreach ($advantages as $advantage): ?>
                            <label class="flex items-center mb-2">
                                <input 
                                    type="checkbox" 
                                    class="form-checkbox h-4 w-4 text-orange-600 rounded" 
                                    name="advantages[]" 
                                    value="<?= $advantage->advantage_id ?>"
                                    <?= in_array($advantage->advantage_id, $selectedAdvantages) ? 'checked' : '' ?>>
                                <span class="ml-2"><?= htmlspecialchars($advantage->name) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <!-- Column 2: Nhược Điểm -->
                    <div>
                        <h3 class="text-md font-semibold text-gray-800 mb-3">Nhược Điểm</h3>

                        <?php foreach ($disadvantages as $disadvantag): ?>
                        <label class="flex items-center mb-2">
                            <input 
                                type="checkbox" 
                                class="form-checkbox h-4 w-4 text-orange-600 rounded" 
                                name="disadvantages[]" 
                                value="<?= $disadvantag->disadvantage_id ?>"
                                <?= in_array($disadvantag->disadvantage_id, $selectedDisadvantages) ? 'checked' : '' ?>>
                            <span class="ml-2"><?= htmlspecialchars($disadvantag->disadvantage_name) ?></span>
                        </label>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- Column 2: Asset Type, Commission, Status, Advantages/Disadvantages, and Features -->
            <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-md space-y-6">
                <!-- Asset Type Section -->
                <div>
                    <label class="text-md font-semibold text-gray-800 mb-3 required">Loại Tài Sản</label>
                    <div class="flex flex-wrap gap-2">
                    <?= $form->field($model, 'asset_type_id', [
                        'template' => '{input}{error}',
                    ])->radioList(
                            $assetTypes,
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                    return '<label class="inline-flex items-center mr-4">' .
                                        '<input type="radio" class="form-radio text-orange-600 h-4 w-4" name="' . $name . '" value="' . $value . '" ' . ($checked ? 'checked' : '') . '>' .
                                        '<span class="ml-2 text-sm text-gray-700">' . htmlspecialchars($label) . '</span>' .
                                    '</label>';
                                },
                                'separator' => '',
                            ]
                        ) ?>
                    </div>
                
                </div>
                <!-- Commission Type Section -->
                <div>
                    <h3 class="text-md font-semibold text-gray-800 mb-3">Loại Hoa Hồng</h3>
                    <div class="flex space-x-4 mb-2">
                    <?php foreach ($commissionTypes as $id => $name): ?>
                        <label class="inline-flex items-center">
                            <input 
                                type="radio" 
                                class="form-radio text-orange-600 h-4 w-4" 
                                name="Properties[commission_types_id]" 
                                value="<?= $id ?>" 
                                <?= $model->commission_types_id == $id ? 'checked' : '' ?>>
                            <span class="ml-2 text-sm text-gray-700"><?= Html::encode($name) ?></span>
                        </label>
                    <?php endforeach; ?>
                    </div>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Tên">
                    <input type="text" class="mt-3 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Phần trăm">
                </div>
                <!-- Status Section -->
                <div>
                    <h3 class="text-md font-semibold text-gray-800 mb-3">Trạng Thái</h3>
                    <div class="flex flex-wrap gap-2 mb-2">
                        <?php foreach ($transactionStatuses as $id => $name): ?>
                            <label class="inline-flex items-center">
                                <input 
                                    type="radio" 
                                    class="form-radio text-orange-600 h-4 w-4" 
                                    name="Properties[transaction_status_id]" 
                                    value="<?= $id ?>" 
                                    <?= $model->transaction_status_id == $id ? 'checked' : '' ?>>
                                <span class="ml-2 text-sm text-gray-700"><?= htmlspecialchars($name) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div>
                        <h3 class="text-md font-semibold text-gray-800 mb-3">Ghi Chú</h3>
                        <?= $form->field($model, 'transaction_description')->textarea([
                            'rows' => 6,
                            'placeholder' => 'Nhập Thông Tin Mô Tả',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                        ])->label(false) ?>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mt-3 mb-2">Nếu bạn có thông tin liên hệ chủ nhà thì hãy điền vào đây.</p>
                    <?= Html::a('<i class="fas fa-address-book "></i> Tạo Liên Hệ', 'javascript:void(0)', [
                        'id'=> 'add-contact-button',
                        'class' => 'bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded mb-4 inline-block'
                    ]) ?>
                    <br>
                    <div id="contacts-table-wrapper">
                        <?php if (!empty($model->ownerContacts)): ?>
                            <?= $this->render('/owner-contact/_table', ['contacts' => $model->ownerContacts]) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    
    <?= $this->render('_upload', [
        'model' => $model,
    ]) ?>

    <div id="contact-modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Thêm Thông Tin Liên Hệ</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="contact-role" class="block text-sm font-medium text-gray-700 mb-1">Vai Trò</label>
                    <select id="contact-role" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                    <option value="">Chọn Vai Trò</option>
                        <option value="0">Không xác định</option>
                        <option value="1">Chủ nhà</option>
                        <option value="2">Độc Quyền</option>
                        <option value="3">Môi Giới Hợp Tác</option>
                        <option value="4">Người Thân Chủ Nhà</option>
                        <option value="5">Trợ Lý Chủ Nhà</option>
                        <option value="6">Đại Diện Công Ty</option>
                        <option value="7">Đại Diện Chủ Nhà</option>
                        <option value="8">Đầu Tư</option>
                    </select>
                </div>
                <div>
                    <label for="contact-name" class="block text-sm font-medium text-gray-700 mb-1">Tên</label>
                    <input type="text" id="contact-name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                </div>
                <div>
                    <label for="contact-phone" class="block text-sm font-medium text-gray-700 mb-1">Điện thoại</label>
                    <input type="text" id="contact-phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                </div>
                <div>
                    <label for="contact-gender" class="block text-sm font-medium text-gray-700 mb-1">Giới tính</label>
                    <select id="contact-gender" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        <option >Chọn Giới tính</option>
                        <option value="1">Nam</option>
                        <option value="2">Nữ</option>
                        <option value="0">Khác</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end mt-6 space-x-2">
                <button id="save-contact-button" class="px-4 py-2 bg-orange-600 text-white rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Lưu</button>
                <button id="cancel-contact-button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Hủy</button>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const thongTinTab = document.getElementById('thong-tin-tab');
        const soHongTab = document.getElementById('so-hong-tab');
        const thongTinContent = document.getElementById('thong-tin-content');
        const soHongContent = document.getElementById('so-hong-content');


        const addContactButton = document.getElementById('add-contact-button');
        const contactModal = document.getElementById('contact-modal');
        const closeButton = contactModal.querySelector('.close-button');
        const saveContactButton = document.getElementById('save-contact-button');
        const cancelContactButton = document.getElementById('cancel-contact-button');
        const contactEntriesDiv = document.getElementById('contact-entries');

        const rentalCheckbox = document.getElementById('has_rental_contract');
        const rentalDetailsContainer = document.getElementById('rental-details-container');

        const priceInput = document.getElementById('price');
        const priceDisplay = document.getElementById('price-display');
        const rentPriceDisplay = document.getElementById('rent-price-display');

        function formatVNCurrency(number) {
            if (isNaN(number) || number <= 0) {
                return '';
            }
            if (number >= 1000000000) {
                const value = (number / 1000000000).toFixed(2).replace(/\.00$/, '').replace(/\.([1-9])0$/, '.$1');
                return value + ' tỷ';
            }
            if (number >= 1000000) {
                const value = (number / 1000000).toFixed(2).replace(/\.00$/, '').replace(/\.([1-9])0$/, '.$1');
                return value + ' triệu';
            }
            return new Intl.NumberFormat('vi-VN').format(number) + ' đ';
        }

        function setupPriceFormatting(inputId, displayId) {
            const inputElement = document.getElementById(inputId);
            const displayElement = document.getElementById(displayId);

            if (inputElement && displayElement) {
                inputElement.addEventListener('input', function() {
                    const rawValue = this.value.replace(/,/g, '');
                    const numberValue = parseFloat(rawValue);
                    
                    const formattedText = formatVNCurrency(numberValue);

                    if (formattedText) {
                        displayElement.textContent = formattedText;
                        displayElement.classList.remove('hidden');
                    } else {
                        displayElement.textContent = '';
                        displayElement.classList.add('hidden');
                    }
                });

                inputElement.dispatchEvent(new Event('input'));
            }
        }

        setupPriceFormatting('price', 'price-display');
        setupPriceFormatting('final_price', 'final-price-display');
        setupPriceFormatting('rent-price', 'rent-price-display');

        if (rentalCheckbox && rentalDetailsContainer) {
            function toggleRentalDetails() {
                if (rentalCheckbox.checked) {
                    rentalDetailsContainer.classList.remove('hidden');
                } else {
                    rentalDetailsContainer.classList.add('hidden');
                }
            }

            rentalCheckbox.addEventListener('change', toggleRentalDetails);
            toggleRentalDetails(); 
        }

         thongTinTab.addEventListener('click', function() {
                activateTab(thongTinTab, thongTinContent);
            });

            soHongTab.addEventListener('click', function() {
                activateTab(soHongTab, soHongContent);
            });

            addContactButton.addEventListener('click', function() {
                contactModal.style.display = 'flex';
                $("#save-contact-button").data("id", '');
            });

            closeButton.addEventListener('click', function() {
                contactModal.style.display = 'none';
                document.getElementById('contact-name').value = '';
                document.getElementById('contact-phone').value = '';
                document.getElementById('contact-role').selectedIndex = 0;
                document.getElementById('contact-gender').selectedIndex = 0;
            });

            cancelContactButton.addEventListener('click', function() {
                contactModal.style.display = 'none';
                document.getElementById('contact-name').value = '';
                document.getElementById('contact-phone').value = '';
                document.getElementById('contact-role').selectedIndex = 0;
                document.getElementById('contact-gender').selectedIndex = 0;
            });

            window.addEventListener('click', function(event) {
                if (event.target == contactModal) {
                    contactModal.style.display = 'none';
                }
            });

    
        function activateTab(tabButton, contentDiv) {
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
            document.querySelectorAll('nav button').forEach(button => {
                button.classList.remove('text-orange-600', 'border-orange-600');
                button.classList.add('text-gray-600', 'hover:text-orange-600', 'hover:border-orange-600');
            });
    
            tabButton.classList.add('text-orange-600', 'border-b-2', 'border-orange-600');
            tabButton.classList.remove('text-gray-600', 'hover:text-orange-600', 'hover:border-orange-600');
            contentDiv.classList.remove('hidden');
        }
    
        thongTinTab.addEventListener('click', function() {
            activateTab(thongTinTab, thongTinContent);
        });
    
        soHongTab.addEventListener('click', function() {
            activateTab(soHongTab, soHongContent);
        });
    
        activateTab(thongTinTab, thongTinContent);


        // handler button Vị trí BDS
        const buttons = document.querySelectorAll('#location-type-buttons .location-btn');
        const hiddenInput = document.getElementById('location_type_id');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {

                buttons.forEach(b => {
                    b.classList.remove('bg-orange-100', 'text-orange-700');
                    b.classList.add('bg-gray-100', 'text-gray-700');
                });


                btn.classList.remove('bg-gray-100', 'text-gray-700');
                btn.classList.add('bg-orange-100', 'text-orange-700');

                // Gán giá trị vào input ẩn
                hiddenInput.value = btn.dataset.value;
            });
        });

        // Gán nút active khi đã có giá trị sẵn từ model
        const currentVal = hiddenInput.value;
        if (currentVal) {
            const activeBtn = [...buttons].find(b => b.dataset.value === currentVal);
            if (activeBtn) activeBtn.click();
        }
    });

    function submitPropertyForm() {
        const form = document.getElementById('property');
        if (form) {
            form.submit();
        }
    }

    document.getElementById('save-contact-button').addEventListener('click', function () {
        const role = document.getElementById('contact-role').value;
        const name = document.getElementById('contact-name').value;
        const phone = document.getElementById('contact-phone').value;
        const gender = document.getElementById('contact-gender').value;
        const propertyId = document.getElementById('properties-property_id').value;
        const contactId = $("#save-contact-button").data("id");
        
        let url = '/owner-contact/create-ajax';
        if (contactId != '') {
            url = '/owner-contact/update-contact';
        }

        if (!name || !phone || role === 'Chọn Vai Trò' || gender === 'Chọn Giới tính') {
            alert('Vui lòng điền đầy đủ thông tin.');
            return;
        }

        const postData = {
            role: role,
            name: name,
            phone: phone,
            gender: gender,
            propertyId: propertyId
        };
        if (contactId != '') {
            postData.id = contactId;
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': yii.getCsrfToken()
            },
            body: JSON.stringify(postData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('contacts-table-wrapper').innerHTML = '';
                document.getElementById('contacts-table-wrapper').innerHTML =  data.data;
                document.getElementById('contact-modal').style.display = 'none';
                document.getElementById('contact-name').value = '';
                document.getElementById('contact-phone').value = '';
                document.getElementById('contact-role').selectedIndex = 0;
                document.getElementById('contact-gender').selectedIndex = 0;
            } else {
                let errorMessages = [];

                if (data.errors) {
                    for (const field in data.errors) {
                        if (Array.isArray(data.errors[field])) {
                            errorMessages.push(...data.errors[field]);
                        } else {
                            errorMessages.push(data.errors[field]);
                        }
                    }
                }

                alert('Lỗi:\n' + errorMessages.join('\n'));
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Lỗi kết nối máy chủ.');
        });
    });
</script>

<?php
$script = <<< JS
$('#properties-city').on('change', function() {
    var provinceId = $(this).val();
    $.ajax({
        url: '/address/districts',
        type: 'GET',
        data: { ProvinceId: provinceId },
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': yii.getCsrfToken()
        },
        success: function(data) {
            $('select[name="Properties[district_county]"]').html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});
$(document).on('click', '.btn-update-contact', function() {
    var contactId = $(this).data("id");
    var url = $(this).data("url");
    $.ajax({
        url: url,
        type: "GET",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': yii.getCsrfToken()
        },
        success: function(data) {
            if (data.success) {
                $("#contact-role").val(data.contact.role_id || "");
                $("#contact-name").val(data.contact.contact_name || "");
                $("#contact-phone").val(data.contact.phone_number || "");
                $("#contact-gender").val(data.contact.gender_id || "");
                $("#contact-modal").css("display", "flex");
                $("#save-contact-button").data("id", contactId);
            } else {
                alert("Không thể tải dữ liệu liên hệ: " + data.message);
            }
        },
        error: function(xhr) {
            alert("Lỗi khi tải dữ liệu: " + xhr.responseText);
        }
    });
});

$(document).on('click', '.btn-delete-contact', function() {
    const contactId = $(this).data('id');
    const url = $(this).data('url');

    if (!confirm('Bạn có chắc chắn muốn xóa liên hệ này?')) {
        return;
    }

    $.ajax({
        url: url,
        type: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': yii.getCsrfToken()
        },
        data: JSON.stringify({ id: contactId }),
        success: function(data) {
            if (data.success) {
                $("#contacts-table-wrapper").html('');
                $("#contacts-table-wrapper").html(data.data);
                $("#save-contact-button").data("id", '');
            } else {
                alert("Không thể tải dữ liệu liên hệ: " + data.message);
            }
        },
        error: function(xhr) {
            console.error('AJAX error:', xhr.status, xhr.responseText);
            alert('Lỗi khi xóa liên hệ: ' + xhr.responseText);
        }
    });
});
JS;
$this->registerJs($script);
?>


<?php
$script = <<< JS
$('#properties-district_county').on('change', function() {
    var districtId = $(this).val();
    $.ajax({
        url: '/address/wards',
        type: 'GET',
        data: { DistrictId: districtId },
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': yii.getCsrfToken()
        },
        success: function(data) {
            $('select[name="Properties[ward_commune]"]').html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});
JS;
$this->registerJs($script);
?>

