<?php

use common\models\NewsExtranaly;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\NewsExtranalySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'News Extranalies';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="blog_area section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="blog_left_sidebar">
                <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_news_item',
                'layout' => "{items}\n{pager}",
                'pager' => [
                    'options' => ['class' => 'pagination justify-content-center d-flex'],
                    'linkOptions' => ['class' => 'page-link'],
                    'activePageCssClass' => 'active', 
                    'prevPageLabel' => '<i class="ti-angle-left"></i>', 
                    'nextPageLabel' => '<i class="ti-angle-right"></i>',
                    'prevPageCssClass' => 'page-item',
                    'nextPageCssClass' => 'page-item', 
                    'disabledPageCssClass' => 'disabled',
                    'pageCssClass' => 'page-item', 
                ],
            ]); ?>


                </div>
            </div>
            <?= $this->render('_form') ?>
        </div>
    </div>     
</section>


