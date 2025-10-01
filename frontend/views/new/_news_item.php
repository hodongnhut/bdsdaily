<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
/** @var app\models\News $model */

$images = [
    '../img/slider1.webp',
    '../img/slider2.webp',
    '../img/slider3.webp',
    '../img/slider4.webp',
];
$randomImage = $images[array_rand($images)];
?>

<article class="blog_item">
    <div class="blog_item_img">
        <img class="card-img rounded-0" loading="lazy" src="<?= $randomImage ?>"
            alt="<?= Html::encode($model->title) ?>">
        <a href="<?= Yii::$app->urlManager->createUrl([$model->slug.'-tin-tuc.html']) ?>" class="blog_item_date">
            <h3><?= date('d', strtotime($model->created_at)) ?></h3>
            <p><?= date('M', strtotime($model->created_at)) ?></p>
        </a>
    </div>
    <div class="blog_details">
        <a class="d-inline-block"
            href="<?= Yii::$app->urlManager->createUrl([$model->slug.'-tin-tuc.html']) ?>">
            <h2><?= Html::encode($model->title) ?></h2>
        </a>
        <p><?= HtmlPurifier::process($model->description) ?></p>
        <ul class="blog-info-link">
            <li><a href="#"><i class="far fa-user"></i> <?= Html::encode($model->author) ?></a></li>
            <li><a href="#"><i class="far fa-comments"></i> <?= rand(1, 10) ?> bình luận</a></li>
        </ul>
    </div>
</article>