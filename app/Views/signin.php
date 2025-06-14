<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php")?>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

<!-- Body main wrapper start -->
<div class="body-wrapper">

    <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php")?>
    <!-- HEADER AREA END -->

    <!-- BREADCRUMB AREA START -->
            <?php require("components/breadcrumbs.php")?>
    <!-- BREADCRUMB AREA END -->

    <!-- LOGIN AREA START -->
    <div class="ltn__login-area pb-65">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 signin_wrapper">
                    <div class="account-login-inner">
                        <!-- Tabs to choose login type -->
                        <ul class="nav nav-tabs" id="loginTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-login" type="button" role="tab">Login with Password</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="otp-tab" data-bs-toggle="tab" data-bs-target="#otp-login" type="button" role="tab">Login with OTP</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="loginTabContent">
                            <!-- Username/Password Login -->
                            <div class="tab-pane fade show active" id="password-login" role="tabpanel">
                                <form action="#" class="ltn__form-box contact-form-box">
                                    <input type="text" name="username" placeholder="Username or Email*" required>
                                    <input type="password" name="password" placeholder="Password*" required>
                                    <div class="btn-wrapper mt-0">
                                        <button type="submit" class="theme-btn-1 btn reverse-color btn-block">Login</button>
                                    </div>
                                </form>
                            </div>

                            <!-- OTP Login -->
                            <div class="tab-pane fade" id="otp-login" role="tabpanel">
                                <form class="ltn__form-box contact-form-box">
                                    <input type="text" id="number" placeholder="Mobile Number*" name="number">
                                    <div class="btn-wrapper mt-0">
                                         <button type="button" class="theme-btn-1 btn reverse-color btn-block" id="registerButton">Send OTP</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="account-create text-center pt-50">
                        <h4>DON'T HAVE AN ACCOUNT?</h4>
                        <p>Add items to your wishlist, get personalised recommendations,<br>check out more quickly, track your orders, register</p>
                        <div class="btn-wrapper">
                            <a href="<?php echo base_url('signup') ?>" class="theme-btn-1 btn black-btn">CREATE ACCOUNT</a>
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
                            <button class="btn btn-link" id="resendButton" onclick="resendOTP()" disabled>Resend Code</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- LOGIN AREA END -->

    <!-- FOOTER AREA START -->
    <?php require("components/footer.php")?>

    <!-- FOOTER AREA END -->

</div>

<!-- JS -->
<script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
<script src="<?php echo base_url() ?>public/assets/js/main.js"></script>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    const otpTab = document.getElementById('otp-login');
        const otpInputs = document.querySelectorAll('.otp-input input');
        const timerDisplay = document.getElementById('timer');
        const resendButton = document.getElementById('resendButton');
        let timeLeft = 60;
        let timerId;

    // Bootstrap tab shown event
    document.querySelector('button[data-bs-target="#otp-login"]')
        ?.addEventListener('shown.bs.tab', function () {
            const form = otpTab.querySelector('.contact-form-box');
            const createAccountBtn = otpTab.querySelector('#registerButton');

            if (createAccountBtn) {
                createAccountBtn.addEventListener('click', function () {
                    const number = form.querySelector('input[name="number"]');
                    if (!number) return;
                    let isValid = true;
                    let errorMessage = '';
                    number.style.borderColor = '';

                    if (!number.value.trim()) {
                        isValid = false;
                        number.style.borderColor = 'red';
                        errorMessage = 'Please enter your mobile number.';
                    }

                    if (!isValid) {
                        showToast(errorMessage, 'error');
                        return;
                    }

                    const modal = new bootstrap.Modal(document.getElementById('otpModal'));
                    modal.show();
                    startOTPTimer();
                });
            }
        });
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

