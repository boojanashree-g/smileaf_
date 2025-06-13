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

        <?php require("components/breadcrumbs.php")?>

        <!-- PRODUCT DETAILS AREA START -->
        <div class="ltn__product-area ltn__product-gutter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 order-lg-2 mb-120">
                        <div class="ltn__shop-options">
                            <ul>
                                <li>
                                    <div class="ltn__grid-list-tab-menu ">
                                        <div class="nav">
                                            <a class="active show" data-bs-toggle="tab" href="#liton_product_grid"><i
                                                    class="fas fa-th-large"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_product_list"><i
                                                    class="fas fa-list"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="short-by text-center">
                                        <select class="nice-select">
                                            <option>Default sorting</option>
                                            <option>Sort by popularity</option>
                                            <option>Sort by new arrivals</option>
                                            <option>Sort by price: low to high</option>
                                            <option>Sort by price: high to low</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="showing-product-number text-right text-end">
                                        <span>Showing 9 of 20 results</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="liton_product_grid">
                                <div class="ltn__product-tab-content-inner ltn__product-grid-view">
                                    <div class="row">
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">New</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹149.00</span>
                                                        <del>₹162.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹62.00</span>
                                                        <del>₹85.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">Hot</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹75.00</span>
                                                        <del>₹92.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹78.00</span>
                                                        <del>₹85.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">Sell -25%</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹150.00</span>
                                                        <del>₹180.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹152.00</span>
                                                        <del>₹158.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹149.00</span>
                                                        <del>₹162.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">New</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹62.00</span>
                                                        <del>₹85.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹75.00</span>
                                                        <del>₹92.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">Sell</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹78.00</span>
                                                        <del>₹85.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹150.00</span>
                                                        <del>₹180.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">New</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹165.00</span>
                                                        <del>₹1720.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹149.00</span>
                                                        <del>₹162.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">New</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹62.00</span>
                                                        <del>₹85.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">New</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹75.00</span>
                                                        <del>₹92.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹78.00</span>
                                                        <del>₹85.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">New</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹150.00</span>
                                                        <del>₹180.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">New</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹165.00</span>
                                                        <del>₹1720.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹150.00</span>
                                                        <del>₹180.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">New</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    <div class="product-price">
                                                        <span>₹165.00</span>
                                                        <del>₹1720.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-xl-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Red Hot
                                                            Tomato</a></h2>
                                                    <div class="product-price">
                                                        <span>₹149.00</span>
                                                        <del>₹162.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="liton_product_list">
                                <div class="ltn__product-tab-content-inner ltn__product-list-view">
                                    <div class="row">
                                        <!-- ltn__product-item -->
                                        <div class="col-lg-12">
                                            <div class="ltn__product-item ltn__product-item-3">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">New</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    
                                                    <div class="product-price">
                                                        <span>₹165.00</span>
                                                        <del>₹1720.00</del>
                                                    </div>
                                                    <div class="product-brief">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                            Recusandae asperiores sit odit nesciunt, aliquid, deleniti
                                                            non et ut dolorem!</p>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-lg-12">
                                            <div class="ltn__product-item ltn__product-item-3">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                </div>
                                                <div class="product-info">
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    
                                                    <div class="product-price">
                                                        <span>₹165.00</span>
                                                        <del>₹1720.00</del>
                                                    </div>
                                                    <div class="product-brief">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                            Recusandae asperiores sit odit nesciunt, aliquid, deleniti
                                                            non et ut dolorem!</p>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-lg-12">
                                            <div class="ltn__product-item ltn__product-item-3">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">New</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    
                                                    <div class="product-price">
                                                        <span>₹165.00</span>
                                                        <del>₹1720.00</del>
                                                    </div>
                                                    <div class="product-brief">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                            Recusandae asperiores sit odit nesciunt, aliquid, deleniti
                                                            non et ut dolorem!</p>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-lg-12">
                                            <div class="ltn__product-item ltn__product-item-3">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                </div>
                                                <div class="product-info">
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Red Hot
                                                            Tomato</a></h2>
                                                    
                                                    <div class="product-price">
                                                        <span>₹165.00</span>
                                                        <del>₹1720.00</del>
                                                    </div>
                                                    <div class="product-brief">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                            Recusandae asperiores sit odit nesciunt, aliquid, deleniti
                                                            non et ut dolorem!</p>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-lg-12">
                                            <div class="ltn__product-item ltn__product-item-3">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">Hot</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    
                                                    <div class="product-price">
                                                        <span>₹165.00</span>
                                                        <del>₹1720.00</del>
                                                    </div>
                                                    <div class="product-brief">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                            Recusandae asperiores sit odit nesciunt, aliquid, deleniti
                                                            non et ut dolorem!</p>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-lg-12">
                                            <div class="ltn__product-item ltn__product-item-3">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                    <div class="product-badge">
                                                        <ul>
                                                            <li class="sale-badge">New</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Areca palm plates</a></h2>
                                                    
                                                    <div class="product-price">
                                                        <span>₹165.00</span>
                                                        <del>₹1720.00</del>
                                                    </div>
                                                    <div class="product-brief">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                            Recusandae asperiores sit odit nesciunt, aliquid, deleniti
                                                            non et ut dolorem!</p>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ltn__product-item -->
                                        <div class="col-lg-12">
                                            <div class="ltn__product-item ltn__product-item-3">
                                                <div class="product-img">
                                                    <a href="<?php echo base_url('productDetails') ?>"><img
                                                            src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                            alt="#"></a>
                                                </div>
                                                <div class="product-info">
                                                    <h2 class="product-title"><a href="<?php echo base_url('productDetails') ?>">Red Hot
                                                            Tomato</a></h2>
                                                    
                                                    <div class="product-price">
                                                        <span>₹165.00</span>
                                                        <del>₹1720.00</del>
                                                    </div>
                                                    <div class="product-brief">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                            Recusandae asperiores sit odit nesciunt, aliquid, deleniti
                                                            non et ut dolorem!</p>
                                                    </div>
                                                    <div class="product-hover-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#quick_view_modal">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Add to Cart" data-bs-toggle="modal"
                                                                    data-bs-target="#add_to_cart_modal">
                                                                    <i class="fas fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                    data-bs-target="#liton_wishlist_modal">
                                                                    <i class="far fa-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ltn__pagination-area text-center">
                            <div class="ltn__pagination">
                                <ul>
                                    <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                                    <li><a href="#">1</a></li>
                                    <li class="active"><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">10</a></li>
                                    <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4  mb-120">
                        <aside class="sidebar ltn__shop-sidebar">
                            <!-- Search Widget -->
                            <div class="widget ltn__search-widget">
                                <h4 class="ltn__widget-title ltn__widget-title-border">Search Objects</h4>
                                <form action="#">
                                    <input type="text" name="search" placeholder="Search your keyword...">
                                    <button type="submit"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                            <!-- Category Widget -->
                            <div class="widget ltn__menu-widget">
                                <h4 class="ltn__widget-title ltn__widget-title-border">Product categories</h4>
                                <ul>
                                    <li><a href="#">Body <span><i class="fas fa-long-arrow-alt-right"></i></span></a>
                                    </li>
                                    <li><a href="#">Interior <span><i
                                                    class="fas fa-long-arrow-alt-right"></i></span></a></li>
                                    <li><a href="#">Lights <span><i class="fas fa-long-arrow-alt-right"></i></span></a>
                                    </li>
                                    <li><a href="#">Parts <span><i class="fas fa-long-arrow-alt-right"></i></span></a>
                                    </li>
                                    <li><a href="#">Tires <span><i class="fas fa-long-arrow-alt-right"></i></span></a>
                                    </li>
                                    <li><a href="#">Uncategorized <span><i
                                                    class="fas fa-long-arrow-alt-right"></i></span></a></li>
                                    <li><a href="#">Wheel <span><i class="fas fa-long-arrow-alt-right"></i></span></a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Price Filter Widget -->
                            <div class="widget ltn__price-filter-widget">
                                <h4 class="ltn__widget-title ltn__widget-title-border">Filter by price</h4>
                                <div class="price_filter">
                                    <div class="price_slider_amount">
                                        <input type="submit" value="Your range:" />
                                        <input type="text" class="amount" name="price" placeholder="Add Your Price" />
                                    </div>
                                    <div class="slider-range"></div>
                                </div>
                            </div>

                            <!-- Size Widget -->
                            <div class="widget ltn__tagcloud-widget ltn__size-widget">
                                <h4 class="ltn__widget-title ltn__widget-title-border">Product Size</h4>
                                <ul>
                                    <li><a href="#">S</a></li>
                                    <li><a href="#">M</a></li>
                                    <li><a href="#">L</a></li>
                                    <li><a href="#">XL</a></li>
                                    <li><a href="#">XXL</a></li>
                                </ul>
                            </div>
                            <!-- Banner Widget -->
                            <div class="widget ltn__banner-widget">
                                <a href="shop.html"><img
                                        src="<?php echo base_url() ?>public/assets/img/banner/banner-1.jpg" alt="#"></a>
                            </div>

                        </aside>
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
                                            <div class="modal-product-info">
                                                <h5><a href="<?php echo base_url('productDetails') ?>">Vegetables Juices</a></h5>
                                                <p class="added-cart"><i class="fa fa-check-circle"></i> Successfully
                                                    added to your Cart</p>
                                                <div class="btn-wrapper">
                                                    <a href="cart.html" class="theme-btn-1 btn btn-effect-1">View
                                                        Cart</a>
                                                    <a href="checkout.html"
                                                        class="theme-btn-2 btn btn-effect-2">Checkout</a>
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