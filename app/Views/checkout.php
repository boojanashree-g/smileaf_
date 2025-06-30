<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>

<body class="checkout_page">
    <div class="body-wrapper">
        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>

        <!-- HEADER AREA END -->

        <!-- BREADCRUMB AREA START -->
        <?php require("components/breadcrumbs.php") ?>
        <!-- BREADCRUMB AREA END -->

        <!-- WISHLIST AREA START -->
        <div class="ltn__checkout-area mb-105">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 mb-4">
                        <div class="checkout-container">
                            <!-- Login Section -->
                            <div class="step-section" id="loginSection">
                                <div class="step-header">
                                    <div class="step-number">1</div>
                                    LOGIN OR SIGNUP
                                </div>
                                <div class="step-content ">
                                       <?php
                                        $otp_verify = session()->get('otp_verify');
                                        $login_status = session()->get('loginStatus');

                                        if ($otp_verify === 'NO' && $login_status === 'NO') { 
                                        
                                        $otpClass = "d-none" ?>
                                            
                                            <div class="login-section">
                                        <div class="login-form">
                                            <div class="input-group">
                                                <input type="number" id="number" placeholder="Mobile Number*" name="number">
                                                <input type="text" class="input-field mb-0 otp-field <?=  $otpClass ?>" placeholder="Enter otp"
                                                    id="otpInput">
                                            </div>
                                            <div class="terms-text">
                                                By continuing, you agree to Smileaf's <a
                                                    href="<?php echo base_url('terms-and-conditions') ?>">Terms of
                                                    Use</a> and
                                                <a href="<?php echo base_url('privacy-policy') ?>">Privacy Policy</a>.
                                            </div>
                                            <button class="continue-btn" id="continue-login" >CONTINUE</button>
                                        </div>
                                        <div class="advantages">
                                            <h4><strong>Perks of Logging In Securely</strong></h4>
                                            <div class="advantage-item">
                                                <span>Unlock More with Your Login</span>
                                            </div>
                                            <div class="advantage-item">
                                                <span>Save your address and payment details securely.</span>
                                            </div>
                                            <div class="advantage-item">
                                                <span>Keep track of every purchase in one place.</span>
                                            </div>
                                        </div>
                                    </div>
                                        <?php }
                                        ?>

                                   
                                </div>
                            </div>
                            <div class="step-section" id="detailSection">
                                <div class="step-header">
                                    <div class="step-number">2</div>
                                    LOGIN OR SIGNUP
                                </div>
                                <div class="step-content ">
                                    <div class="login-section">
                                        <div class="login-form">
                                            <div class="input-group">
                                                <input type="text" class="input-field mb-2"
                                                    placeholder="Enter Mobile number" id="loginInput">
                                                <input type="text" class="input-field mb-0" placeholder="Enter otp"
                                                    id="otpInput">
                                            </div>
                                            <div class="terms-text">
                                                By continuing, you agree to Smileaf's <a
                                                    href="<?php echo base_url('terms-and-conditions') ?>">Terms of
                                                    Use</a> and
                                                <a href="<?php echo base_url('privacy-policy') ?>">Privacy Policy</a>.
                                            </div>
                                            <button class="continue-btn-" >CONTINUE</button>
                                        </div>
                                        <div class="advantages">
                                            <h4><strong>Perks of Logging In Securely</strong></h4>
                                            <div class="advantage-item">
                                                <span>Unlock More with Your Login</span>
                                            </div>
                                            <div class="advantage-item">
                                                <span>Save your address and payment details securely.</span>
                                            </div>
                                            <div class="advantage-item">
                                                <span>Keep track of every purchase in one place.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Address Section -->
                            <div class="step-section inactive-section" id="deliverySection">
                                <div class="step-header inactive-header">
                                    <div class="step-number">3</div>
                                    DELIVERY ADDRESS
                                </div>
                                <div class="inactive-content">
                                    Please complete the previous step to continue
                                </div>
                                <div class="step-content address-form" id="addressForm">
                                    <div class="address-content mb-5">
                                        <!-- Existing Address -->
                                        <div class="address-card" id="existing-address">
                                            <div class="address-card-head">
                                                <div class="address-header-info">
                                                    <input type="radio">
                                                    <div class="address-name-type">
                                                        <span class="address-name">Boo</span>
                                                        <span class="address-phone">8754342698</span>
                                                    </div>
                                                </div>
                                                <div class="address-edit"><button>Change</button></div>
                                            </div>
                                            <div class="address-text">
                                                <p class="mb-2">boojanashree20@gmail.com</p>
                                                Rajalakshmi Sai Complex Technology park in Coimbatore, Tamil Nadu,
                                                Saravanampatti, Coimbatore, Tamil Nadu - 641035
                                            </div>
                                        </div>

                                        <!-- Add New Address Section -->
                                        <div class="add-address">
                                            <div class="add-address-btn" onclick="togglePersonalAddress()">
                                                <div class="add-icon">+</div>
                                                <span>Add a new address</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="personalDetaila" style="display: none;">
                                        <div class="form-section">
                                            <h6>Personal Information</h6>
                                            <div class="form-row">
                                                <div class="form-col">
                                                    <input type="text" class="input-field" placeholder="First name">
                                                </div>
                                                <div class="form-col">
                                                    <input type="email" class="input-field" placeholder="Email address">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-col">
                                                    <input type="text" class="input-field" placeholder="Phone number">
                                                </div>
                                                <div class="form-col"></div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <h6>Address</h6>
                                            <div class="form-row">
                                                <div class="form-col">
                                                    <input type="text" class="input-field"
                                                        placeholder="House number and street name">
                                                </div>
                                                <div class="form-col">
                                                    <input type="text" class="input-field"
                                                        placeholder="Apartment, suite, unit etc. (optional)">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-col">
                                                    <!-- <label for="city" class="form-label"> -->
                                                    <h6>Town / City</h6>
                                                    <!-- </label> -->
                                                    <select id="city" name="city" class="input-field" required>
                                                        <option value="">Select City</option>
                                                        <option value="chennai">Chennai</option>
                                                        <option value="coimbatore">Coimbatore</option>
                                                        <option value="madurai">Madurai</option>
                                                        <option value="trichy">Tiruchirappalli</option>
                                                    </select>
                                                </div>

                                                <div class="form-col">
                                                    <h6>State</h6>
                                                    <input type="text" class="input-field" placeholder="State">
                                                </div>

                                                <div class="form-col">
                                                    <h6>Zip</h6>
                                                    <input type="text" class="input-field" placeholder="Zip">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-section">
                                            <h6>Order Notes (optional)</h6>
                                            <textarea class="textarea-field"
                                                placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                        </div>
                                        <button class="continue-btn" onclick="proceedToOrderSummary()">CONTINUE</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-5 col-md-12 col-12">
                        <div class="shoping-cart-total mt-0">
                            <h4 class="title-2">Cart Totals</h4>
                            <table class="table">
                                <tbody>
                                    <?php foreach ($checkout_product as $product) { ?>
                                        <tr>
                                            <td class="checkout-product" data-price="<?= $product['offer_price'] ?>"
                                                data-gst="<?= $product['gst'] ?>"
                                                data-cartqty="<?= $product['cart_quantity'] ?>"
                                                data-mainqty="<?= $product['variant_qty'] ?>"
                                                data-cartid="<?= $product['cart_id'] ?>" data->
                                                <?= htmlspecialchars(ucfirst($product['prod_name'])) ?><strong> ×
                                                    <?= (int) $product['cart_quantity'] ?></strong>
                                            </td>
                                            <td class="cart_total_<?= $product['cart_id'] ?>">
                                                ₹<?= number_format($product['final_prod_price'], 2) ?></td>
                                        </tr>

                                    <?php } ?>


                                    <tr>
                                        <td><strong>Sub Total</strong></td>
                                        <td><strong class="order-subtotal">₹<?= number_format($subtotal, 2) ?></strong>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td><strong>CGST(Includes)</strong></td>
                                        <td><strong class="gst-td">₹<?= number_format($cgst, 2) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>SGST(Includes)</strong></td>
                                        <td><strong class="sgst-td">₹<?= number_format($sgst, 2) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Shipping</strong></td>
                                        <td><strong>₹<?= number_format($delivery_charge, 2) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong> Total</strong></td>
                                        <td><strong
                                                class="order_total_amt">₹<?= number_format($final_total, 2) ?></strong>
                                        </td>
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
    <script src="<?php echo base_url() ?>custom/js/checkout.js"></script>


    <script>
        function proceedToNext() {
            const inputVal = $('#loginInput').val().trim();
            if (inputVal === '') {
                alert('Please enter your email or mobile number');
                return;
            }

            // Activate delivery section
            $('#loginSection').addClass('inactive-section');
            const $deliverySection = $('#deliverySection');
            $deliverySection.removeClass('inactive-section');
            $deliverySection.find('.step-header').removeClass('inactive-header').css('color', 'white');
            $deliverySection.find('.inactive-content').hide();

            // Show address form
            toggleAddressForm();
        }

        function toggleAddressForm() {
            $('#addressForm').addClass('active');
        }

        function togglePersonalAddress() {
            $('#personalDetaila').show();
        }

        function proceedToOrderSummary() {
            // Activate order summary section
            const $orderSection = $('#orderSection');
            $orderSection.removeClass('inactive-section');
            $orderSection.find('.step-header')
                .removeClass('inactive-header')
                .css({ background: '#4285f4', color: 'white' });
            $orderSection.find('.inactive-content').hide();

            // Activate payment section
            const $paymentSection = $('#paymentSection');
            $paymentSection.removeClass('inactive-section');
            $paymentSection.find('.step-header')
                .removeClass('inactive-header')
                .css({ background: '#4285f4', color: 'white' });
            $paymentSection.find('.inactive-content').hide();
        }

    </script>


</body>

</html>