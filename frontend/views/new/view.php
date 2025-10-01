<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/** @var yii\web\View $this */
/** @var app\models\News $model */

$this->title = $model->title;

$this->registerMetaTag([
    'name' => 'robots',
    'content' => 'index, follow'
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model->keywords
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->description
]);

$images = [
    '../img/slider1.webp',
    '../img/slider2.webp',
    '../img/slider3.webp',
    '../img/slider4.webp',
];
$randomImage = $images[array_rand($images)];

?>
<!--================Blog Area =================-->
<section class="blog_area single-post-area section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts-list">
                <div class="single-post">
                    <div class="feature-img">
                        <img class="img-fluid" loading="lazy" src="<?= $randomImage ?>"
                            alt="<?= Html::encode($model->title) ?>">
                    </div>
                    <div class="blog_details">
                        <h2><?= Html::encode($this->title) ?></h2>
                        <ul class="blog-info-link mt-3 mb-4">
                            <li><a href="#"><i class="far fa-user"></i> <?= Html::encode($model->author) ?></a></li>
                            <li><a href="#"><i class="far fa-comments"></i> <?= rand(1, 10) ?> bình luận</a></li>
                        </ul>
                        <?= HtmlPurifier::process($model->content) ?>
                    </div>
                </div>
                <div class="navigation-top">
                    <div class="d-sm-flex justify-content-between text-center">
                        <p class="like-info"><span class="align-middle"><i class="far fa-heart"></i></span> Lily và 4
                            người thích bài viết này</p>
                        <div class="col-sm-4 text-center my-2 my-sm-0">
                            <!-- <p class="comment-count"><span class="align-middle"><i class="far fa-comment"></i></span> 06 Bình luận</p> -->
                        </div>
                        <ul class="social-icons">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fab fa-behance"></i></a></li>
                        </ul>
                    </div>
                    <div class="navigation-area">
                        <div class="row">
                            <div
                                class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                                <div class="thumb">
                                    <a href="#">
                                        <img class="img-fluid" src="img/post/preview.png" alt="">
                                    </a>
                                </div>
                                <div class="arrow">
                                    <a href="#">
                                        <span class="lnr text-white ti-arrow-left"></span>
                                    </a>
                                </div>
                                <div class="detials">
                                    <p>Bài viết trước</p>
                                    <a href="#">
                                        <h4>Không gian vũ trụ: Biên giới cuối cùng</h4>
                                    </a>
                                </div>
                            </div>
                            <div
                                class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                                <div class="detials">
                                    <p>Bài viết tiếp theo</p>
                                    <a href="#">
                                        <h4>Những điều cơ bản về kính thiên văn</h4>
                                    </a>
                                </div>
                                <div class="arrow">
                                    <a href="#">
                                        <span class="lnr text-white ti-arrow-right"></span>
                                    </a>
                                </div>
                                <div class="thumb">
                                    <a href="#">
                                        <img class="img-fluid" src="img/post/next.png" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="blog-author">
                    <div class="media align-items-center">
                        <img src="img/blog/author.png" alt="">
                        <div class="media-body">
                            <a href="#">
                                <h4>Admin</h4>
                            </a>
                            <p>Chia sẻ về cuộc sống và những khám phá khoa học thú vị. Hãy tham gia cuộc hành trình khám
                                phá các lý thuyết thú vị và thông tin bổ ích về thế giới xung quanh chúng ta.</p>
                        </div>
                    </div>
                </div>

                <div class="comments-area">
                    <h4>05 Bình luận</h4>
                    <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                                <div class="thumb">
                                    <img src="https://bdsdaily.com/img/comment/comment_1.png" alt="">
                                </div>
                                <div class="desc">
                                    <p class="comment">
                                        Biển đêm bốn mùa hạt giống trời được nuôi dưỡng. Cảm ơn các bạn đã chia sẻ.
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <h5>
                                                <a href="#">Binh Lam</a>
                                            </h5>
                                            <p class="date">Ngày 4 tháng 12, 2017 vào lúc 3:12 chiều</p>
                                        </div>
                                        <div class="reply-btn">
                                            <a href="#" class="btn-reply text-uppercase">trả lời</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                                <div class="thumb">
                                    <img src="https://bdsdaily.com/img/comment/comment_2.png" alt="">
                                </div>
                                <div class="desc">
                                    <p class="comment">
                                        Lý thuyết về các lớp phân tầng và sự hình thành các vì sao sẽ giúp chúng ta hiểu
                                        rõ hơn về vũ trụ.
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <h5>
                                                <a href="#">Anh Jmi</a>
                                            </h5>
                                            <p class="date">Ngày 4 tháng 12, 2017 vào lúc 3:12 chiều</p>
                                        </div>
                                        <div class="reply-btn">
                                            <a href="#" class="btn-reply text-uppercase">trả lời</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                                <div class="thumb">
                                    <img src="https://bdsdaily.com/img/comment/comment_3.png" alt="">
                                </div>
                                <div class="desc">
                                    <p class="comment">
                                        Đây là một trong những kiến thức quan trọng giúp chúng ta hiểu về sự hình thành
                                        vũ trụ.
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <h5>
                                                <a href="#">Emilly</a>
                                            </h5>
                                            <p class="date">Ngày 4 tháng 12, 2017 vào lúc 3:12 chiều</p>
                                        </div>
                                        <div class="reply-btn">
                                            <a href="#" class="btn-reply text-uppercase">trả lời</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="comment-form">
                    <h4>Để lại phản hồi</h4>
                    <form class="form-contact comment_form" action="#" id="commentForm">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                        placeholder="Viết bình luận"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="name" id="name" type="text" placeholder="Tên">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="email" id="email" type="email"
                                        placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="website" id="website" type="text"
                                        placeholder="Website">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm btn_1">Gửi tin nhắn <i
                                    class="flaticon-right-arrow"></i></button>
                        </div>
                    </form>
                </div>

            </div>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</section>
<!--================Blog Area end =================-->