<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr"
    data-theme="theme-default" data-assets-path="<?php echo base_url() ?>assets/" data-template="vertical-menu-template"
    data-style="light">
<title>Dashboard</title>


<?php require("components/head.php"); ?>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">
            <!-- Menu -->
            <?php require("components/sidenavbar.php"); ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Navbar -->
                <?php require("components/topnavbar.php"); ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row g-6">


                            <!-- Cards Draggable -->
                            <div class="row mb-6" id="sortable-cards">

                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="<?= base_url('admin/order-details?status=New') ?>"
                                        class="text-decoration-none">
                                        <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                            <div class="card-body text-center">
                                                <h2>
                                                    <i class="ti ti-shopping-cart text-primary display-6"></i>
                                                </h2>
                                                <h5 class="text-dark">New Orders</h5>
                                                <h5 class="text-dark"><?= $neworder_count ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="<?= base_url('admin/order-details?status=Readytoship') ?>"
                                        class="text-decoration-none">
                                        <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                            <div class="card-body text-center">
                                                <h2>
                                                    <i class="ti ti-truck-loading text-secondary display-6"></i>
                                                </h2>
                                                <h5>Ready to ship</h5>
                                                <h5><?= $readytoship_count ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="<?= base_url('admin/order-details?status=Shipped') ?>"
                                        class="text-decoration-none">
                                        <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                            <div class="card-body text-center">
                                                <h2>
                                                    <i class="ti ti-package text-info display-6"></i>
                                                </h2>
                                                <h5>Shipped Orders</h5>
                                                <h5><?= $shipping_count ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="<?= base_url('admin/order-details?status=Delivered') ?>"
                                        class="text-decoration-none">
                                        <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                            <div class="card-body text-center">
                                                <h2>
                                                    <i class="ti ti-truck-delivery text-success display-6"></i>

                                                </h2>
                                                <h5>Delivered Orders</h5>
                                                <h5><?= $delivered_count ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </div>

                            <div class="row mb-6" id="sortable-cards">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="<?= base_url('admin/order-details?status=Pending') ?>"
                                        class="text-decoration-none">
                                        <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                            <div class="card-body text-center">
                                                <h2>
                                                    <i class="ti ti-clock text-warning display-6"></i>

                                                </h2>
                                                <h5>Pending Orders</h5>
                                                <h5><?= $pending_count ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="<?= base_url('admin/order-details?status=Cancelled') ?>"
                                        class="text-decoration-none">
                                        <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                            <div class="card-body text-center">
                                                <h2>
                                                    <i class="ti ti-box-off text-danger display-6"></i>

                                                </h2>
                                                <h5>Cancel Orders</h5>
                                                <h5><?= $cancel_count ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="<?= base_url('admin/order-details?status=Returned') ?>"
                                        class="text-decoration-none">
                                        <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                            <div class="card-body text-center">
                                                <h2>
                                                    <i class="ti ti-package-import text-info display-6"></i>


                                                </h2>
                                                <h5>Returned Orders</h5>
                                                <h5><?= $returned_count ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="<?= base_url('admin/order-details?status=Refund') ?>"
                                        class="text-decoration-none">
                                        <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                            <div class="card-body text-center">
                                                <h2>
                                                    <i class="ti ti-rotate-clockwise-2 text-primary display-6"></i>

                                                </h2>
                                                <h5>Refund Orders</h5>
                                                <h5><?= $refund_count ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div> -->

                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="<?= base_url('admin/order-details?status=Failed') ?>"
                                        class="text-decoration-none">
                                        <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                            <div class="card-body text-center">
                                                <h2>
                                                    <i class="ti ti-credit-card-off text-danger display-6"></i>

                                                </h2>
                                                <h5>Payment Failures</h5>
                                                <h5><?= $failed_count ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /Cards Draggable ends -->

                    </div>
                </div>
                <!-- / Content -->


                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>

    </div>




    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>

    </div>



    <?php require("components/footer.php"); ?>



</body>

</html>