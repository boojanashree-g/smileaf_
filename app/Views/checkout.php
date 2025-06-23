<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

<!-- Body main wrapper start -->
<div class="body-wrapper checkout_page">

    <!-- HEADER AREA START (header-5) -->
    <?php require("components/header.php") ?>

    <!-- HEADER AREA END -->

    <!-- BREADCRUMB AREA START -->
             <?php require("components/breadcrumbs.php")?>
    <!-- BREADCRUMB AREA END -->

    <!-- WISHLIST AREA START -->
    <div class="ltn__checkout-area mb-105">
        <div class="container">
            <div class="row">                 
                <div class="col-lg-7">
                    <div class="ltn__checkout-single-content ltn__returning-customer-wrap">
                            <h5>Returning customer? <a class="ltn__secondary-color" href="#ltn__returning-customer-login" data-bs-toggle="collapse">Click here to login</a></h5>
                            <div id="ltn__returning-customer-login" class="collapse ltn__checkout-single-content-info">
                                <div class="ltn_coupon-code-form ltn__form-box">
                                    <form action="#" >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-item input-item-mobile d-flex ">
                                                    <input type="text" name="ltn__mobile" placeholder="Enter your Mobile" class="login-input">
                                                    <button class="btn theme-btn-1 btn-effect-1 text-uppercase checkout-login-btn">Login</button>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                   <div class="accordion" id="checkoutAccordion">
                        <!-- Accordion Item 1: Billing Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingBilling">
                                <button class="accordion-button m-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBilling" aria-expanded="true" aria-controls="collapseBilling">
                                    Billing Details
                                </button>
                            </h2>
                            <div id="collapseBilling" class="accordion-collapse collapse show" aria-labelledby="headingBilling" data-bs-parent="#checkoutAccordion">
                                <div class="accordion-body">
                                    <div class="ltn__checkout-single-content-info">
                                        <form action="#">
                                            <h6>Personal Information</h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-item input-item-name ltn__custom-icon">
                                                        <input type="text" name="ltn__name" placeholder="First name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-item input-item-email ltn__custom-icon">
                                                        <input type="email" name="ltn__email" placeholder="Email address">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-item input-item-phone ltn__custom-icon">
                                                        <input type="text" name="ltn__phone" placeholder="Phone number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <h6>Address</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-item">
                                                                <input type="text" placeholder="House number and street name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-item">
                                                                <input type="text" placeholder="Apartment, suite, unit etc. (optional)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <h6>Town / City</h6>
                                                    <div class="input-item">
                                                        <input type="text" placeholder="City">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <h6>State </h6>
                                                    <div class="input-item">
                                                        <input type="text" placeholder="State">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <h6>Zip</h6>
                                                    <div class="input-item">
                                                        <input type="text" placeholder="Zip">
                                                    </div>
                                                </div>
                                            </div>
                                            <p><label class="input-info-save mb-0"><input type="checkbox" name="agree"> Create an account?</label></p>
                                            <h6>Order Notes (optional)</h6>
                                            <div class="input-item input-item-textarea ltn__custom-icon">
                                                <textarea name="ltn__message" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Accordion Item 2: Shipping Details (example second section) -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingShipping">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShipping" aria-expanded="false" aria-controls="collapseShipping">
                                    Shipping Details
                                </button>
                            </h2>
                            <div id="collapseShipping" class="accordion-collapse collapse" aria-labelledby="headingShipping" data-bs-parent="#checkoutAccordion">
                                <div class="accordion-body">
                                    <!-- You can replicate or customize this section -->
                                    <p>Shipping form or additional details here...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="shoping-cart-total mt-0">
                        <h4 class="title-2">Cart Totals</h4>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Rounded Plates <strong>× 2</strong></td>
                                    <td>₹298.00</td>
                                </tr>
                                <tr>
                                    <td>Rounded PlatesMix <strong>× 2</strong></td>
                                    <td>₹170.00</td>
                                </tr>
                                <tr>
                                    <td>Rounded Plates <strong>× 2</strong></td>
                                    <td>₹150.00</td>
                                </tr>
                                <tr>
                                    <td>Rounded Plates</td>
                                    <td>₹15.00</td>
                                </tr>
                                <tr>
                                    <td>Rounded Plates</td>
                                    <td>₹00.00</td>
                                </tr>
                                <tr>
                                    <td><strong>Order Total</strong></td>
                                    <td><strong>₹633.00</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="place-order-wrapper">
                            <button class="w-100 mx-0" type="submit">Place order</button>
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

</html>

