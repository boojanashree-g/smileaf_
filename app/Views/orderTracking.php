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

    <div class="ltn__login-area mt-25">
        <div class="container">
            <?php
            $status = 'Shipped';
            $statuses = ['Order Placed', 'Shipped', 'Delivered'];
            $icons = ['fa-check', 'fa-box', 'fa-truck'];
            $timestamps = [
                'Order Placed' => '2025-06-09 10:15 AM',
                'Shipped' => '2025-06-10 09:00 AM',
                'Delivered' => '--',
            ];
            ?>

            <div class="row justify-content-center">
                <!-- Courier Details -->
                <div class="col-lg-5 col-md-10 mb-4">
                    <div class="account-login-inner p-4 section-bg-1 rounded shadow-sm h-100">
                        <h3 class="mb-4 fw-semibold text-center">Courier Details</h3>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 text-start fw-bold">Courier Partner:</div>
                            <div class="col-sm-8 text-start">Test</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4 text-start fw-bold">Courier ID:</div>
                            <div class="col-sm-8 text-start">2325888R</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4 text-start fw-bold">URL:</div>
                            <div class="col-sm-8 text-start text-primary">
                                <a href="https://example.com" target="_blank">https://example.com</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Tracking Progress -->
                <div class="col-lg-7 col-md-10 mb-4">
                    <div class="account-login-inner p-4 section-bg-1 rounded shadow-sm h-100">
                        <h3 class="mb-4 fw-semibold text-center">Order Tracking</h3>
                        <div class="order-tracking-status">
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
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div>

    <?php require("components/footer.php") ?>
</div> <!-- body-wrapper -->

<script src="<?php echo base_url() ?>custom/js/ordertracking.js"></script>
</body>
</html>
