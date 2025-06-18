<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>
<style>
    h1 {
        margin-bottom: 1rem;
    }
</style>

<body class="inner-page">

    <!-- Body main wrapper start -->
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>
        <!-- HEADER AREA END -->

        <!-- BREADCRUMB AREA START -->
        <?php require("components/breadcrumbs.php") ?>
        <!-- BREADCRUMB AREA END -->

        <!-- LOGIN AREA START (Register) -->
        <div class="ltn__login-area pb-110">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-area text-center">
                            <h3 class="section-title">Register Account</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="account-login-inner">
                            <form class="signup_form contact-form-box" id="register-form">
                                <input type="text" name="username" id="username" placeholder="User Name">
                                <input type="text" name="number" id="number" placeholder="Mobile Number">
                                <input type="text" name="email" id="email" placeholder="Email">
                                <input type="password" name="password" id="password" placeholder="Password">
                                <input type="password" name="confirm_password" id="confirm_password"
                                    placeholder="Confirm Password">
                                <div class="btn-wrapper">
                                    <button class="theme-btn-1 btn reverse-color btn-block" id="registerButton">CREATE
                                        ACCOUNT</button>
                                </div>
                            </form>
                            <div class="by-agree text-center">
                                <p>By creating an account, you agree to our:</p>
                                <p><a href="<?php echo base_url('termsAndConditions') ?>">TERMS OF CONDITIONS</a> &nbsp;
                                    &nbsp; | &nbsp; &nbsp; <a href="<?php echo base_url('privacyPolicy') ?>">PRIVACY
                                        POLICY</a></p>
                                <div class="go-to-btn mt-50">
                                    <a href="<?php echo base_url('signin') ?>">ALREADY HAVE AN ACCOUNT ?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h1 class="modal-title" id="otpModalLabel">OTP Verification</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>Enter the 6-digit code sent to your device</p>
                        <div id="timer">Time remaining: 1:00</div>
                        <div class="otp-input d-flex justify-content-center my-3">
                            <input type="number" min="0" max="9" required>
                            <input type="number" min="0" max="9" required>
                            <input type="number" min="0" max="9" required>
                            <input type="number" min="0" max="9" required>
                            <input type="number" min="0" max="9" required>
                            <input type="number" min="0" max="9" required>
                        </div>
                        <button class="btn btn-success" onclick="verifyOTP()">Verify</button>
                        <button class="btn btn-link" id="resendButton" onclick="resendOTP()" disabled>Resend
                            Code</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- LOGIN AREA END -->

        <!-- FOOTER AREA START -->
        <?php require("components/footer.php") ?>
        <!-- FOOTER AREA END -->

    </div>
    <!-- Body main wrapper end -->

    <!-- All JS Plugins -->
    <script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
    <!-- Main JS -->
    <script src="<?php echo base_url() ?>public/assets/js/main.js"></script>
    <script src="<?php echo base_url() ?>custom/js/signup.js"></script>


</body>

</html>