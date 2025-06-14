<!doctype html>
<html class="no-js" lang="zxx">
<?php require("components/head.php") ?>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

    <!-- Body main wrapper start -->
    <div class="wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>

        <!-- HEADER AREA END -->
  <!-- Utilize Cart Menu Start -->
        <div id="ltn__utilize-cart-menu" class="ltn__utilize ltn__utilize-cart-menu">
        <div class="ltn__utilize-menu-inner ltn__scrollbar">
            <div class="ltn__utilize-menu-head">
                <span class="ltn__utilize-menu-title">Cart</span>
                <button class="ltn__utilize-close">×</button>
            </div>
            <div class="mini-cart-product-area ltn__scrollbar">
                <div class="mini-cart-item clearfix">
                    <div class="mini-cart-img">
                        <a href="#"><img src="<?php  echo base_url()?>public/assets/img/plate_img/round-plate/10RSP.jpg" alt="Image"></a>
                        <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                    </div>
                    <div class="mini-cart-info">
                        <h6><a href="#">Red Hot Tomato</a></h6>
                        <span class="mini-cart-quantity">1 x $65.00</span>
                    </div>
                </div>
                <div class="mini-cart-item clearfix">
                    <div class="mini-cart-img">
                        <a href="#"><img src="<?php  echo base_url()?>public/assets/img/plate_img/round-plate/10RSP.jpg" alt="Image"></a>
                        <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                    </div>
                    <div class="mini-cart-info">
                        <h6><a href="#">Vegetables Juices</a></h6>
                        <span class="mini-cart-quantity">1 x $85.00</span>
                    </div>
                </div>
                <div class="mini-cart-item clearfix">
                    <div class="mini-cart-img">
                        <a href="#"><img src="<?php  echo base_url()?>public/assets/img/plate_img/round-plate/10RSP.jpg" alt="Image"></a>
                        <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                    </div>
                    <div class="mini-cart-info">
                        <h6><a href="#">Orange Sliced Mix</a></h6>
                        <span class="mini-cart-quantity">1 x $92.00</span>
                    </div>
                </div>
                <div class="mini-cart-item clearfix">
                    <div class="mini-cart-img">
                        <a href="#"><img src="<?php  echo base_url()?>public/assets/img/plate_img/round-plate/10RSP.jpg" alt="Image"></a>
                        <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                    </div>
                    <div class="mini-cart-info">
                        <h6><a href="#">Orange Fresh Juice</a></h6>
                        <span class="mini-cart-quantity">1 x $68.00</span>
                    </div>
                </div>
            </div>
            <div class="mini-cart-footer">
                <div class="mini-cart-sub-total">
                    <h5>Subtotal: <span>$310.00</span></h5>
                </div>
                <div class="btn-wrapper">
                    <a href="<?php echo base_url('cart')?>" class="theme-btn-1 btn btn-effect-1">View Cart</a>
                    <a href="<?php echo base_url('checkout')?>" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                </div>
                <p>Free Shipping on All Orders Over $100!</p>
            </div>

        </div>
    </div>
        <!-- Utilize Cart Menu End -->

        <!-- Utilize Mobile Menu Start -->
        <div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
            <div class="ltn__utilize-menu-inner ltn__scrollbar">
                <div class="ltn__utilize-menu-head">
                    <div class="site-logo">
                        <a href="<?php echo base_url() ?>"><img
                                src="<?php echo base_url() ?>public/assets/img/logo-2.png" alt="Logo"></a>
                    </div>
                    <button class="ltn__utilize-close">×</button>
                </div>
                <div class="ltn__utilize-menu-search-form">
                    <form action="#">
                        <input type="text" placeholder="Search...">
                        <button><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="ltn__utilize-menu">
                    <ul>
                        <li><a href="<?php echo base_url() ?>">Home</a></li>
                        <li><a href="<?php echo base_url('products') ?>">Shop</a></li>
                        <li><a href="<?php echo base_url() ?>">Disposable Dinnerware</a></li>
                        <li><a href="<?php echo base_url() ?>">Reusable Dinnerware</a></li>
                        <li><a href="<?php echo base_url() ?>">Accessories</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <div class="ltn__utilize-buttons ltn__utilize-buttons-2">
                    <ul>
                        <li>
                            <a href="<?php echo base_url('myaccount') ?>" title="My Account">
                                <span class="utilize-btn-icon">
                                    <i class="far fa-user"></i>
                                </span>
                                My Account
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('wishlist') ?>" title="Wishlist">
                                <span class="utilize-btn-icon">
                                    <i class="far fa-heart"></i>
                                    <sup>3</sup>
                                </span>
                                Wishlist
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('cart') ?>" title="Shoping Cart">
                                <span class="utilize-btn-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                    <sup>5</sup>
                                </span>
                                Shoping Cart
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="ltn__social-media-2">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                        <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Utilize Mobile Menu End -->

        <div class="ltn__utilize-overlay"></div>

        <div class="ltn__utilize-overlay"></div>

        <!-- BREADCRUMB AREA START -->
            <?php require("components/breadcrumbs.php")?>
        <!-- BREADCRUMB AREA END -->

        <!-- PRODUCT DETAILS AREA START -->
        <div class="ltn__product-area ltn__product-gutter">
            <div class="container">
                <div class="row">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="liton_product_grid">
                                <div class="ltn__product-tab-content-inner ltn__product-grid-view">
                                    <div class="row">
                                        <!-- ltn__product-item -->
                                        <div class="row">
                                            <?php if (!empty($submenus)): ?>
                                                <?php foreach ($submenus as $submenu): ?>
                                                    <div class="col-xl-3 col-sm-6 col-6">
                                                        <div class="ltn__product-item ltn__product-item-3 text-center">
                                                            <div class="product-img">
                                                                <a href="<?= base_url( $submenu['slug']) ?>">
                                                                    <img src="<?= base_url($submenu['image_url']) ?>" alt="#">
                                                                </a>
                                                                <!-- <div class="product-badge">
                                                                    <ul>
                                                                        <li class="sale-badge">New</li>
                                                                    </ul>
                                                                </div> -->
                                                            </div>
                                                            <div class="product-info mt-3">
                                                                <h2 class="product-title">
                                                                    <a href="<?= base_url('productDetails/' . $submenu['slug']) ?>">
                                                                        <?= esc($submenu['submenu']) ?>
                                                                    </a>
                                                                </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p>No products found under this category.</p>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <!-- PRODUCT DETAILS AREA END -->


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
                                                <img src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                    alt="#">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="modal-product-info">                                                
                                                <h3>Vegetables Juices</h3>
                                                <div class="product-price">
                                                    <span>₹149.00</span>
                                                    <del>₹165.00</del>
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

        <!-- MODAL AREA START (Add To Cart Modal) -->
        <div class="ltn__modal-area ltn__add-to-cart-modal-area">
            <div class="modal fade" id="add_to_cart_modal" tabindex="-1">
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
                                                <img src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                    alt="#">
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
                                                <img src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                    alt="#">
                                            </div>
                                            <div class="modal-product-info">
                                                <h5><a href="<?php echo base_url('productDetails') ?>">Vegetables Juices</a></h5>
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

    <!-- All JS Plugins -->
    <script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
    <!-- Main JS -->
    <script src="<?php echo base_url() ?>public/assets/js/main.js"></script>

</body>

</html>