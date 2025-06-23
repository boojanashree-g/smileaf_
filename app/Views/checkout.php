<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>
<style>
</style>

<body>
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
                    <div class="col-lg-7 mb-4">
                        <div class="checkout-container">
                            <!-- Login Section -->
                            <div class="step-section" id="loginSection">
                                <div class="step-header">
                                    <div class="step-number">1</div>
                                    LOGIN OR SIGNUP
                                </div>
                                <div class="step-content">
                                    <div class="login-section">
                                        <div class="login-form">
                                            <div class="input-group">
                                                <input type="text" class="input-field mb-2"
                                                    placeholder="Enter Email/Mobile number" id="loginInput">
                                                <input type="text" class="input-field mb-0" placeholder="Enter otp"
                                                    id="otpInput">
                                            </div>
                                            <div class="terms-text">
                                                By continuing, you agree to Smileaf's <a
                                                    href="<?php echo base_url('terms-and-conditions') ?>">Terms of
                                                    Use</a> and
                                                <a href="<?php echo base_url('privacy-policy') ?>">Privacy Policy</a>.
                                            </div>
                                            <button class="continue-btn" onclick="proceedToNext()">CONTINUE</button>
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
                                    <div class="step-number">2</div>
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
                                                    <h6>Town / City</h6>
                                                    <input type="text" class="input-field" placeholder="City">
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
                                        <td><strong>Sub Total</strong></td>
                                        <td><strong>₹623.00</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>CGST</strong></td>
                                        <td><strong>₹10.00</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong> Total</strong></td>
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

    <script>
    function proceedToNext() {
        const input = document.getElementById('loginInput');
        if (input.value.trim() === '') {
            alert('Please enter your email or mobile number');
            return;
        }
        // Activate delivery section
        const deliverySection = document.getElementById('deliverySection');
        const loginSection = document.getElementById('loginSection');
        loginSection.classList.add('inactive-section');
        deliverySection.classList.remove('inactive-section');
        deliverySection.querySelector('.step-header').classList.remove('inactive-header');
        deliverySection.querySelector('.step-header').style.color = 'white';
        deliverySection.querySelector('.inactive-content').style.display = 'none';

        // Show address form
        toggleAddressForm();
    }

    function toggleAddressForm() {
        const addressForm = document.getElementById('addressForm');
        addressForm.classList.add('active');

    }

   function togglePersonalAddress() {
    const personalDetails = document.getElementById("personalDetaila");
    personalDetails.style.display = "block";
}



    function proceedToOrderSummary() {
        // Activate order summary section
        const orderSection = document.getElementById('orderSection');
        orderSection.classList.remove('inactive-section');
        orderSection.querySelector('.step-header').classList.remove('inactive-header');
        orderSection.querySelector('.step-header').style.background = '#4285f4';
        orderSection.querySelector('.step-header').style.color = 'white';
        orderSection.querySelector('.inactive-content').style.display = 'none';

        // Activate payment section
        const paymentSection = document.getElementById('paymentSection');
        paymentSection.classList.remove('inactive-section');
        paymentSection.querySelector('.step-header').classList.remove('inactive-header');
        paymentSection.querySelector('.step-header').style.background = '#4285f4';
        paymentSection.querySelector('.step-header').style.color = 'white';
        paymentSection.querySelector('.inactive-content').style.display = 'none';
    }
    </script>


</body>

</html>