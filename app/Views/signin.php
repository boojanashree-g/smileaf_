<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>

<body>



    <!-- Body main wrapper start -->
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>
        <!-- HEADER AREA END -->

        <!-- BREADCRUMB AREA START -->
        <?php require("components/breadcrumbs.php") ?>
        <!-- BREADCRUMB AREA END -->

        <!-- LOGIN AREA START -->
        <div class="ltn__login-area pb-65">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 signin_wrapper">
                        <div class="account-login-inner">
                            <!-- Tabs to choose login type -->
                            <ul class="nav nav-tabs" id="loginTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="otp-tab" data-bs-toggle="tab"
                                        data-bs-target="#otp-login" type="button" role="tab">Login (or) Signup with
                                        OTP</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " id="password-tab" data-bs-toggle="tab"
                                        data-bs-target="#password-login" type="button" role="tab">Login with
                                        Password</button>

                                </li>
                            </ul>

                            <div class="tab-content" id="loginTabContent">
                                <!-- OTP Login -->
                                <div class="tab-pane fade show active" id="otp-login" role="tabpanel">
                                    <form class="ltn__form-box contact-form-box" id="login-form">
                                        <input type="number" id="number" placeholder="Mobile Number*" name="number">
                                        <div class="btn-wrapper mt-0">
                                            <button type="button" class="theme-btn-1 btn reverse-color btn-block"
                                                id="btn-submit">Send OTP</button>

                                        </div>
                                    </form>
                                </div>

                                <!-- Username/Password Login -->
                                <div class="tab-pane fade " id="password-login" role="tabpanel">
                                    <form action="#" class="ltn__form-box contact-form-box">
                                        <input type="text" name="username" placeholder="Username or Email*" required>
                                        <input type="password" name="password" placeholder="Password*" required>
                                        <div class="btn-wrapper mt-0">
                                            <button type="submit"
                                                class="theme-btn-1 btn reverse-color btn-block">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-lg-6">
                    <div class="account-create text-center pt-50">
                        <h4>DON'T HAVE AN ACCOUNT?</h4>
                        <p>Add items to your wishlist, get personalised recommendations,<br>check out more quickly, track your orders, register</p>
                        <div class="btn-wrapper">
                            <a href="<?php echo base_url('signup') ?>" class="theme-btn-1 btn black-btn">CREATE ACCOUNT</a>
                        </div>
                    </div>
                </div> -->
                </div>
                <div class="modal fade" id="signinotp-modal" tabindex="-1" aria-labelledby="otpModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content p-3">
                            <div class="modal-header">
                                <h1 class="modal-title" id="otpModalLabel">OTP Verification</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Enter the 4-digit code sent to your device</p>
                                <div id="timer">Time remaining: 1:00</div>
                                <div class="otp-input d-flex justify-content-center my-3">
                                    <input type="number" class="otp-digit" maxlength="1" required>
                                    <input type="number" class="otp-digit" maxlength="1" required>
                                    <input type="number" class="otp-digit" maxlength="1" required>
                                    <input type="number" class="otp-digit" maxlength="1" required>
                                </div>


                                <button class="btn btn-success" id="verify-otp">Verify</button>
                                <button class="btn btn-link" id="resendButton" onclick="resendOTP()" disable>Resend
                                    Code</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LOGIN AREA END -->

            <!-- FOOTER AREA START -->
            <?php require("components/footer.php") ?>

            <!-- FOOTER AREA END -->

        </div>

        <!-- JS -->
        <script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
        <script src="<?php echo base_url() ?>public/assets/js/main.js"></script>
        <script src="<?php echo base_url() ?>custom/js/signin.js"></script>
</body>

</html>