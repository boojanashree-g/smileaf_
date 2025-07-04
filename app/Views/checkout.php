<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>
<style>
    .otp-resend {
        color: rgb(12, 91, 28)
    }

</style>

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
                                                    <input type="number" id="number" placeholder="Mobile Number*"
                                                        name="number">
                                                    <input type="text" class="input-field mb-0 otp-field <?= $otpClass ?>"
                                                        placeholder="Enter otp" id="otpInput" name="otp"
                                                        autocomplete="false">
                                                    <span class="otp-text <?= $otpClass ?>">The OTP is valid for 1 minute
                                                        only.</span>
                                                    <span class="otp-resend <?= $otpClass ?>">
                                                        <button class="resend-btn" id="resend-otp">Resend Button</button>
                                                    </span>
                                                </div>
                                                <div class="terms-text">
                                                    By continuing, you agree to Smileaf's <a
                                                        href="<?php echo base_url('terms-and-conditions') ?>">Terms of
                                                        Use</a> and
                                                    <a href="<?php echo base_url('privacy-policy') ?>">Privacy Policy</a>.
                                                </div>
                                                <button class="continue-btn" id="continue-login">CONTINUE</button>
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
                                    User Details
                                </div>
                                <div class="step-content ">

                                    <div class="login-section">
                                        <div class="login-form">
                                            <div class="input-group">
                                                <input type="text" class="input-field mb-2" placeholder="Name"
                                                    id="username" name="username"
                                                    value="<?= $user_details[0]['username'] ?>">
                                                <input type="email" class="input-field mb-0" placeholder="Enter Email"
                                                    id="email" name="email" value="<?= $user_details[0]['email'] ?>">
                                            </div>
                                            <div class="terms-text">
                                                By continuing, you agree to Smileaf's <a
                                                    href="<?php echo base_url('terms-and-conditions') ?>">Terms of
                                                    Use</a> and
                                                <a href="<?php echo base_url('privacy-policy') ?>">Privacy Policy</a>.
                                            </div>
                                            <button class="continue-btn" id="continue-userdetail">CONTINUE</button>
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
                                        <?php
                                        $otp_verify = session()->get('otp_verify');
                                        $login_status = session()->get('loginStatus');

                                        if ($otp_verify === 'YES' && $login_status === 'YES') { ?>
                                            <?php foreach ($address as $i => $add) { ?>
                                                <div class="address-card" id="">
                                                    <div class="address-card-head">
                                                        <div class="address-header-info">
                                                            <input type="radio" data-addid="<?= $add['add_id'] ?>" class="checkout-add text-red default_address" <?php $default = $add['default_addr'];
                                                            echo $default == 1 ? "checked" : "" ?> >
                                                            <div class="address-name-type">
                                                                <span class="address-name"><?= $add['username'] ?></span>
                                                                <span class="address-phone"><?= $add['number'] ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="address-edit"><button>Change</button>
                                                            <button data-addid="<?= $add['add_id'] ?>"
                                                                class="address-delete">Delete</button>
                                                        </div>

                                                    </div>
                                                    <div class="address-text">
                                                        <p class="mb-2"><?= $add['email'] ?></p>
                                                        <?= $add['address'] ?> , <br>
                                                        <?= $add['landmark'] ?> , <?= $add['city'] ?><br>
                                                        <?= $add['state_title'] ?> ,<?= $add['dist_name'] ?>,<br>
                                                        <?= $add['pincode'] ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php }
                                        ?>

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

                                            <form id="checkoutAddressForm">
                                                <h6>Address</h6>
                                                <div class="form-row">
                                                    <textarea class="form-control-" id="address" name="address" rows="4"
                                                        placeholder="House/Flat No, Street Name, Area"
                                                        required></textarea>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-col">
                                                        <label for="state_id" class="form-label">State *</label>
                                                        <select name="state_id" id="state_id">
                                                            <option value="">Select State</option>
                                                            <?php for ($i = 0; $i < count($state); $i++) { ?>

                                                                <option value="<?php echo $state[$i]['state_id'] ?>">
                                                                    <?php echo $state[$i]['state_title'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-col">
                                                        <label for="dist_id" class="form-label">District *</label>
                                                        <select id="dist_id" name="dist_id">
                                                            <!-- code -->
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-col">
                                                        <label for="landmark" class="form-label">Landmark *</label>
                                                        <input type="text" class="form-control" id="landmark"
                                                            name="landmark" placeholder="Landmark" required>
                                                    </div>
                                                    <div class="form-col"> <label for="city"
                                                            class="form-label">Town/City
                                                            *</label>
                                                        <input type="text" class="form-control" id="city" name="city"
                                                            placeholder="Town/City" required>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-col">
                                                        <label for="city" class="form-label">Pincode
                                                            *</label>
                                                        <input type="text" class="form-control" id="pincode"
                                                            name="pincode" placeholder="Pincode" required>
                                                    </div>
                                                    <div class="form-col">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="default_addr" name="default_addr">
                                                        <label class="form-check-label" for="default_addr">Set as
                                                            default address</label>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        <div class="d-flex">
                                              <div class="col-lg-6">
                                            <button class="continue-btn" id="close-address">CLOSE</button>
                                        </div>
                                         <div class="col-lg-6">
                                             <button class="continue-btn" id="address-checkout">CONTINUE</button> 
                                        </div>
                                      
                                        </div>
                                        
                                        
                                        

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
                            <input type="hidden"  class="checkout-type" value="<?= $type?>"/>
                          <?php foreach ($gst_subid_list as $item): ?>
                                <input type="hidden" class="sub-id" value="<?= $item ?>" />
                            <?php endforeach; ?>


                            <div class="place-order-wrapper">
                                <button class="w-100 mx-0" type="submit" id="place-order">Place order</button>
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