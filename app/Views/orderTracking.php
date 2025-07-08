<!doctype html>
<html class="no-js" lang="zxx">
<?php require("components/head.php") ?>

<style>
    .order-tracking-status {
        text-align: center;
        margin-top: 40px;
    }

    .track {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px 10px;
    }

    .track::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 4px;
        background: #ddd;
        top: 38px;
        left: 0;
        z-index: 0;
    }

    .step {
        position: relative;
        z-index: 1;
        flex: 1;
        text-align: center;
    }

    .step .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        background: #ddd;
        border-radius: 50%;
        color: white;
        font-size: 18px;
        margin-bottom: 8px;
        position: relative;
        z-index: 2;
    }

    .step.active .icon {
        background: #28a745;
    }

    .step .text {
        display: block;
        font-size: 13px;
        margin-top: 4px;
        color: #888;
    }

    .step.active .text {
        color: #28a745;
    }
</style>

<body>

    <!-- Body main wrapper start -->
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>
        <!-- HEADER AREA END -->

        <!-- BREADCRUMB AREA START -->
        <!-- BREADCRUMB AREA END -->

        <!-- LOGIN AREA START -->
        <div class="ltn__login-area mt-35">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 ">
                        <div class="account-login-inner section-bg-1">
                            <form class="ltn__form-box contact-form-box">
                                <p class="text-center"> To track your order enter your Order ID in the box below
                                    and press the "Track Order" button. </p>
                                <input type="text" name="text" placeholder="Enter Order ID." name="order_id"
                                    id="order_id">
                                <input type="hidden" name="text" id="main-id" value="<?= $order_id ?>">
                                <div class="btn-wrapper mt-0 text-center">
                                    <button class="btn theme-btn-1 btn-effect-1 text-uppercase" id="showProgressBtn"
                                        type="submit">Track Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $status = 'Shipped';
            $statuses = ['Order Placed', 'Shipped', 'Delivered'];
            $icons = ['fa-check', 'fa-box', 'fa-truck', 'fa-home'];
            $timestamps = [
                'Order Placed' => '2025-06-09 10:15 AM',

                'Shipped' => '2025-06-10 09:00 AM',
                'Delivered' => '--',
            ];
            ?>

            <!-- Order Tracking Progress Bar -->
            <div class="order-tracking-status mt-5 d-none">
                <div class="track">
                    <?php foreach ($statuses as $index => $s):
                        $isActive = array_search($s, $statuses) <= array_search($status, $statuses) ? 'active' : '';
                        ?>
                        <div class="step <?php echo $isActive; ?>">
                            <span class="icon"><i class="fas <?php echo $icons[$index]; ?>"></i></span>
                            <span class="text"><?php echo $s; ?></span>
                            <span class="datetime"><?php echo $timestamps[$s]; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>



            <!-- LOGIN AREA END -->


            <!-- FOOTER AREA START -->
            <?php require("components/footer.php") ?>

            <!-- FOOTER AREA END -->

        </div>
        <!-- Body main wrapper end -->

        <script src="<?php echo base_url() ?>custom/js/ordertracking.js"></script>
</body>

</html>