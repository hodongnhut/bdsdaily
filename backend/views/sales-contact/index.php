<?php

use common\models\SalesContact;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\widgets\CustomLinkPager;

/** @var yii\web\View $this */
/** @var common\models\SalesContactSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Email Khách Hàng';
?>


<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800"><?= Html::encode($this->title) ?></div>
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
        <p class="text-sm text-gray-500 mb-2">Màn hình chính /<?= Html::encode($this->title) ?></p>
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Danh Sách Email</h2>
            <?= Html::a('<i class="fas fa-plus mr-2"></i> Create Campaign', ['create'], ['class' => 'bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md flex items-center transition-colors duration-200']) ?>
        </div>

        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <br>
        <hr>
        <br>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'headerRowOptions' => ['class' => 'bg-gray-50'],
            'rowOptions' => ['class' => 'bg-white'],
            'layout' => "{items}\n",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'company_status',
                'email:email',
                [
                    'attribute' => 'phone',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $phone = $model->phone;
                        $zaloUrl = "https://zalo.me/0" . preg_replace('/\D/', '', $phone);
                
                        return '0'.Html::encode($phone) . ' ' .
                            Html::a(
                                Html::img('/img/zalo.png', [
                                    'alt' => 'Zalo',
                                    'class' => 'zalo-icon',
                                    'style' => 'width:20px;height:20px;vertical-align:middle;'
                                ]),
                                $zaloUrl,
                                ['class' => 'zalo-anchor', 'target' => '_blank', 'title' => 'Chat on Zalo']
                            );
                    },
                ],
                'address:ntext',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, SalesContact $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>
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
    </div>

</main>
