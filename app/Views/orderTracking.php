<!doctype html>
<html class="no-js" lang="zxx">
    <?php require("components/head.php") ?>

<style>
.order-tracking-status {
    text-align: center;
    margin-top: 40px;
}

.track {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px 10px;
}

.track::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 4px;
    background: #ddd;
    top: 38px;
    left: 0;
    z-index: 0;
}

.step {
    position: relative;
    z-index: 1;
    flex: 1;
    text-align: center;
}

.step .icon {
    display: inline-block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    background: #ddd;
    border-radius: 50%;
    color: white;
    font-size: 18px;
    margin-bottom: 8px;
    position: relative;
    z-index: 2;
}

.step.active .icon {
    background: #28a745;
}

.step .text {
    display: block;
    font-size: 13px;
    margin-top: 4px;
    color: #888;
}

.step.active .text {
    color: #28a745;
}
</style>

<body>

<!-- Body main wrapper start -->
<div class="body-wrapper">

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

    <!-- LOGIN AREA START -->
    <div class="ltn__login-area mb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 ">
                    <div class="account-login-inner section-bg-1">
                        <form class="ltn__form-box contact-form-box">
                            <p class="text-center"> To track your order please enter your Order ID in the box below and press the "Track Order" button. This was given to you on your receipt and in the confirmation email you should have received. </p>
                            <label>Order ID</label>
                            <input type="text" name="email" placeholder="Found in your order confirmation email.">                           
                            <div class="btn-wrapper mt-0 text-center">
                                <button class="btn theme-btn-1 btn-effect-1 text-uppercase" id="showProgressBtn" type="submit">Track Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $status = 'Shipped'; 
            $statuses = ['Order Placed', 'Packed', 'Shipped', 'Delivered'];
            $icons = ['fa-check', 'fa-box', 'fa-truck', 'fa-home'];
            $timestamps = [
                'Order Placed' => '2025-06-09 10:15 AM',
                'Packed'       => '2025-06-09 01:30 PM',
                'Shipped'      => '2025-06-10 09:00 AM',
                'Delivered'    => '--',
            ];
        ?>

        <!-- Order Tracking Progress Bar -->
        <div class="order-tracking-status mt-5 d-none">
            <div class="track">
                <?php foreach ($statuses as $index => $s): 
                    $isActive = array_search($s, $statuses) <= array_search($status, $statuses) ? 'active' : '';
                ?>
                <div class="step <?php echo $isActive; ?>">
                    <span class="icon"><i class="fas <?php echo $icons[$index]; ?>"></i></span>
                    <span class="text"><?php echo $s; ?></span>
                    <span class="datetime"><?php echo $timestamps[$s]; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

   

    <!-- LOGIN AREA END -->


    <!-- FOOTER AREA START -->
       <?php require("components/footer.php") ?>

    <!-- FOOTER AREA END -->

</div>
<!-- Body main wrapper end -->
<script>
    document.getElementById("showProgressBtn").addEventListener("click", function (e) {
        e.preventDefault(); // Prevent form submission
        document.querySelector(".order-tracking-status").classList.remove("d-none");
    });
</script>


</body>

</html>

