<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>
<style>
    .otp-resend {
        color: rgb(12, 91, 28)
    }

    .address-change button{       
        background: #fff;        
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        padding: 10px 15px;
        min-width: auto;
        gap: 5px;
    }
    .address-edit{
        border: 1px solid #06870c;
        color: #06870c;
    }
    .address-delete{
        border: 1px solid red;
        color: red;
    }    
</style>

<body class="checkout_page">
    <div class="body-wrapper">
        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>

        <!-- HEADER AREA END -->

        <!-- WISHLIST AREA START -->

        <?php 
            $otp_verify = session()->get('otp_verify');
            $login_status = session()->get('loginStatus');
        ?>
        <div class="ltn__checkout-area mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 mb-4">
                        <div class="checkout-container  ">
                            <!-- Login Section -->
                            <div class="step-section" id="loginSection">
                                <div class="step-header">
                                    <div class="step-number">1</div>
                                    LOGIN OR SIGNUP
                                </div>
                                <div class="step-content ">
                                    <?php
                                        if ($otp_verify === 'NO' && $login_status === 'NO') {
                                        $otpClass = "d-none" ?>

                                        <div class="login-section">
                                            <div class="login-form">
                                                <div class="input-group">
                                                    <input type="number" id="number" placeholder="Mobile Number*"
                                                        name="number">
                                                    <input type="text" class="input-field mb-0 otp-field <?= $otpClass ?>"
                                                        placeholder="Enter OTP" id="otpInput" name="otp"
                                                        maxlength="4" pattern="\d{4}" inputmode="numeric"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"
                                                        autocomplete="off">

                                                    <span class="otp-text <?= $otpClass ?>">The OTP is valid for 1 minute
                                                        only.</span>
                                                    <span class="otp-resend <?= $otpClass ?>">
                                                        <button class="resend-btn" id="resend-otp"><i class="fa fa-repeat me-2" aria-hidden="true"></i>Resend</button>
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
                                    <?php } else {
                                    ?>
                                    <span class="logged_in"><i class="fas fa-check-circle me-2"></i>Logged In - <?= session()->get('number')?> </span>
                                    <?php  }?>
                                </div>
                            </div>
                            <?php 
                                $inactive = ($otp_verify === 'NO' && $login_status === 'NO');
                                $userDetailsSection = $inactive ? "inactive-section" : "";
                                $userDetailsHeader = $inactive ? "inactive-header" : "";
                            ?>

                            <div class="step-section <?= $userDetailsSection ?>" id="detailSection">
                                <div class="step-header <?= $userDetailsHeader ?>">
                                    <div class="step-number">2</div>
                                    User Details
                                </div>

                                <?php if ($inactive): ?>
                                    <div class="inactive-content">
                                        Please complete the previous step to continue
                                    </div>
                                <?php else: ?>
                                   
                                        <div class="step-content edit-userdetails" style="<?= (!empty($user_details[0]['username']) &&  !empty($user_details[0]['email']) &&  !empty($user_details[0]['whatsapp_number'])) ? 'display:none;' : '' ?>">
                                            <div class="">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <input type="text" class="form-control" placeholder="Name"
                                                            id="username" name="username"
                                                            value="<?= htmlspecialchars($user_details[0]['username']) ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <input type="email" class="form-control" placeholder="Enter Email"
                                                            id="email" name="email"
                                                            value="<?= htmlspecialchars($user_details[0]['email']) ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label">WhatsApp on this number?</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input whatsapp_verify" type="radio" name="whatsapp_verify" id="whatsapp_yes" value="yes">
                                                            <label class="form-check-label" for="whatsapp_yes">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input whatsapp_verify" type="radio" name="whatsapp_verify" id="whatsapp_no" value="no">
                                                            <label class="form-check-label" for="whatsapp_no">No</label>
                                                        </div>
                                                    </div>
                                                     <div class="col-md-6 mb-2">
                                                        <input type="number" class="form-control d-none" placeholder="Enter whatsapp number"
                                                            id="whatsapp_number" name="whatsapp_number"
                                                            value="<?= htmlspecialchars($user_details[0]['email']) ?>">
                                                    </div>

                                                </div>
                                                <button class="continue-btn" id="continue-userdetail">CONTINUE</button>
                                            </div>
                                        </div>
                                   
                                        <div class="step-content userdetails-display"  style="<?= (empty($user_details[0]['username']) && empty($user_details[0]['email'])) ? 'display:none;' : '' ?>">
                                            <span class="logged_in me-5"><i class="fas fa-check-circle me-2"></i>Username  - <?= $user_details[0]['username'] ?> </span>
                                            <span class="logged_in"><i class="fas fa-check-circle me-2"></i>Email  - <?= $user_details[0]['email'] ?> </span>
                                        </div>
                                  
                                <?php endif; ?>
                            </div>
                            <?php 
                                $inactive = (
                                    $otp_verify !== 'YES' ||
                                    $login_status !== 'YES' ||
                                    !is_array($user_details) ||
                                    count($user_details) === 0 ||
                                    empty($user_details[0]['username']) ||
                                    empty($user_details[0]['email'])
                                );

                                $addressSection = $inactive ? "inactive-section" : "";
                                $addressHeader = $inactive ? "inactive-header" : "";
                                $addressDisplay = $inactive ? "d-none" : "";

                            ?>

                            <!-- Delivery Address Section -->
                            <div class="step-section <?= $addressSection ?>" id="deliverySection">
                                <div class="step-header <?= $addressHeader ?>">
                                    <div class="step-number">3</div>
                                    DELIVERY ADDRESS
                                </div>
                                <?php if ($inactive ): ?>
                                <div class="inactive-content">
                                    Please complete the previous step to continue
                                </div>
                                <?php endif; ?>
                                <?php if (is_array($user_details) && count($user_details) > 0): ?>  
                                <div class="step-content <?= $addressDisplay?>" id="addressForm">
                                    <div class="address-content mb-0">
                                        <!-- Existing Address -->
                                        <?php
                                        $otp_verify = session()->get('otp_verify');
                                        $login_status = session()->get('loginStatus');

                                        if ($otp_verify === 'YES' && $login_status === 'YES') { ?>
                                            <?php foreach ($address as $i => $add) { ?>
                                                <div class="address-card" id="">
                                                    <div class="address-card-head">
                                                        <div class="address-header-info">
                                                            <input type="radio" data-addid="<?= $add['add_id'] ?>" name="default_addr" class="checkout-add text-red default_address mb-0" <?php $default = $add['default_addr'];
                                                            echo $default == 1 ? "checked" : "" ?> >
                                                            <div class="address-name-type">
                                                                <span class="address-name"><?= $add['username'] ?></span>
                                                                <span class="address-phone"><?= $add['number'] ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="address-change d-flex">
                                                            <button data-addid="<?= $add['add_id'] ?>" class="address-edit">
                                                                <i class="fas fa-pen"></i> <span class="d-none d-sm-inline">Change</span>
                                                            </button>
                                                            <button data-addid="<?= $add['add_id'] ?>" class="address-delete">
                                                                <i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline">Delete</span>
                                                            </button>
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
                                            <div class="add-address-btn">
                                                <div class="add-icon">+</div>
                                                <span class="address-title">Add a new address</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="personalDetaila" style="display: none;">
                                        <div class="form-section mb-0 mt-3">
                                            <form id="checkoutAddressForm">
                                                <h6>Address</h6>
                                                <div class="form-row">
                                                    <textarea class="form-control-  mb-0" id="address" name="address" rows="2"
                                                        placeholder="House/Flat No, Street Name, Area"
                                                        required></textarea>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-col">
                                                        <label for="state_id" class="form-label">State *</label>
                                                        <select  class="select-dropdown" name="state_id" id="state_id">
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
                                                        <select class="select-dropdown" id="dist_id" name="dist_id">
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
                                                </div>                 
                                                <div class="form-row">
                                                    
                                                    <div class="form-col"> <label for="city"
                                                            class="form-label">Town/City
                                                            *</label>
                                                        <input type="text" class="form-control" id="city" name="city"
                                                            placeholder="Town/City" required>
                                                    </div>
                                                    <div class="form-col">
                                                        <label for="city" class="form-label">Pincode
                                                            *</label>
                                                        <input type="text" class="form-control" id="pincode"
                                                            name="pincode" placeholder="Pincode" required>
                                                    </div>
                                                </div>
                                                <div class="form-row mb-0">                                                    
                                                    <div class="form-col">
                                                        <input type="checkbox" class="form-check-input form_defaultaddr mt-0"
                                                            id="default_addr" name="default_addr" style="height: 17px !important;">
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
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-5 col-md-12 col-12">

                        <div class="shoping-cart-total mt-0 mb-2">
                             <div class="advantages">
                                <div class="advantage-item">
                                    <span>🚚 Free courier charge on orders above ₹500!</span>
                                </div>
                        </div>
                            <h4 class="title-2 mb-2">Cart Totals</h4>
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
                                     <?php
                                    if ($offer_delivery_charge == 0) {
                                        $displayCharge = '<span style="color:#699403;">Free</span> <del>₹' . number_format($delivery_charge, 2) . '</del>';
                                    } else {
                                        $displayCharge = '₹' . number_format($delivery_charge, 2);
                                    }
                                    ?>
                                    <td><strong><?= $displayCharge ?></strong></td>


                                    </tr>
                                    <tr>
                                        <td><strong>Total</strong></td>

                                   <?php
                                    if ($total_order_count == 0) {
                                        $order_total_amt = '₹' . number_format($final_total, 2) . ' <span style="color:#699403;">10% OFF</span> <del>₹' . number_format($main_total, 2) . '</del>';
                                    } else {
                                        $order_total_amt = '₹' . number_format($final_total, 2);
                                    }
                                    ?>
                                    <td><strong class="order_total_amt"><?= $order_total_amt ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden"  class="checkout-type" value="<?= $type?>"/>
                            <?php foreach ($gst_subid_list as $item): ?>
                                <input type="hidden" class="sub-id" value="<?= $item ?>" />
                            <?php endforeach; ?>

                            <div class="advantages">
                                <div class="advantage-item">
                                    <span>🚚 Free courier charge on orders above ₹500!</span>
                                </div>
                                <div class="advantage-item">
                                    <?php if ($total_order_count == 0) { ?>      
                                    <span>🎉 Hey New Customer! We’re Giving You 10% OFF on Your First Order!</span>
                                    <?php }
                                    else if(($total_order_count == -1)) { ?>
                                      <span>🛍️ Welcome back! We’re glad to see you again. Stay tuned for future offers!</span>
                                <?php }  ?>
                                    
                                </div>
                            </div>
                             


                            <div class="place-order-wrapper">
                                <?php 
                                    $isDisabled = (
                                        $otp_verify !== 'YES' || 
                                        $login_status !== 'YES' || 
                                        !is_array($user_details) || 
                                        count($user_details) === 0 || 
                                        empty($user_details[0]['username']) || 
                                        empty($user_details[0]['email']) || 
                                        !is_array($address) || 
                                        count($address) === 0
                                    );
                                ?>
                                <button class="w-100 mx-0" type="submit" id="place-order" <?= $isDisabled ? 'disabled' : '' ?>>Place order</button>
                            </div>
                        </div>
                    </div>

                    <div id="address-delete" class="modal fade delete-modall">
                        <div class="modal-dialog modal-confirm">
                            <div class="modal-content">
                                <div class="modal-header flex-column">
                                    <div class="icon-box">
                                        <i class="material-icons">&#xE5CD;</i>
                                    </div>
                                    <h4 class="modal-title w-100">Are you sure?</h4>

                                </div>
                                <div class="modal-body">
                                    <p>Do you really want to delete the address? This process cannot be undone.</p>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="button" class="btn btn-secondary delete-cancel"
                                        data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger btn-delete">Delete</button>
                                </div>
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
         $(document).ready(function () {
            $('#state_id, #dist_id').show();
            $('.nice-select').remove();

            if (sessionStorage.getItem("razorpay_started")) {
  
            window.location.href = base_Url + 'cart';
            }
         });

        document.addEventListener("DOMContentLoaded", function () {
            // Regex: only letters, numbers, and spaces allowed
            const allowedPattern = /^[a-zA-Z0-9 ]*$/;

            function sanitizeInput(event) {
                const input = event.target;
                const sanitized = input.value.replace(/[^a-zA-Z0-9 ]/g, '');
                if (input.value !== sanitized) {
                    input.value = sanitized;
                }
            }

            const usernameInput = document.getElementById('username');
            if (usernameInput) {
                usernameInput.addEventListener('input', sanitizeInput);
            }

            // Bonus: block paste of evil characters
            usernameInput.addEventListener('paste', function (e) {
                e.preventDefault();
                const text = (e.clipboardData || window.clipboardData).getData('text');
                const sanitized = text.replace(/[^a-zA-Z0-9 ]/g, '');
                document.execCommand("insertText", false, sanitized);
            });
        });
</script>

</body>
</html>