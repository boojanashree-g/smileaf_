<!DOCTYPE html>
<html lang="en">
<?php
require("components/head.php");
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success mb-0">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2> Your payment was <?php echo $status ?> </h2>
                    <p><strong>Order id :</strong> <?php echo $orderid ?></p>
                    <p><strong>Payment id :</strong> <?php echo $paymentid ?></p>
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

</html>