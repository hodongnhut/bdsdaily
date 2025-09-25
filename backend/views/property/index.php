<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\helpers\HtmlLogHelper;
use common\models\PropertyImages;
use common\helpers\FavoriteHelper;

$this->title = 'Dữ Liệu Nhà Đất';
$this->params['breadcrumbs'][] = $this->title;
$csrfToken = Yii::$app->request->getCsrfToken();

use common\widgets\CustomLinkPager;

$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', [
    'depends' => [JqueryAsset::class],
    'position' => \yii\web\View::POS_HEAD,
]);
$this->registerCssFile('/css/animate.css', [
    'rel' => 'stylesheet',
]);

$this->registerCssFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', [
    'position' => \yii\web\View::POS_HEAD,
]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', [
    'depends' => [\yii\web\JqueryAsset::class],
    'position' => \yii\web\View::POS_END,
]);
?>

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

<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">
        <div class="flex space-x-2">
            <a href="<?= Url::to(['/property']) ?>" class="px-4 py-2 rounded-lg bg-white text-blue-600 shadow-md flex items-center space-x-1.5 text-sm">
                <i class="fas fa-database fa-sm"></i>
                <span>Dữ Liệu Nhà Đất</span>
            </a>
        </div>
    </div>
    <div class="relative flex items-center space-x-4">
        <div class="flex space-x-2">
            <button id="openDialog" class="px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white shadow-md flex items-center space-x-1.5 text-sm transition-colors duration-200">
                <i class="fas fa-plus fa-sm mr-1"></i>
                <span>TẠO MỚI</span>
            </button>
        </div>
        <button
            id="userMenuButton"
            class="w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-md transition-colors duration-200"
            aria-haspopup="true"
            aria-expanded="false">
            <i class="fas fa-user"></i>
        </button>
        <div
            id="userMenu"
            class="absolute right-0 mt-20 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-10 hidden"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="userMenuButton">
            <a href="<?= Url::to(['/login-version']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Phiên Đăng Nhập</a>
            <a href="<?= Url::to(['/change-password']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đổi Mật Khẩu</a>
            <?= Html::a('Đăng Xuất', ['/site/logout'], [
                'data-method' => 'post',
                'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100',
                'role' => 'menuitem'
            ]) ?>
        </div>
    </div>
