<!doctype html>
<html class="no-js" lang="zxx">
<?php require("components/head.php"); ?>


<body class="home_page">
    <div class="body-wrapper">

        <?php require("components/header.php"); ?>       

        <!-- SLIDER AREA START (slider-3) -->
                <?php if (count($bannerData) > 0): ?>
                <div class="<?= count($bannerData) > 1 ? 'slick-banner-slider' : '' ?> ">
                    <?php foreach ($bannerData as $banner): ?>
                        <div class="banner-block">
                            <img src="<?= base_url($banner['banner_image']) ?>"
                                alt="<?= esc($banner['banner_title'] ?? 'Banner Image') ?>"
                                class="banner-image">
                            <div class="banner-content ">
                                <h6 class="banner-subtitle allura-regular">
                                    <?= esc($banner['banner_desc1'] ?? 'Title here') ?>
                                </h6>
                                <h1 class="banner-title">
                                    <?= esc($banner['banner_title'] ?? 'Subtitle goes here') ?>
                                </h1>
                                <?php if (!empty($banner['banner_link'])): ?>
                                    <a href="<?= base_url($banner['banner_link']) ?>" class="banner-btn">
                                        Explore More
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            </div>
        <!-- SLIDER AREA END -->

        <!-- BANNER AREA START -->
        <div class="ltn__banner-area mt-15">
            <div class="container">
                <div class="row ltn__custom-gutter--- justify-content-center">
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="ltn__banner-item">
                            <div class="ltn__banner-img">
                                <a href="shop.html">
                                    <img src="<?php echo base_url() ?>public/assets/img/adcard/card_1.jpg" alt="Banner Image">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="ltn__banner-item">
                            <div class="ltn__banner-img">
                                <a href="shop.html">
                                    <img src="<?php echo base_url() ?>public/assets/img/adcard/card_2.jpg" alt="Banner Image">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="ltn__banner-item">
                            <div class="ltn__banner-img">
                                <a href="shop.html">
                                    <img src="<?php echo base_url() ?>public/assets/img/adcard/card_3.jpg" alt="Banner Image">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BANNER AREA END -->

        <!-- PRODUCT AREA START (product-item-3) -->
        <div class="ltn__product-area ltn__product-gutter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-area ltn__section-title-2 text-center featured_product_header">
                            <h1 class="section-title">Areca Palm Leaf</h1>
                            <span class="viewall-span">View all</span>
                        </div>
                    </div>
                </div>
                <div class="row slider ltn__tab-product-slider-one-active slick-arrow-1">
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-left">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/deep_square.png"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Squares</a></h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-left">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/round-plate/9ROP.jpg"
                                        alt="#"></a>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Rounds</a></h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/rectangle-plate/8rectangle.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Rectangles</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/bowl-plate/4bowl.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Bowls</a></h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/extra-curves/boat.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Extra Curves</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/combo-pack/scal25.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Combo Packs</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PRODUCT AREA END -->
         <!-- PRODUCT AREA START (product-item-3) -->
        <div class="ltn__product-area ltn__product-gutter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-area ltn__section-title-2 text-center featured_product_header">
                            <h1 class="section-title">Sugarcane Bagasse</h1>
                            <span class="viewall-span">View all</span>
                        </div>
                    </div>
                </div>
                <div class="row slider ltn__tab-product-slider-one-active slick-arrow-1">
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-left">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/deep_square.png"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Squares</a></h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-left">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/round-plate/9ROP.jpg"
                                        alt="#"></a>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Rounds</a></h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/rectangle-plate/8rectangle.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Rectangles</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/bowl-plate/4bowl.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Bowls</a></h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/extra-curves/boat.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Extra Curves</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/combo-pack/scal25.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Combo Packs</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PRODUCT AREA END -->
         <!-- PRODUCT AREA START (product-item-3) -->
        <div class="ltn__product-area ltn__product-gutter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-area ltn__section-title-2 text-center featured_product_header">
                            <h1 class="section-title">Rice husk dinnerware</h1>
                            <span class="viewall-span">View all</span>
                        </div>
                    </div>
                </div>
                <div class="row slider ltn__tab-product-slider-one-active slick-arrow-1">
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-left">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/deep_square.png"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Squares</a></h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-left">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/round-plate/9ROP.jpg"
                                        alt="#"></a>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Rounds</a></h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/rectangle-plate/8rectangle.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Rectangles</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/bowl-plate/4bowl.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Bowls</a></h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/extra-curves/boat.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Extra Curves</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <!-- ltn__product-item -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?php echo base_url('productDetails') ?>"><img
                                        src="<?php echo base_url() ?>public/assets/img/plate_img/combo-pack/scal25.jpg"
                                        alt="#"></a>
                                <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="home_products product-info">
                                <h2 class="product-title"><a href="<?php echo base_url('products') ?>">Combo Packs</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PRODUCT AREA END -->

        <!-- VIDEO AREA START -->
        <div class="ltn__video-popup-area ltn__video-popup-margin">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ltn__video-bg-img ltn__video-popup-height-400 bg-overlay-black-10-- bg-image"
                            data-bg="<?php echo base_url() ?>public/assets/img/bg/15.jpg">
                            <a class="ltn__video-icon-2 ltn__video-icon-2-border"
                                href="https://www.youtube.com/embed/ATI7vfCgwXE?autoplay=1&amp;showinfo=0"
                                data-rel="lightcase:myCollection">
                                <i class="fa fa-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- VIDEO AREA END -->

        <!-- TESTIMONIAL AREA START (testimonial-4) -->
        <div class="ltn__testimonial-area section-bg-1 pt-200 pb-20">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-area ltn__section-title-2 text-center">
                            <h6 class="section-subtitle ltn__secondary-color">// Testimonials</h6>
                            <h1 class="section-title">Clients Feedbacks<span>.</span></h1>
                        </div>
                    </div>
                </div>
                <div class="row ltn__testimonial-slider-3-active slick-arrow-1 slick-arrow-1-inner">
                    <div class="col-lg-12">
                        <div class="ltn__testimonial-item ltn__testimonial-item-4">
                            <div class="ltn__testimoni-img">
                                <img src="<?php echo base_url() ?>public/assets/img/plate_img/cactus/icon2-removebg-preview.png"
                                    alt="#">
                            </div>
                            <div class="ltn__testimoni-info">
                                <p>“The wedding was great and the plates were awesome! Got lots of compliments
                                    and impressed by how sturdy they are. Thank you!”</p>
                                <h4>Raj Mahesh</h4>
                                <h6>Chennai</h6>
                            </div>
                            <div class="ltn__testimoni-bg-icon">
                                <i class="far fa-comments"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="ltn__testimonial-item ltn__testimonial-item-4">
                            <div class="ltn__testimoni-img">
                                <img src="<?php echo base_url() ?>public/assets/img/plate_img/cactus/icon2-removebg-preview.png"
                                    alt="#">
                            </div>
                            <div class="ltn__testimoni-info">
                                <p>“The wedding was great and the plates were awesome! Got lots of compliments
                                    and impressed by how sturdy they are. Thank you!”</p>
                                <h4>Raj Mahesh</h4>
                                <h6>Chennai</h6>
                            </div>
                            <div class="ltn__testimoni-bg-icon">
                                <i class="far fa-comments"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="ltn__testimonial-item ltn__testimonial-item-4">
                            <div class="ltn__testimoni-img">
                                <img src="<?php echo base_url() ?>public/assets/img/plate_img/cactus/icon2-removebg-preview.png"
                                    alt="#">
                            </div>
                            <div class="ltn__testimoni-info">
                                <p>“Thanks so much for bringing by the little bowls! They are perfect for our
                                    upcoming event!”</p>
                                <h4>John Mathew</h4>
                                <h6>Bangalore</h6>
                            </div>
                            <div class="ltn__testimoni-bg-icon">
                                <i class="far fa-comments"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="ltn__testimonial-item ltn__testimonial-item-4">
                            <div class="ltn__testimoni-img">
                                <img src="<?php echo base_url() ?>public/assets/img/plate_img/cactus/icon2-removebg-preview.png"
                                    alt="#">
                            </div>
                            <div class="ltn__testimoni-info">
                                <p>“These serving pieces are simple and beautiful in style, and present food in
                                    a way that is mindful and authentic for both restaurants and special
                                    events.”</p>
                                <h4>Siva</h4>
                                <h6>Canada</h6>
                            </div>
                            <div class="ltn__testimoni-bg-icon">
                                <i class="far fa-comments"></i>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                </div>
            </div>
        </div>
        <!-- TESTIMONIAL AREA END -->



        <!-- FOOTER AREA START -->
        <?php require("components/footer.php") ?>
        <!-- FOOTER AREA END -->

        <!-- MODAL AREA START (Quick View Modal) -->
        <div class="ltn__modal-area ltn__quick-view-modal-area">
            <div class="modal fade" id="quick_view_modal" tabindex="-1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <!-- <i class="fas fa-times"></i> -->
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="ltn__quick-view-modal-inner">
                                <div class="modal-product-item">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="modal-product-img">
                                                <img src="<?php echo base_url() ?>public/assets/img/product/4.png"
                                                    alt="#">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="modal-product-info">
                                                <div class="product-ratting">
                                                    <ul>
                                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                        <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                        <li><a href="#"><i class="far fa-star"></i></a></li>
                                                        <li class="review-total"> <a href="#"> ( 95 Reviews )</a></li>
                                                    </ul>
                                                </div>
                                                <h3>Vegetables Juices</h3>
                                                <div class="product-price">
                                                    <span>$149.00</span>
                                                    <del>$165.00</del>
                                                </div>
                                                <div class="modal-product-meta ltn__product-details-menu-1">
                                                    <ul>
                                                        <li>
                                                            <strong>Categories:</strong>
                                                            <span>
                                                                <a href="#">Parts</a>
                                                                <a href="#">Car</a>
                                                                <a href="#">Seat</a>
                                                                <a href="#">Cover</a>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="ltn__product-details-menu-2">
                                                    <ul>
                                                        <li>
                                                            <div class="cart-plus-minus">
                                                                <input type="text" value="02" name="qtybutton"
                                                                    class="cart-plus-minus-box">
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="theme-btn-1 btn btn-effect-1"
                                                                title="Add to Cart" data-bs-toggle="modal"
                                                                data-bs-target="#add_to_cart_modal">
                                                                <i class="fas fa-shopping-cart"></i>
                                                                <span>ADD TO CART</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="ltn__product-details-menu-3">
                                                    <ul>
                                                        <li>
                                                            <a href="#" class="" title="Wishlist" data-bs-toggle="modal"
                                                                data-bs-target="#liton_wishlist_modal">
                                                                <i class="far fa-heart"></i>
                                                                <span>Add to Wishlist</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="" title="Compare" data-bs-toggle="modal"
                                                                data-bs-target="#quick_view_modal">
                                                                <i class="fas fa-exchange-alt"></i>
                                                                <span>Compare</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <hr>
                                                <div class="ltn__social-media">
                                                    <ul>
                                                        <li>Share:</li>
                                                        <li><a href="#" title="Facebook"><i
                                                                    class="fab fa-facebook-f"></i></a></li>
                                                        <li><a href="#" title="Twitter"><i
                                                                    class="fab fa-twitter"></i></a></li>
                                                        <li><a href="#" title="Linkedin"><i
                                                                    class="fab fa-linkedin"></i></a></li>
                                                        <li><a href="#" title="Instagram"><i
                                                                    class="fab fa-instagram"></i></a></li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL AREA END -->


        <!-- MODAL AREA START (Wishlist Modal) -->
        <div class="ltn__modal-area ltn__add-to-cart-modal-area">
            <div class="modal fade" id="liton_wishlist_modal" tabindex="-1">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="ltn__quick-view-modal-inner">
                                <div class="modal-product-item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="modal-product-img">
                                                <img src="<?php echo base_url() ?>public/assets/img/product/7.png"
                                                    alt="#">
                                            </div>
                                            <div class="modal-product-info">
                                                <h5><a href="<?php echo base_url('productDetails') ?>">Vegetables
                                                        Juices</a></h5>
                                                <p class="added-cart"><i class="fa fa-check-circle"></i> Successfully
                                                    added to your Wishlist</p>
                                                <div class="btn-wrapper">
                                                    <a href="<?php echo base_url('wishlist') ?>"
                                                        class="theme-btn-1 btn btn-effect-1">View Wishlist</a>
                                                </div>
                                            </div>
                                            <!-- additional-info -->
                                            <div class="additional-info d-none">
                                                <p>We want to give you <b>10% discount</b> for your first order, <br>
                                                    Use discount code at checkout</p>
                                                <div class="payment-method">
                                                    <img src="<?php echo base_url() ?>public/assets/img/icons/payment.png"
                                                        alt="#">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL AREA END -->

    </div>
    <!-- Body main wrapper end -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js"></script>

    <script>
        const BASE_DURATION = 3;

        function $(selector) {
            return document.querySelector(selector);
        }

        function $$(selector) {
            return Array.from(document.querySelectorAll(selector));
        }

        const animations = [{
            origin: '100% 62%',
            rotation: -10,
            delay: 0,
        }, // Base
        {
            origin: '100% 0%',
            rotation: 15,
            delay: -BASE_DURATION * 0.8
        }, // Stem Leave
        {
            origin: '80% 100%',
            rotation: -10,
            delay: -BASE_DURATION * 0.8
        }, // North 1
        {
            origin: '96% 100%',
            rotation: -8,
            delay: -BASE_DURATION * 0.8
        }, // North 2
        {
            origin: '98% 100%',
            rotation: -9,
            delay: -BASE_DURATION * 0.8
        }, // North 3
        {
            origin: '98% 100%',
            rotation: -9,
            delay: -BASE_DURATION * 0.8
        }, // North 4
        {
            origin: '100% 100%',
            rotation: -9,
            delay: -BASE_DURATION * 0.8
        }, // North 5
        {
            origin: '100% 100%',
            rotation: -9,
            delay: -BASE_DURATION * 0.8
        }, // North 6
        {
            origin: '100% 96%',
            rotation: -9,
            delay: -BASE_DURATION * 0.8
        }, // North 7
        {
            origin: '100% 95%',
            rotation: -9,
            delay: -BASE_DURATION * 0.8
        }, // North 8
        {
            origin: '100% 50%',
            rotation: -5,
            delay: -BASE_DURATION * 0.8
        }, // North 9

        {
            origin: '80% 0%',
            rotation: -5,
            delay: -BASE_DURATION * 0.8
        }, // South 1
        {
            origin: '96% 0%',
            rotation: 8,
            delay: -BASE_DURATION * 0.8
        }, // South 2
        {
            origin: '98% 0%',
            rotation: 9,
            delay: -BASE_DURATION * 0.8
        }, // South 3
        {
            origin: '98% 0%',
            rotation: 9,
            delay: -BASE_DURATION * 0.8
        }, // South 4
        {
            origin: '100% 0%',
            rotation: 9,
            delay: -BASE_DURATION * 0.8
        }, // South 5
        {
            origin: '100% 0%',
            rotation: 9,
            delay: -BASE_DURATION * 0.8
        }, // South 6
        {
            origin: '100% 0%',
            rotation: 9,
            delay: -BASE_DURATION * 0.8
        }, // South 7
        {
            origin: '100% 0%',
            rotation: 9,
            delay: -BASE_DURATION * 0.8
        }, // South 8
        {
            origin: '100% 0%',
            rotation: 10,
            delay: -BASE_DURATION * 0.8
        }, // South 9
        ]

        // Elements
        const base = $('.base');
        const stemLeave = $('.stem-leave');
        const northPaths = $$('.north-leaves path');
        const southPaths = $$('.south-leaves path');

        [base, stemLeave, ...northPaths, ...southPaths].forEach((element, index) => {
            const animation = animations[index];
            TweenMax.set(element, {
                transformOrigin: animation.origin
            });

            TweenMax.to(element, BASE_DURATION, {
                rotation: animation.rotation,
                yoyo: true,
                repeat: -1,
                delay: animation.delay,
                ease: Power1.easeInOut,
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            if ($('.slick-banner-slider').children().length > 1) {
                $('.slick-banner-slider').slick({
                    dots: false,
                    arrows: true,
                    autoplay: true,
                    autoplaySpeed: 4000,
                    fade: true
                });
            }
        });
        
    </script>
    <script>
        $(document).ready(function () {
            $('.ltn__testimonial-slider-3-active').slick({
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 3,
                arrows: false,
                dots: false,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 1200, // screens < 1200px
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768, // screens < 768px
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
</script>
<script>
    $(document).ready(function(){
        $('.slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            autoplay: true,
            autoplaySpeed: 3000,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    });
</script>


</body>

</html>