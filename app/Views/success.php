<!DOCTYPE html>
<html lang="en">
<?php
require("components/head.php");
?>
<style>
    .success-animation {
        margin: 0 auto 30px auto;
    }

    .checkmark {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #4bb71b;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #4bb71b;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        position: relative;
        top: 5px;
        right: 5px;
        margin: 0 auto;
    }

    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #4bb71b;
        fill: #fff;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;

    }

    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }

    @keyframes scale {

        0%,
        100% {
            transform: none;
        }

        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }

    @keyframes fill {
        100% {
            box-shadow: inset 0px 0px 0px 30px #4bb71b;
        }
    }
</style>

<body>
    <div class="container mw-100">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success mb-0">
                    <div class="success-animation">
                        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                        </svg>
                    </div>
                    <h3><i>Payment Success</i></h3>

                    <span> Thank you for your payment. we will <br>be in contact with more details shortly </span>
                    <div class="confirm_order">
                        <a href="<?php echo base_url() ?>myaccount" type="button"
                            class="continue_shoppingBtn pay_btn prev-step me-4">
                            <i class="arrow_left"></i>ORDER SUMMARY
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);

    };
</script>



</html>