</header>
<main class="flex-1 p-2 overflow-auto">
    <?php
    echo $this->render('_search', [
        'model' => $searchModel,
        'listingTypes' => $modelListingTypes,
        'locationTypes' => $modelLocationTypes,
        'propertyTypes' => $modelPropertyTypes,
        'assetTypes' => $modelAssetTypes,
        'advantages' => $modelAdvantages,
        'disadvantages' => $modelDisadvantages,
        'directions' => $modelDirections,
        'modelProvinces' => $modelProvinces,
        'modelDistricts' => $modelDistricts,

    ]);
    ?>

    <?php

    $columns = [
        [
            'class' => 'yii\grid\DataColumn',
            'label' => '#',
            'contentOptions' => ['class' => 'w-[50px] py-4 whitespace-nowrap text-sm font-medium text-gray-900'],
            'headerOptions' => ['class' => 'w-[50px] py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider  bg-yellow-500 hover:bg-yellow-600 text-white'],
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) use ($dataProvider) {
                $pagination = $dataProvider->getPagination();
                $page = $pagination->getPage();
                $pageSize = $pagination->pageSize;
                $rowNumber = $index + 1 + ($page * $pageSize);
                return Html::tag('div', $rowNumber, ['class' => 'flex items-center space-x-2']);
            },
        ],
        [
            'label' => 'Thông Tin',
            'contentOptions' => ['class' => 'w-[164px] px-6 py-4 text-sm text-gray-900 md:hidden'],
            'headerOptions' => ['class' => 'w-[170px] px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-500 hover:bg-yellow-600 text-white md:hidden'],
            'format' => 'raw',
            'value' => function ($model) {
                $price = HtmlLogHelper::formatPriceUnit($model->price);
                $dimensions = ($model->area_width && $model->area_length)
                    ? "({$model->area_width}m × {$model->area_length}m)"
                    : '';
                $area = Html::tag('div', $model->area_total . ' m2', ['class' => 'font-semibold']) .
                    Html::tag('div', $dimensions, ['class' => 'text-xs text-gray-600']);
                $floors = !empty($model->num_floors) ? $model->num_floors . ' tầng' : 'N/A';
                $listingType = $model->listingType ? Html::encode($model->listingType->name) : 'N/A';
                $propertyType = $model->propertyType ? Html::encode($model->propertyType->type_name) : 'N/A';
                $rentalPrice = $model->rentalContract
                    ? number_format($model->rentalContract->rent_price / 1e6) . ' Triệu' .
                    ($model->rentalContract->currency ? ' ' . $model->rentalContract->currency->code : '') .
                    ($model->rentalContract->price_time_unit === 'per_month' ? '/Tháng' : '/Năm')
                    : 'N/A';
                $status = $model->transactionStatus ? Html::encode($model->transactionStatus->status_name) : 'N/A';
                $updatedAt = Yii::$app->formatter->asRelativeTime($model->updated_at);

                $imageHtml = '';
                $redBook = '';

                if (!empty($model->propertyImages)) {
                    $icon = Html::tag('i', '', ['class' => 'fas fa-images text-lg']);
                    $imageIcon = Html::tag('div', $icon, [
                        'class' => 'bg-blue-600 text-white p-1 h-7 w-7 rounded-md flex items-center justify-center',
                        'title' => count($model->propertyImages) . ' hình ảnh',
                    ]);

                    $mainImage = PropertyImages::getMainImage($model->property_id);
                    if ($mainImage && $mainImage->image_type == 1) {
                        $redBook = Html::img(Url::to(['img/so-hong2.webp']), [
                            'class' => 'h-7 w-7 object-cover rounded-md',
                            'alt' => 'Main Property Image',
                        ]);
                    }

                    $imageHtml = Html::tag('div', $imageIcon . $redBook, [
                        'class' => 'flex items-center space-x-1',
                    ]);
                }

                $iconPhone = '';
                if (!empty($model->ownerContacts)) {
                    $iconPhone = Html::tag('i', '', ['class' => 'fas fa-phone text-red-500']);
                }

                $summary = Html::tag('div', "Địa chỉ: $model->title", ['class' => 'text-sm font-semibold']);
                $summary .= Html::tag('div', "Giá tiền: $price", ['class' => 'text-sm text-gray-600']);
                $summary .= Html::tag('div', "Diện Tích: $area", ['class' => 'text-sm text-gray-600']);
                $summary .= Html::tag('div', "Kết Cấu: $floors", ['class' => 'text-sm text-gray-600']);
                $summary .= Html::tag('div', "Loại: $listingType", ['class' => 'text-sm text-gray-600']);
                $summary .= Html::tag('div', "Hạng Mục: $propertyType", ['class' => 'text-sm text-gray-600']);
                $summary .= Html::tag('div', "HĐ Thuê: $rentalPrice", ['class' => 'text-sm text-gray-600']);
                $summary .= Html::tag('div', "Trạng Thái: $status", ['class' => 'text-sm text-gray-600']);
                $summary .= Html::tag('div', "Cập Nhật: $updatedAt", ['class' => 'text-sm text-gray-500']);

                return Html::tag('div', $summary . $imageHtml . $iconPhone, ['class' => 'space-y-1']);
            },
        ],
        [
            'attribute' => 'title',
            'label' => '#',
            'contentOptions' => ['class' => 'w-[90px] px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell'],
            'headerOptions' => ['class' => 'w-[90px] px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-500 hover:bg-yellow-600 text-white hidden md:table-cell'],
            'format' => 'raw',
            'value' => function ($model) {
                // Process title for house number fallback
                $processedTitle = !empty($model->title) ? trim(explode(',', $model->title)[0]) : '';

                // Listing type
                $listingType = $model->listingType ? Html::encode($model->listingType->name) : '';
                $listingTypeHtml = $listingType ? Html::tag('div', $listingType, ['class' => 'font-semibold']) : '';

                // Property type
                $propertyType = $model->propertyType ? Html::encode($model->propertyType->type_name) : '';
                $propertyTypeHtml = $propertyType ? Html::tag('div', $propertyType, ['class' => 'text-xs text-gray-600']) : '';

                // Image indicator
                $imageHtml = '';
                $redBook = '';
                $iconPhone = '';

                $iconInOut = ' ';
                if (Yii::$app->user->identity->jobTitle->role_code == 'super_admin' && !empty($model->external_id)) {
                    $iconInOut = ' ' . Html::tag('i', '', ['class' => 'fas fa-upload text-blue-500']);
                }

                if (!empty($model->propertyImages)) {
                    $icon = Html::tag('i', '', ['class' => 'fas fa-images text-lg']);
                    $imageIcon = Html::tag('div', $icon, [
                        'class' => 'bg-blue-600 text-white p-1 h-7 w-7 rounded-md flex items-center justify-center',
                        'title' => count($model->propertyImages) . ' hình ảnh',
                    ]);

                    $mainImage = PropertyImages::getMainImage($model->property_id);
                    if ($mainImage && $mainImage->image_type == 1) {
                        $redBook = Html::img(Url::to(['img/so-hong2.webp']), [
                            'class' => 'h-7 w-7 object-cover rounded-md',
                            'alt' => 'Main Property Image',
                        ]);
                    }

                    $imageHtml = Html::tag('div', $imageIcon . $redBook, [
                        'class' => 'flex items-center space-x-1',
                    ]);
                }
                if (!empty($model->ownerContacts)) {
                    $iconPhone = Html::tag('i', '', ['class' => 'fas fa-phone text-red-500']);
                }

                return $listingTypeHtml . $propertyTypeHtml . $imageHtml . $iconPhone . $iconInOut;
            },
        ],
        [
            'attribute' => 'title',
            'label' => 'Số Nhà',
            'contentOptions' => ['class' => 'w-[120px] px-6 py-4 text-sm text-gray-900 hidden md:table-cell'],
            'headerOptions' => ['class' => 'w-[120px] px-6 py-3 text-left text-xs font-medium text-gray-500 capitalize tracking-wider bg-yellow-500 hover:bg-yellow-600 text-white hidden md:table-cell'],
            'format' => 'raw',
            'value' => function ($model) {
                $processedTitle = !empty($model->title) ? trim(explode(',', $model->title)[0]) : '';

                $houseNumber = !empty($model->house_number) ? Html::encode($model->house_number) : $processedTitle;
                $houseNumberHtml = $houseNumber ? Html::tag('div', $houseNumber) : '';

                $plotNumberHtml = !empty($model->plot_number) ? Html::tag('div', 'Thửa: ' . Html::encode($model->plot_number)) : '';
                $sheetNumberHtml = !empty($model->sheet_number) ? Html::tag('div', 'Tờ: ' . Html::encode($model->sheet_number)) : '';

                return $houseNumberHtml . $plotNumberHtml . $sheetNumberHtml;
            },
        ],
        [
            'attribute' => 'street_name',
            'label' => 'Đường',
            'contentOptions' => ['class' => 'w-[135px] px-6 py-4 text-sm text-gray-900 hidden md:table-cell'],
            'headerOptions' => [
                'class' => 'w-[135px] px-6 py-3 text-left text-xs font-medium text-gray-500 capitalize tracking-wider  bg-yellow-500 hover:bg-yellow-600 text-white hidden md:table-cell text-[10px]',
                'title' => 'Đường Phố'
            ],
            'format' => 'raw',
            'value' => function ($model) {

                $displayStreet = $model->street_name;
                if (empty($displayStreet)) {
                    if ($model->title && strpos($model->title, ',') !== false) {
                        $parts = explode(',', $model->title);
                        if (isset($parts[1])) {
                            $displayStreet = trim($parts[1]);
                        }
                    }
                }

                $localtionType = $model->locationType ? Html::tag('span', $model->locationType->type_name, [
                    'class' => 'text-xs font-medium px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-800',
                ]) : " ";

                $treet = Html::tag('div', $displayStreet, ['class' => 'font-semibold']);
                return $localtionType . $treet;
            },
        ],
        [
            'attribute' => 'district_county',
            'label' => 'Quận/Huyện',
            'contentOptions' => ['class' => 'w-[130px] px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell'],
            'headerOptions' => [
                'class' => 'w-[130px] px-6 py-3 text-left text-xs font-medium text-gray-500 capitalize tracking-wider  bg-yellow-500 hover:bg-yellow-600 text-white hidden md:table-cell text-[10px]',
                'title' => 'Quận/Huyện'
            ],
            'format' => 'raw',
            'value' => function ($model) {
                $new_district = $model->new_district
                    ? Html::tag('div', $model->new_district, ['class' => 'capitalize text-xs font-medium px-2.5 py-0.5 rounded-full bg-green-100 text-green-800 '])
                    : '';
                $districtCounty = $model->district_county;
                if (!empty($districtCounty)) {
                    $parts = explode(',', $districtCounty);
                    if (isset($parts[1])) {
                        return trim($parts[1]) . $new_district;
                    }
                    return trim($parts[0]) . $new_district;
                }

                $wardCommune = $model->ward_commune;
                if (!empty($wardCommune)) {
                    $parts = explode(',', $wardCommune);

                    if (isset($parts[1])) {
                        return trim($parts[1]) . $new_district;
                    }
                }

                return $new_district;
            },
        ],
        [
            'label' => 'Giá',
            'contentOptions' => ['class' => 'w-[95px] px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell'],
            'headerOptions' => ['class' => 'w-[95px] px-6 py-3 text-left text-xs font-medium text-gray-500 capitalize tracking-wider  bg-yellow-500 hover:bg-yellow-600 text-white hidden md:table-cell text-[10px]'],
            'format' => 'raw',
            'value' => function ($model) {
                $price = $model->price;
                if ($model->final_price > 0  && $model->final_price != $model->price) {
                    $price = $model->final_price;
                }
                $priceDisplay = HtmlLogHelper::formatPriceUnit($price);
                $pricePerM2 = (!empty($model->area_total) && $model->area_total > 0)
                    ? number_format($price / $model->area_total / 1e6, 0) . ' Triệu/m2'
                    : '-';

                return Html::tag('div', $priceDisplay, ['class' => 'font-semibold text-red-600']) .
                    Html::tag('div', '~' . $pricePerM2, ['class' => 'text-xs text-gray-600']);
            },
        ],
        [
            'attribute' => 'area_total',
            'label' => 'Diện Tích',
            'contentOptions' => ['class' => 'w-[80px] px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell'],
            'headerOptions' => ['class' => 'w-[80px] px-6 py-3 text-left text-xs font-medium text-gray-500 capitalize tracking-wider  bg-yellow-500 hover:bg-yellow-600 text-white hidden md:table-cell text-[10px]'],
            'format' => 'raw',
            'value' => function ($model) {
                $width  = HtmlLogHelper::formatNumber($model->area_width);
                $length = HtmlLogHelper::formatNumber($model->area_length);
                $dimensions = ($model->area_width && $model->area_length)
                    ? "({$width}m × {$length}m)"
                    : '';
                return Html::tag('div', HtmlLogHelper::formatNumber($model->area_total) . ' m2', ['class' => 'font-semibold']) .
                    Html::tag('div', $dimensions, ['class' => 'text-xs text-gray-600']);
            },
        ],
        [
            'label' => 'Thông Tin',
            'contentOptions' => ['class' => 'w-[100px] px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell'],
            'headerOptions' => ['class' => 'w-[100px] px-6 py-3 text-left text-sm font-medium text-gray-500 capitalize tracking-wider  bg-yellow-500 hover:bg-yellow-600 text-white hidden md:table-cell text-[10px]'],
            'format' => 'raw',
            'value' => function ($model) {

                $numFloors = '';
                if ($model->num_floors > 0) {
                    $numFloors = $model->num_floors . ' tầng';
                }

                if ($model->rentalContract) {
                    $contract = $model->rentalContract;

                    $priceText = number_format($contract->rent_price / 1e6) . ' Triệu';
                    if ($contract->currency) {
                        $priceText .= ' ' . $contract->currency->code;
                    }

                    $timeUnitText = '';
                    if ($contract->price_time_unit === 'per_month') {
                        $timeUnitText = '/Tháng';
                    } elseif ($contract->price_time_unit === 'per_year') {
                        $timeUnitText = '/Năm';
                    }


                    $priceHtml = 'HĐT: </br>' . Html::tag('div', $priceText, ['class' => 'text-xs text-red-300']);
                    $unitHtml = Html::tag('div', $timeUnitText, ['class' => 'text-xs text-gray-300 ']);
                    return $priceHtml . $unitHtml . $numFloors;
                }

                return $numFloors;
            },
        ],
        [
            'label' => 'Lưu',
            'contentOptions' => ['class' => 'w-[60px] px-6 py-4  text-sm text-gray-900'],
            'headerOptions' => ['class' => 'w-[60px] px-6 py-3 text-left text-xs font-medium text-gray-500 capitalize tracking-wider  bg-yellow-500 hover:bg-yellow-600 text-white'],
            'format' => 'raw',
            'value' => function ($model) {
                $propertyId = $model->property_id;
                $isFavorited = FavoriteHelper::isPropertyFavorited($propertyId);

                $iconClass = $isFavorited ? 'fas fa-heart text-red-500' : 'far fa-heart text-gray-400';
                $title = $isFavorited ? 'Bỏ lưu' : 'Lưu';
                $dataAttributes = [
                    'data-property-id' => $propertyId,
                    'data-favorited' => (int)$isFavorited,
                    'data-url' => Url::to(['/property/toggle-favorite']),
                ];

                return Html::tag('span', Html::tag('i', '', ['class' => $iconClass]), [
                    'class' => 'favorite-toggle cursor-pointer',
                    'title' => $title,
                ] + $dataAttributes);
            },
        ],
        [
            'attribute' => 'transaction_status_id',
            'label' => 'Cập nhật',
            'contentOptions' => ['class' => 'w-[90px] px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell'],
            'headerOptions' => ['class' => 'w-[90px] px-6 py-3 text-left text-xs font-medium text-gray-500 capitalize tracking-wider  bg-yellow-500 hover:bg-yellow-600 text-white'],
            'format' => 'raw',
            'value' => function ($model) {
                if (!$model->transactionStatus || $model->transactionStatus->transaction_status_id === 0) {
                    $statusBadge = '';
                } else {
                    $statusBadge = $model->transactionStatus ? Html::tag('span', $model->transactionStatus->status_name, [
                        'class' => 'text-xs font-medium px-2.5 py-0.5 rounded-full ' . $model->transactionStatus->class_css,
                    ]) : " ";
                }
                $relativeTime = Yii::$app->formatter->asRelativeTime($model->updated_at);
                $updateTimeDiv = Html::tag('div', $relativeTime, ['class' => 'text-xs text-gray-500 mt-1']);
                $editButton = $model->is_new ?? false ? Html::a(
                    '<i class="fas fa-pencil-alt mr-1"></i>Sản Phẩm Mới',
                    ['update', 'property_id' => $model->property_id],
                    ['class' => 'mt-2 text-blue-600 hover:text-blue-800 text-xs flex items-center']
                ) : '';
                return $statusBadge . $updateTimeDiv . $editButton;
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
            'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 capitalize tracking-wider  bg-yellow-500 hover:bg-yellow-600 text-white'],
            'urlCreator' => function ($action, $model, $key, $index, $column) {
                return Url::toRoute([$action, 'property_id' => $model->property_id]);
            },
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<i class="fas fa-eye"></i>', $url, [
                        'class' => 'text-blue-600 hover:text-blue-800 mx-1',
                        'title' => 'Xem',
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                        'class' => 'text-blue-600 hover:text-blue-800 mx-1',
                        'title' => 'Cập Nhật',
                    ]);
                },
                'delete' => function ($url, $model) {
                    if (Yii::$app->user->identity->jobTitle->role_code === 'manager' ||  Yii::$app->user->identity->jobTitle->role_code == 'super_admin') {
                        return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                            'class' => 'text-blue-600 hover:text-blue-800 mx-1',
                            'title' => 'Xóa',
                            'data' => [
                                'confirm' => 'Bạn có chắc chắn muốn xóa bài viết này?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                    return '';
                },
            ],
        ],
    ];

    if (in_array(Yii::$app->user->identity->jobTitle->role_code ?? '', ['manager', 'super_admin'])) {
        $columns[] = [
            'attribute' => 'status_review',
            'label' => 'Duyệt Tin',
            'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell'],
            'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 capitalize tracking-wider bg-yellow-500 hover:bg-yellow-600 text-white'],
            'format' => 'raw',
            'value' => function ($model) {
                $status = $model->status_review ?? 0;
                $statusMap = [
                    0 => ['text' => 'Chờ duyệt', 'class' => 'bg-yellow-100 text-yellow-800'],
                    1 => ['text' => 'Đã duyệt', 'class' => 'bg-green-100 text-green-800'],
                ];

                $statusInfo = $statusMap[$status] ?? ['text' => 'Chưa xác định', 'class' => 'bg-gray-100 text-gray-800'];
                $statusBadge = Html::tag('span', $statusInfo['text'], options: [
                    'class' => 'text-xs font-medium px-2.5 py-0.5 rounded-full ' . $statusInfo['class'],
                ]);

                $buttons = '';
                if ($status == 0) {
                    $buttons = Html::a('<i class="fas fa-check"></i> Vào Duyệt', ['property/update', 'property_id' => $model->property_id], [
                        'class' => 'text-green-600 hover:text-green-800 mx-1',
                        'title' => 'Duyệt bài'
                    ]);
                }

                return $statusBadge . Html::tag('div', $buttons, ['class' => 'mt-1']);
            },
        ];
    }

    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n",
        'summaryOptions' => [
            'class' => 'text-sm text-gray-700',
            'id' => 'DataTables_Table_0_info',
        ],
        'summary' => 'Hiển thị từ {begin} đến {end} trong tổng số {totalCount} mục',
        'tableOptions' => [
            'class' => 'min-w-full divide-y divide-gray-200 table table-striped table-bordered table-fixed w-full',
        ],
        'headerRowOptions' => [
            'class' => 'shadow-md text-white ',
        ],
        'options' => [
            'class' => 'table-container bg-white rounded-lg shadow-md overflow-x-auto',
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            return [
                'class' => 'cursor-pointer hover:bg-gray-100',
                'onclick' => 'window.location.href="' . Url::to(['view', 'property_id' => $model->property_id]) . '"',
            ];
        },
        'columns' => $columns,
    ]);
    ?>

    <?= CustomLinkPager::widget([
        'pagination' => $dataProvider->pagination,
        'options' => ['class' => ''],
        'maxButtonCount' => 5,
        'firstPageLabel' => false,
        'lastPageLabel' => false,
        'prevPageLabel' => '<i class="fas fa-chevron-left"></i>',
        'nextPageLabel' => '<i class="fas fa-chevron-right"></i>',
    ]);
    ?>


    <div id="dialog" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto mx-4 my-2 sm:mx-6 sm:my-4">
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">DỮ LIỆU NHÀ ĐẤT</h2>
                <button id="cancelIcon" class="text-gray-500 hover:text-gray-700" type="button" aria-label="Close dialog">
                    <i class="fas fa-times-circle text-xl"></i>
                </button>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'property-form',
                'action' => ['property/create'],
                'method' => 'post',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'fieldConfig' => [
                    'errorOptions' => ['class' => 'text-red-500 text-sm mt-1'],
                ],
            ]); ?>

            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <?= $form->field($model, 'listing_types_id', [
                        'options' => ['class' => ''],
                    ])->radioList([
                        1 => 'Bán',
                        2 => 'Cho Thuê',
                    ], [
                        'item' => function ($index, $label, $name, $checked, $value) {
                            $check = $checked ? 'checked' : '';
                            return "<label class='inline-flex items-center space-x-2'>" .
                                "<input type='radio' class='form-radio text-blue-600' name='{$name}' value='{$value}' {$check}>" .
                                "<span class='text-gray-700 text-sm'>{$label}</span>" .
                                "</label>";
                        }
                    ])->label('<span class="text-red-500">*</span> Loại Giao Dịch', ['class' => 'text-sm font-medium text-gray-700']) ?>
                </div>

                <div>
                    <?= $form->field($model, 'property_type_id')->dropDownList(
                        ArrayHelper::map($modelPropertyTypes, 'property_type_id', 'type_name'),
                        [
                            'prompt' => 'Chọn Loại BĐS',
                            'class' => 'block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm'
                        ]
                    )->label('<span class="text-red-500">*</span> Loại BĐS', ['class' => 'text-sm font-medium text-gray-700']) ?>
                </div>

                <div>
                    <?= $form->field($model, 'provinces')->dropDownList(
                        ArrayHelper::map($modelProvinces, 'Name', 'Name'),
                        [
                            'prompt' => 'Chọn Tỉnh Thành',
                            'value' => 'Hồ Chí Minh',
                            'class' => 'block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm'
                        ]
                    )->label('<span class="text-red-500">*</span> Tỉnh Thành', ['class' => 'text-sm font-medium text-gray-700']) ?>
                </div>

                <div>
                    <?= $form->field($model, 'districts')->dropDownList(
                        ArrayHelper::map($modelDistricts, 'Name', 'Name'),
                        [
                            'prompt' => 'Chọn Quận Huyện...',
                            'class' => 'block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm'
                        ]
                    )->label('<span class="text-red-500">*</span> Quận Huyện', ['class' => 'text-sm font-medium text-gray-700']) ?>
                </div>

                <div>
                    <?= $form->field($model, 'wards')->dropDownList(
                        [],
                        [
                            'prompt' => 'Chọn Phường / Xã',
                            'class' => 'block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm'
                        ]
                    )->label('<span class="text-red-500">*</span> Phường / Xã', ['class' => 'text-sm font-medium text-gray-700']) ?>
                </div>

                <div>
                    <?= $form->field($model, 'streets')->dropDownList(
                        [],
                        [
                            'prompt' => 'Chọn Đường',
                            'class' => 'block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm js-select2',
                            'aria-required' => 'true',
                        ]
                    )->label('<span class="text-red-500">*</span> Đường', ['class' => 'text-sm font-medium text-gray-700']) ?>
                </div>

                <div>
                    <?= $form->field($model, 'house_number')->textInput([
                        'class' => 'block w-full rounded-md border-2 border-gray-400 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base p-2'
                    ])->label('<span class="text-red-500">*</span> Số Nhà', ['class' => 'text-base font-medium text-gray-700']) ?>
                </div>

                <div>
                    <?= $form->field($model, 'plot_number')->textInput([
                        'class' => 'block w-full rounded-md border-2 border-gray-400 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base p-2'
                    ])->label('Số Thửa', ['class' => 'text-base font-medium text-gray-700']) ?>
                </div>

                <div>
                    <?= $form->field($model, 'sheet_number')->textInput([
                        'class' => 'block w-full rounded-md border-2 border-gray-400 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base p-2'
                    ])->label('Số Tờ', ['class' => 'text-base font-medium text-gray-700']) ?>
                </div>

                <div>
                    <?= $form->field($model, 'lot_number')->textInput([
                        'class' => 'block w-full rounded-md border-2 border-gray-400 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base p-2'
                    ])->label('Số Lô', ['class' => 'text-base font-medium text-gray-700']) ?>
                </div>

                <div class="md:col-span-2">
                    <?= $form->field($model, 'region')->textInput([
                        'placeholder' => 'Ví dụ: CityLand, Trung Sơn, Cư Xá Phú Lâm...',
                        'class' => 'block w-full rounded-md border-2 border-gray-400 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base p-2'
                    ])->label('Khu Vực', ['class' => 'text-base font-medium text-gray-700']) ?>
                </div>
            </div>

            <div class="p-4 flex justify-center space-x-4 border-t">
                <?= Html::submitButton('<i class="fas fa-arrow-right mr-2"></i> TIẾP TỤC', ['id' => 'createButton', 'class' => 'bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md flex items-center text-sm']) ?>
                <?= Html::button('<i class="fas fa-times mr-2"></i> HỦY', ['id' => 'cancelButton', 'class' => 'bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md flex items-center text-sm']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <script>
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
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000
                    }
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
            }, {
                enableHighAccuracy: true,
                timeout: 10000
            }
        );

        $(window).scroll(function() {
            var window_top = $(window).scrollTop() + 1;
            var $tableContainer = $('.table-container');
            var $table = $tableContainer.find('table');
            var $thead = $tableContainer.find('thead');
            var headerHeight = $('header').outerHeight();

            if (window_top > headerHeight) {
                $table.removeClass('table-fixed');
                $thead.addClass('thead-fixed animated fadeInDown');
                $tableContainer.find('tbody').css('margin-top', $thead.outerHeight() + 'px');

                document.querySelectorAll("thead th").forEach((th, i) => {
                    let td = document.querySelector("tbody tr:first-child td:nth-child(" + (i + 1) + ")");
                    if (td) th.style.width = td.offsetWidth + "px";
                });
            } else {
                $table.addClass('table-fixed');
                $thead.removeClass('thead-fixed animated fadeInDown');
                $tableContainer.find('tbody').css('margin-top', '0');
            }
        });



        const openDialogButton = document.getElementById('openDialog');
        const dialog = document.getElementById('dialog');
        const cancelButton = document.getElementById('cancelButton');
        const cancelIcon = document.getElementById('cancelIcon');
        const createButton = document.getElementById('createButton');
        const inputField = document.getElementById('inputField');

        // Open dialog
        openDialogButton.addEventListener('click', () => {
            dialog.classList.remove('hidden');
        });

        // Close dialog on cancel
        cancelButton.addEventListener('click', () => {
            dialog.classList.add('hidden');
            inputField.value = ''; // Reset input
        });

        cancelIcon.addEventListener('click', () => {
            dialog.classList.add('hidden');
            inputField.value = ''; // Reset input
        });

        // Handle Tạo mới button click
        createButton.addEventListener('click', () => {
            const inputValue = inputField.value;
            if (inputValue.trim()) {
                alert(`Đã tạo mới với thông tin: ${inputValue}`);
                dialog.classList.add('hidden');
                inputField.value = ''; // Reset input
            } else {
                alert('Vui lòng nhập thông tin!');
            }
        });

        // Close dialog when clicking outside
        dialog.addEventListener('click', (e) => {
            if (e.target === dialog) {
                dialog.classList.add('hidden');
                inputField.value = ''; // Reset input
            }
        });
    </script>
