<!doctype html>
<html class="no-js" lang="zxx">
<?php require("components/head.php"); ?>


<body class="home_page jost">
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
                            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                <div class="ltn__product-item ltn__product-item-3 text-left ">
                                    <div class="product-img">
                                        <a href="<?= base_url('/products/' . $product['slug'] . '/' . base64_encode($product['sub_id'])) ?>">
                                            <img src="<?= base_url() . $product['image_url'] ?>" alt="#">
                                        </a>
                                    </div>
                                    <div class="home_products product-info">
                                        <h2 class="product-title">
                                            <a href="<?= base_url('/products/' . $product['slug'] . '/' . base64_encode($product['sub_id'])) ?>" class="featured_prod_name">
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
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                            <div class="ltn__product-item ltn__product-item-3 text-left ">
                                <div class="product-img">
                                    <a href="<?= base_url('product-details/' . base64_encode($product['prod_id'])) ?>">
                                        <img src="<?= base_url() . $product['main_image'] ?>" alt="#">
                                    </a>
                                </div>
                                <div class="home_products product-info">
                                    <h2 class="product-title">
                                        <a href="<?= base_url('product-details/' . base64_encode($product['prod_id'])) ?>" class="featured_prod_name">
                                            <span><?= esc($product['prod_name']) ?></span>
                                            
                                        </a>
                                        <p class="product-price-info">
                                            <span class="topseller_price">₹1000.00</span>
                                            <span class="quickbuy_span">View Details <i class="fas fa-arrow-alt-circle-right"></i></span>                                        
                                        </p>                                       
                                    </h2>
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
                        <div class="section-title-area ltn__section-title-2 text-center">
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

    </div>
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