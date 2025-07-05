<!DOCTYPE html>
<html lang="en">
<?php
require("components/head.php");
?>

<body>
    <div class="container mt-10">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success _failed">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                    <h2> Your payment was Failed </h2>
                    <p><strong>Payment id :</strong> <?php echo $payment_id ?></p>
                    <p><strong>Reason :</strong> <?php echo $reason ?></p>

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

</html>