</main>

<?php
$script = <<< JS
$('#propertiesfrom-provinces').on('change', function() {
    var provinceId = $(this).val();
    $.ajax({
        url: '/address/districts',
        type: 'GET',
        data: { ProvinceId: provinceId },
        headers: {
            'X-CSRF-Token': '$csrfToken'
        },
        success: function(data) {
            $('select[name="PropertiesFrom[districts]"]').html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});
JS;
$this->registerJs($script);
?>

<?php
$script = <<< JS
$('#propertiesfrom-districts').on('change', function() {
    var districtId = $(this).val();
    const wardDropdown = $('select[name="PropertiesFrom[wards]"]');
    var streetDropdown = $('select[name="PropertiesFrom[streets]"]');

    wardDropdown.html('<option value="">Chọn Phường / Xã</option>');
    streetDropdown.html('<option value="">Chọn Đường</option>');

    $.ajax({
        url: '/address/wards',
        type: 'GET',
        data: { DistrictId: districtId },
        headers: {
            'X-CSRF-Token': '$csrfToken'
        },
        success: function(data) {
            wardDropdown.html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
    $.ajax({
        url: '/address/streets',
        type: 'GET',
        data: { DistrictId: districtId },
        headers: {
            'X-CSRF-Token': '$csrfToken'
        },
        success: function(data) {
            streetDropdown.html(data);
            streetDropdown.select2({
                placeholder: 'Chọn Đường',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return 'Không tìm thấy đường';
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});
JS;
$this->registerJs($script);
?>
<?php
$script = <<<JS
$(document).on('click', '.favorite-toggle', function(event) {
    var \$this = \$(this);
    var propertyId = \$this.data('property-id');
    var isFavorited = \$this.data('favorited');
    var toggleUrl = \$this.data('url');

    \$this.addClass('opacity-50 cursor-not-allowed').prop('disabled', true);

    \$.ajax({
        url: toggleUrl,
        type: 'POST',
        data: {
            property_id: propertyId,
            _csrf: yii.getCsrfToken()
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var iconElement = \$this.find('i');
                if (response.status === 'added') {
                    iconElement.removeClass('far fa-heart text-gray-400').addClass('fas fa-heart text-red-500');
                    \$this.data('favorited', 1);
                    \$this.attr('title', 'Bỏ lưu');
                    console.log('Property added to favorites!');
                } else if (response.status === 'removed') {
                    iconElement.removeClass('fas fa-heart text-red-500').addClass('far fa-heart text-gray-400');
                    \$this.data('favorited', 0);
                    \$this.attr('title', 'Lưu');
                    console.log('Property removed from favorites!');
                }
            } else {
                console.error('Error toggling favorite:', response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
        },
        complete: function() {
            \$this.removeClass('opacity-50 cursor-not-allowed').prop('disabled', false);
        }
    });
});
JS;
$this->registerJs($script);
?>

<?php
$script = <<< JS
$('#propertiessearch-district_county').on('change', function() {
    var districtId = $(this).val();
    const wardDropdown = $('select[name="PropertiesSearch[ward_commune]"]');
    var streetDropdown = $('select[name="PropertiesSearch[street_name]"]');

    $.ajax({
        url: '/address/wards',
        type: 'GET',
        data: { DistrictId: districtId },
        headers: {
            'X-CSRF-Token': '$csrfToken'
        },
        success: function(data) {
            wardDropdown.html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
    $.ajax({
        url: '/address/streets',
        type: 'GET',
        data: { DistrictId: districtId },
        headers: {
            'X-CSRF-Token': '$csrfToken'
        },
        success: function(data) {
            streetDropdown.html(data);
            streetDropdown.select2({
                placeholder: 'Chọn Đường',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return 'Không tìm thấy đường';
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});
JS;
$this->registerJs($script);
?>