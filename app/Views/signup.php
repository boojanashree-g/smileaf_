<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php")?>
<style>
h1 {
    margin-bottom: 1rem;
}

</style>

<body class="inner-page">

    <!-- Body main wrapper start -->
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
            <?php require("components/header.php")?>
        <!-- HEADER AREA END -->

        <!-- BREADCRUMB AREA START -->
            <?php require("components/breadcrumbs.php")?>
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
                            <form class="ltn__form-box contact-form-box">
                                <input type="text" name="firstname" placeholder="First Name">
                                <input type="text" name="mobile_number" placeholder="Mobile Number">
                                <input type="text" name="email" placeholder="Email">
                                <input type="password" name="password" placeholder="Password">
                                <input type="password" name="confirmpassword" placeholder="Confirm Password">
                                <div class="btn-wrapper">
                                    <button class="theme-btn-1 btn reverse-color btn-block" id="registerButton">CREATE
                                        ACCOUNT</button>
                                </div>
                            </form>
                            <div class="by-agree text-center">
                                <p>By creating an account, you agree to our:</p>
                                <p><a href="<?php echo base_url('termsAndConditions')?>">TERMS OF CONDITIONS</a> &nbsp;
                                    &nbsp; | &nbsp; &nbsp; <a href="<?php echo base_url('privacyPolicy')?>">PRIVACY
                                        POLICY</a></p>
                                <div class="go-to-btn mt-50">
                                    <a href="<?php echo base_url('signin')?>">ALREADY HAVE AN ACCOUNT ?</a>
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
    <script src="<?php echo base_url()?>public/assets/js/plugins.js"></script>
    <!-- Main JS -->
    <script src="<?php echo base_url()?>public/assets/js/main.js"></script>
    <script>



    document.addEventListener('DOMContentLoaded', function() {

        // e.preventDefault();
        console.log("Register button clicked"); // Debugging

        const createAccountBtn = document.getElementById('registerButton');
        const otpInputs = document.querySelectorAll('.otp-input input');
        const timerDisplay = document.getElementById('timer');
        const resendButton = document.getElementById('resendButton');
        let timeLeft = 60;
        let timerId;

        // Form validation and modal control
        if (createAccountBtn) {
            createAccountBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const form = document.querySelector('.ltn__form-box');
                const firstName = form.querySelector('input[name="firstname"]');
                const mobile_number = form.querySelector('input[name="mobile_number"]');
                const email = form.querySelector('input[name="email"]');
                const password = form.querySelector('input[name="password"]');
                const confirmPassword = form.querySelector('input[name="confirmpassword"]');

                let isValid = true;
                let errorMessage = '';

                // Reset previous error styling
                [firstName, mobile_number, email, password, confirmPassword].forEach(input => {
                    input.style.borderColor = '';
                });

                // Validate each field
                if (!firstName.value.trim()) {
                    isValid = false;
                    firstName.style.borderColor = 'red';
                    errorMessage = 'Please enter your first name.';
                }

                if (!mobile_number.value.trim()) {
                    isValid = false;
                    mobile_number.style.borderColor = 'red';
                    errorMessage = 'Please enter your mobile number.';
                }

                if (!email.value.trim()) {
                    isValid = false;
                    email.style.borderColor = 'red';
                    errorMessage = 'Please enter your email address.';
                } else if (!isValidEmail(email.value.trim())) {
                    isValid = false;
                    email.style.borderColor = 'red';
                    errorMessage = 'Please enter a valid email address.';
                }

                if (!password.value.trim()) {
                    isValid = false;
                    password.style.borderColor = 'red';
                    errorMessage = 'Please enter a password.';
                } else if (password.value.length < 6) {
                    isValid = false;
                    password.style.borderColor = 'red';
                    errorMessage = 'Password must be at least 6 characters long.';
                }

                if (!confirmPassword.value.trim()) {
                    isValid = false;
                    confirmPassword.style.borderColor = 'red';
                    errorMessage = 'Please confirm your password.';
                } else if (password.value !== confirmPassword.value) {
                    isValid = false;
                    password.style.borderColor = 'red';
                    confirmPassword.style.borderColor = 'red';
                    errorMessage = 'Passwords do not match.';
                }

                if (!isValid) {
                    showToast(errorMessage, 'error');
                    return;
                }

                // All validations passed - open the OTP modal
                const modal = new bootstrap.Modal(document.getElementById('otpModal'));
                modal.show();

                // Start OTP timer
                startOTPTimer();
            });
        }

        // OTP Timer functions
        function startOTPTimer() {
            clearInterval(timerId);
            timeLeft = 60;
            otpInputs.forEach(input => {
                input.value = '';
                input.disabled = false;
            });
            resendButton.disabled = true;
            otpInputs[0].focus();

            updateTimerDisplay();
            timerId = setInterval(updateTimer, 1000);
        }

        function updateTimer() {
            timeLeft--;
            updateTimerDisplay();

            if (timeLeft <= 0) {
                clearInterval(timerId);
                timerDisplay.textContent = "Code expired";
                resendButton.disabled = false;
                otpInputs.forEach(input => input.disabled = true);
            }
        }

        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `Time remaining: ${minutes}:${seconds.toString().padStart(2, '0')}`;
        }

        function resendOTP() {
            showToast("New OTP sent!", 'success');
            startOTPTimer();
        }

        // OTP input handling
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length > 1) {
                    e.target.value = e.target.value.slice(0, 1);
                }
                if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
                if (e.key === 'e') {
                    e.preventDefault();
                }
            });
        });

        function verifyOTP() {
            const otp = Array.from(otpInputs).map(input => input.value).join('');
            if (otp.length === 6) {
                if (timeLeft > 0) {
                    // Here you would typically send the OTP to your server for verification
                    showToast("Verifying OTP...", 'info');
                    // Simulate verification
                    setTimeout(() => {
                        showToast("Account created successfully!", 'success');
                        const modal = bootstrap.Modal.getInstance(document.getElementById('otpModal'));
                        modal.hide();
                        // Redirect or do something after successful verification
                    }, 1500);
                } else {
                    showToast('OTP has expired. Please request a new one.', 'error');
                }
            } else {
                showToast('Please enter a 6-digit OTP', 'error');
            }
        }

        // Helper functions
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function showToast(message, type = 'info') {
            const existingToast = document.querySelector('.custom-toast');
            if (existingToast) {
                existingToast.remove();
            }

            const toast = document.createElement('div');
            toast.className = `custom-toast toast-${type}`;

            toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 16px 20px;
            background: ${type === 'error' ? '#f8d7da' : type === 'success' ? '#d1e7dd' : '#cff4fc'};
            color: ${type === 'error' ? '#721c24' : type === 'success' ? '#0f5132' : '#055160'};
            border: 1px solid ${type === 'error' ? '#f1aeb5' : type === 'success' ? '#a3cfbb' : '#b8daff'};
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            min-width: 300px;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        `;

            const icon = type === 'error' ? '❌' : type === 'success' ? '✅' : 'ℹ️';
            toast.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 16px;">${icon}</span>
                <span style="flex: 1;">${message}</span>
                <span style="margin-left: 10px; cursor: pointer; font-weight: bold; opacity: 0.7;">&times;</span>
            </div>
        `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
                toast.style.opacity = '1';
            }, 10);

            const autoRemove = setTimeout(() => {
                removeToast(toast);
            }, 5000);

            toast.addEventListener('click', () => {
                clearTimeout(autoRemove);
                removeToast(toast);
            });
        }

        function removeToast(toast) {
            if (toast && toast.parentNode) {
                toast.style.transform = 'translateX(100%)';
                toast.style.opacity = '0';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }
        }
    });
    </script>
</body>

</html>