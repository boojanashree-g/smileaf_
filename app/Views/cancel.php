<!DOCTYPE html>
<html lang="en">
<?php
require("components/head.php");
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success _failed">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                    <h2> Your payment was Cancelled </h2>
                    <p><strong>Reason :</strong> <?= $cancel_reason ?></p>

                    <div class="payment_failed">
                        <a href="<?= base_url() ?>myaccount" type="button"
                            class="continue_shoppingBtn pay_btn prev-step me-4">
                            Try Again Later
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