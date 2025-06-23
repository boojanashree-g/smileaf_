<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>
<style>
.input-group input {
    height: 50px;
}

.checkout-container {
    max-width: 900px;
    margin: 0 auto;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.step-section {
    border-bottom: 1px solid #e5e5e5;
}

.step-section:last-child {
    border-bottom: none;
}

.step-header {
    background: #788b5c;
    color: white;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    font-size: 16px;
}

.step-number {
    background: rgba(255, 255, 255, 0.2);
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: bold;
}

.step-content {
    padding: 20px;
}

.login-section {
    display: flex;
    gap: 40px;
    align-items: flex-start;
}
.terms-text {
    font-size: 12px;
    color: #666;
    margin: 15px 0;
}


.continue-btn {
    background: #ff6600;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    height: 40px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: background-color 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.continue-btn:hover {
    background: #e55a00;
}

.advantages h4 {
    color: #666;
    font-size: 14px;
    margin-bottom: 15px;
    font-weight: 500;
}

.advantage-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 12px;
    font-size: 13px;
    color: #333;
}


.inactive-section {
    background: #f8f9fa;
}

.inactive-header {
    background: #e9ecef;
    color: #6c757d;
}

.inactive-content {
    color: #6c757d;
    padding: 15px 20px;
    font-size: 14px;
}

.address-form {
    display: none;
}

.address-form.active {
    display: block;
}

.form-row {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}

.form-col {
    flex: 1;
}

.form-section {
    margin-bottom: 20px;
}

.form-section h6 {
    margin-bottom: 10px;
    color: #333;
    font-size: 14px;
    font-weight: 600;
}

.checkbox-group {
    margin: 15px 0;
}

.checkbox-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #666;
    cursor: pointer;
}

.textarea-field {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    resize: vertical;
    min-height: 80px;
    font-family: inherit;
}

.textarea-field:focus {
    outline: none;
    border-color: #4285f4;
}

@media (max-width: 768px) {
    .login-section {
        flex-direction: column;
        gap: 20px;
    }

    .form-row {
        flex-direction: column;
    }

    body {
        padding: 10px;
    }
}

.address-content {
    background: white;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.address-card {
    padding: 25px;
    border-bottom: 1px solid #eee;
    position: relative;
}

.address-card:last-child {
    border-bottom: none;
}

.address-header-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    /* margin-bottom: 15px; */
}

.address-edit button {
    background: #fff;
    color: #000;
    border: 1px solid;
    height: 30px;
    display: f;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.address-edit button:hover {
    color: #000 !important;
    border: 1px solid;
}

.address-name-type {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-left: 10px;
}

.address-name {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}
input{
    height:45px !important;
    margin-bottom: 0 !important;
}
.address-phone {
    color: #666;
    /* font-size: 14px; */
    font-weight: 500;
}

.address-text {
    color: #555;
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 15px;
}

.address-actions {
    display: flex;
    gap: 15px;
}

.add-address {
    padding: 20px 25px;
    background: #f8f9ff;
    border-top: 1px solid #eee;
}

.add-address-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #1a73e8;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: color 0.3s ease;
}

.add-address-btn:hover {
    color: #0d47a1;
}

.add-icon {
    width: 20px;
    height: 20px;
    background: #1a73e8;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    font-weight: bold;
}

.address-form {
    display: none;
    padding: 25px;
    background: #f8f9ff;
    border-top: 2px solid #e8f0fe;
}

.address-card-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
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