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

    .datetime {
        display: block;
        font-size: 11px;
        color: #999;
        margin-top: 2px;
    }
</style>

<body>

    <div class="body-wrapper">
        <?php require("components/header.php") ?>

        <div class="ltn__login-area my-5">
            <div class="container">


                <div class="row justify-content-center">
                    <!-- Courier Details -->
                    <div class="col-lg-5 col-md-10 mb-4">
                        <div class="account-login-inner p-4 section-bg-1 rounded shadow-sm h-100">
                            <h3 class="mb-4 fw-semibold text-center">Courier Details</h3>

                            <div class="row mb-3">
                                <div class="col-sm-4 text-start fw-bold">Courier Partner:</div>
                                <div class="col-sm-8 text-start">
                                    <?= trim($tracking_details['courier_partner'] ?? '') !== '' ? $tracking_details['courier_partner'] : '-' ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4 text-start fw-bold">Tracking ID:</div>
                                <?= trim($tracking_details['tracking_id'] ?? '') !== '' ? $tracking_details['tracking_id'] : '-' ?>

                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4 text-start fw-bold">URL:</div>
                                <div class="col-sm-8 text-start text-primary">
                                    <a href="<?= trim($tracking_details['tracki ng_link'] ?? '') !== '' ? $tracking_details['tracking_link'] : '#' ?>"
                                        target="_blank">
                                        <?= trim($tracking_details['tracking_link'] ?? '') !== '' ? $tracking_details['tracking_link'] : '-' ?></a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" id="order_id" value="<?= $order_id ?>" />

                    <div class="col-lg-7 col-md-10 mb-4 mx-0 account-login-inner p-4 section-bg-1 rounded shadow-sm h-100">
                        <h3 class="mb-4 fw-semibold text-center">Order Details</h3>
                        <div class="order-tracking-status d-none ">
                            <div class="track">
                                <?php
                                $statuses = ['Order Placed', 'Shipped', 'Delivered'];
                                $icons = ['fa-check', 'fa-box', 'fa-truck'];
                                foreach ($statuses as $index => $label):
                                    ?>
                                    <div class="step">
                                        <span class="icon"><i class="fas <?= $icons[$index] ?>"></i></span>
                                        <span class="text"><?= $label ?></span>
                                        <span class="datetime">--</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php require("components/footer.php") ?>
    </div>

    <script src="<?php echo base_url() ?>custom/js/ordertracking.js"></script>
</body>

</html>