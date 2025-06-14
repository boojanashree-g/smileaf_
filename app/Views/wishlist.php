<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

<!-- Body main wrapper start -->
<div class="body-wrapper">

    <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>
    <!-- HEADER AREA END -->

    <!-- BREADCRUMB AREA START -->
        <?php require("components/breadcrumbs.php")?>
    <!-- BREADCRUMB AREA END -->

    <!-- WISHLIST AREA START -->
    <div class="liton__wishlist-area mb-105">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping-cart-inner">
                        <div class="shoping-cart-table table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="cart-product-remove">x</td>
                                        <td class="cart-product-image">
                                            <a href="<?php echo base_url('productDetails') ?>"><img src="<?php echo base_url()?>public/assets/img/plate_img/round-plate/10RSP.jpg" alt="#"></a>
                                        </td>
                                        <td class="cart-product-info">
                                            <h4><a href="<?php echo base_url('productDetails') ?>">10" Square Dinner plate</a></h4>
                                        </td>
                                        <td class="cart-product-price">$85.00</td>
                                        <td class="cart-product-stock">In Stock</td>
                                        <td class="cart-product-add-cart">
                                            <a class="submit-button-1" href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">Add to Cart</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart-product-remove">x</td>
                                        <td class="cart-product-image">
                                            <a href="<?php echo base_url('productDetails') ?>"><img src="<?php echo base_url()?>public/assets/img/plate_img/round-plate/10RSP.jpg" alt="#"></a>
                                        </td>
                                        <td class="cart-product-info">
                                            <h4><a href="<?php echo base_url('productDetails') ?>">10" Square Dinner plate</a></h4>
                                        </td>
                                        <td class="cart-product-price">$89.00</td>
                                        <td class="cart-product-stock">In Stock</td>
                                        <td class="cart-product-add-cart">
                                            <a class="submit-button-1" href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">Add to Cart</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart-product-remove">x</td>
                                        <td class="cart-product-image">
                                            <a href="<?php echo base_url('productDetails') ?>"><img src="<?php echo base_url()?>public/assets/img/plate_img/round-plate/10RSP.jpg" alt="#"></a>
                                        </td>
                                        <td class="cart-product-info">
                                            <h4><a href="<?php echo base_url('productDetails') ?>">10" Square Dinner plate</a></h4>
                                        </td>
                                        <td class="cart-product-price">$149.00</td>
                                        <td class="cart-product-stock">In Stock</td>
                                        <td class="cart-product-add-cart">
                                            <a class="submit-button-1" href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">Add to Cart</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- WISHLIST AREA START -->

    <!-- FOOTER AREA START -->
    <?php require("components/footer.php") ?>

    <!-- FOOTER AREA END -->
</div>
<!-- Body main wrapper end -->

    <!-- All JS Plugins -->
    <script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
    <!-- Main JS -->
    <script src="<?php echo base_url() ?>public/assets/js/main.js"></script>
  
</body>

<!-- Mirrored from tunatheme.com/tf/html/broccoli-preview/broccoli/<?php echo base_url('wishlist')?> by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 26 May 2025 07:24:11 GMT -->
</html>

