<!doctype html>
<html class="no-js" lang="zxx">
<?php require("components/head.php"); ?>
<style>
    .product-title {
        display: flex;
        flex-direction: column;
        align-items: start;
        gap: 10px;
    }

    .featured_prod_name {
        font-size: 18px;
        font-weight: 500;
        white-space: nowrap;
        width: 235px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }

    .product-price-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        font-size: 16px;
        gap: 10px;
    }

    .topseller_price {
        font-weight: bold;
        color: #000;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .quickbuy_span {
        border: 1px solid;
        padding: 5px 10px;
        font-size: 14px;
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
    }
</style>

<body class="home_page jost">
    <div class="body-wrapper">

        <?php require("components/header.php"); ?>

        <!-- SLIDER AREA START (slider-3) -->
        <?php if (count($bannerData) > 0): ?>
            <div class="<?= count($bannerData) > 1 ? 'slick-banner-slider' : '' ?> ">
                <?php foreach ($bannerData as $banner): ?>
                    <div class="banner-block">
                        <img src="<?= base_url($banner['banner_image']) ?>"
                            alt="<?= esc($banner['banner_title'] ?? 'Banner Image') ?>" class="banner-image" loading="lazy">
                        <div class="banner-content ">
                            <h6 class="banner-subtitle allura-regular">
                                <?= esc($banner['banner_desc1'] ?? 'Title here') ?>
                            </h6>
                            <h1 class="banner-title">
                                <?= esc($banner['banner_title'] ?? 'Subtitle goes here') ?>
                            </h1>
                            <?php if (!empty($banner['banner_link'])): ?>
                                <a href="<?= $banner['banner_link'] ?>" class="banner-btn">
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
    <div class="ltn__banner-area ">
        <div class="container sm-padding">
            <div class="row ltn__custom-gutter--- justify-content-center">
                <div class="col-lg-4 col-md-6 col-3 sm-padding">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a href="<?= base_url() ?>products/sugarcane-bagasse/MTI=">
                                <img src="<?= base_url() ?>public/assets/img/adcard/Card_5.jpg" alt="Banner Image"
                                    loading="lazy">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-3 sm-padding">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a href="<?= base_url() ?>product-categories/disposable-plates">
                                <img src="<?= base_url() ?>public/assets/img/adcard/Card_6.jpg" alt="Banner Image"
                                    loading="lazy">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-3 sm-padding">
                    <div class="ltn__banner-item">
                        <div class="ltn__banner-img">
                            <a href="<?= base_url() ?>products/rice-husk-dinnerware/OA==">
                                <img src="<?= base_url() ?>public/assets/img/adcard/Card_7.jpg" alt="Banner Image"
                                    loading="lazy">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BANNER AREA END -->

    <!-- PRODUCT AREA START (product-item-3) -->
    <div class="ltn__product-area ltn__product-gutter featured_product_wrapper">
        <div class="container">
            <div class="row" style="margin:0 0 20px 0;">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center featured_product_header">
                        <h1 class="section-title">Featured Products</h1>
                        <!-- <span class="viewall-span">View all</span> -->
                    </div>
                </div>
            </div>
            <?php if (!empty($featured_products)): ?>
                <div class="row">
                    <?php foreach ($featured_products as $product): ?>
                        <div class="col-lg-4 col-xl-3  col-md-4 col-sm-6 col-12">
                            <div class="ltn__product-item ltn__product-item-3 text-left ">
                                <div class="">
                                    <a href="<?= base_url('/products/' . $product['slug'] . '/' . base64_encode($product['sub_id'])) ?>"
                                        class="d-flex justify-content-center">
                                        <img src="<?= base_url() . $product['image_url'] ?>" alt="#" class="featured_img"
                                            style="max-height: 270px;" loading="lazy">
                                    </a>
                                </div>
                                <div class="home_products product-info">
                                    <h2 class="product-title">
                                        <a href="<?= base_url('/products/' . $product['slug'] . '/' . base64_encode($product['sub_id'])) ?>"
                                            class="featured_prod_name d-flex">
                                            <span><?= esc($product['prod_name']) ?></span>
                                            <i class="fas fa-arrow-alt-circle-right"></i>
                                        </a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No Featured products found.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- PRODUCT AREA END -->
    <!-- PRODUCT AREA START (product-item-3) -->
    <div class="ltn__product-area ltn__product-gutter mb-3 bestseller_product_wrapper">
        <div class="container">
            <div class="section-title-area ltn__section-title-2 text-center featured_product_header mb-4">
                <h1 class="section-title">Try our Bestsellers</h1>
            </div>
            <?php if (!empty($bestSeller)): ?>
                <div class="row">
                    <?php foreach ($bestSeller as $product): ?>
                        <div class="col-lg-4 col-xl-3 col-md-4 col-sm-6 col-12">
                            <div class="ltn__product-item ltn__product-item-3 text-left ">
                                <div class="product-img">
                                    <a href="<?= base_url('product-details/' . base64_encode($product['prod_id'])) ?>"
                                        class="d-flex justify-content-center">
                                        <img src="<?= base_url() . $product['main_images'] ?>" alt="#" class="featured_img"
                                            style="min-height: 270px;" loading="lazy">
                                    </a>
                                </div>
                                <?php if ($product['available_status'] == 0): ?>
                                    <div class="product-badge">
                                        <ul>
                                            <li class="sale-badge">Out of stock</li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <div class="home_products product-info">
                                    <div class="product-title">
                                        <a href="<?= base_url('product-details/' . base64_encode($product['prod_id'])) ?>"
                                            class="featured_prod_name">
                                            <?= esc($product['prod_name']) ?>
                                        </a>
                                        <div class="product-price-info">
                                            <span
                                                class="topseller_price">₹<?= esc($product['lowest_offer_price'] ?? 0) ?></span>
                                            <span class="quickbuy_span">
                                                View Details <i class="fas fa-arrow-alt-circle-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No best sellers found.</p>
            <?php endif; ?>
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
    <div class="ltn__testimonial-area pt-200 pb-20">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center m-0">
                        <h1 class="section-title">Clients Feedbacks<span>.</span></h1>
                    </div>
                </div>
            </div>
            <div class="row ltn__testimonial-slider-3-active slick-arrow-1 slick-arrow-1-inner">
                <div class="col-lg-12">
                    <div class="ltn__testimonial-item ltn__testimonial-item-4">
                        <div class="ltn__testimoni-img">
                            <img src="<?php echo base_url() ?>public/assets/img/plate_img/cactus/icon2-removebg-preview.png"
                                alt="#" loading="lazy">
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
                                alt="#" loading="lazy">
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
                                alt="#" loading="lazy">
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



    </div>
    <script>
        $(document).ready(function () {
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
        $(document).ready(function () {
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