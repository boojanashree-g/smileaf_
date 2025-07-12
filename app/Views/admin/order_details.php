<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr"
    data-theme="theme-default" data-assets-path="<?php echo base_url(); ?>assets/"
    data-template="vertical-menu-template" data-style="light">

<?php require "components/head.php"; ?>


<body>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5J3LMKC" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>

    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">

            <!-- Menu -->
            <?php require "components/sidenavbar.php"; ?>
            <!-- / Menu -->

            <div class="layout-page">

                <?php require "components/topnavbar.php"; ?>


                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <!-- Page Header -->
                        <div
                            class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                            <h4 class="page-title fw-semibold fs-18 mb-0">
                                <?php echo $orderStatus = $order_status ? $order_status . '&nbsp;Order Details' : 'Order Details'; ?>
                            </h4>


                        </div>
                        <!-- Page Header Close -->

                        <!-- <div class="card mb-6">
                            <div class="card-widget-separator-wrapper">
                                <div class="card-body card-widget-separator">
                                    <div class="row gy-4 gy-sm-1">
                                        <div class="col-sm-6 col-lg-3">
                                            <div
                                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                                                <div>
                                                    <h4 class="mb-0">56</h4>
                                                    <p class="mb-0">Pending Payment</p>
                                                </div>
                                                <span class="avatar me-sm-6">
                                                    <span
                                                        class="avatar-initial bg-label-secondary rounded text-heading">
                                                        <i class="ti-26px ti ti-calendar-stats text-heading"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <hr class="d-none d-sm-block d-lg-none me-6">
                                        </div>
                                        <div class="col-sm-6 col-lg-3">
                                            <div
                                                class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                                                <div>
                                                    <h4 class="mb-0">12,689</h4>
                                                    <p class="mb-0">Completed</p>
                                                </div>
                                                <span class="avatar p-2 me-lg-6">
                                                    <span class="avatar-initial bg-label-secondary rounded"><i
                                                            class="ti-26px ti ti-checks text-heading"></i></span>
                                                </span>
                                            </div>
                                            <hr class="d-none d-sm-block d-lg-none">
                                        </div>
                                        <div class="col-sm-6 col-lg-3">
                                            <div
                                                class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                                                <div>
                                                    <h4 class="mb-0">124</h4>
                                                    <p class="mb-0">Refunded</p>
                                                </div>
                                                <span class="avatar p-2 me-sm-6">
                                                    <span class="avatar-initial bg-label-secondary rounded"><i
                                                            class="ti-26px ti ti-wallet text-heading"></i></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="mb-0">32</h4>
                                                    <p class="mb-0">Failed</p>
                                                </div>
                                                <span class="avatar p-2">
                                                    <span class="avatar-initial bg-label-secondary rounded"><i
                                                            class="ti-26px ti ti-alert-octagon text-heading"></i></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->



                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered text-nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Order No</th>
                                                        <th>Customer Name</th>
                                                        <th>Order Date</th>
                                                        <th>Order Details</th>
                                                        <th>Order Status</th>
                                                        <th>Payment Status</th>
                                                        <th>Delivery Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- data -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="order_status"
                            value="<?= !empty($order_status) ? $order_status : '' ?>">

                        <!-- Add Modal -->
                        <div class="modal fade" id="vieworder-modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-simple">
                                <div class="modal-content order-view-modal">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            style="right: 1px;top: 2px" aria-label="Close"></button>
                                        <div class="text-center mb-6">
                                            <h4 class="status-title mb-2">Order Details</h4>
                                        </div>
                                        <form id="orderDetails" class="row g-6">

                                            <!-- Dynamic Order Details -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="tracking-modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-simple">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-6">
                                            <h4 class="status-title mb-2">Edit Tracking Details</h4>
                                        </div>
                                        <form id="tracking_details_form" class="row g-6" onsubmit="return false">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="courier_partner">Courier Partner</label>
                                                <input type="text" id="courier_partner" name="courier_partner"
                                                    class="form-control" placeholder="Courier Partner*" />
                                                <span class="error text-danger courier_partner mt-5"></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="tracking_link">Courier Tracking
                                                    Link</label>
                                                <input type="text" id="tracking_link" name="tracking_link"
                                                    class="form-control" placeholder="Tracking link*" />
                                                <span class="error text-danger tracking_link mt-5"></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="tracking_id">Tracking ID</label>
                                                <input type="text" id="tracking_id" name="tracking_id"
                                                    class="form-control" placeholder="Tracking ID*" />
                                                <span class="error text-danger tracking_id mt-5"></span>
                                            </div>
                                            <div class="col-12 col-md-6">`
                                                <label class="form-label" for="bill_no">Bill No</label>
                                                <input type="text" id="bill_no" name="bill_no" class="form-control"
                                                    placeholder="Bill No*" />
                                                <span class="error text-danger bill_no mt-5"></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="submenu">Bill Date</label>
                                                <input class="form-control" type="datetime-local" value=""
                                                    id="bill_date" name="bill_date">
                                                <span class="error text-danger submenu mt-5"></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="submenu">Delivery Date</label>
                                                <input class="form-control" type="datetime-local" value=""
                                                    id="delivery_date" name="delivery_date">
                                                <span class="error text-danger submenu mt-5"></span>
                                            </div>
                                            <div class="col-12 text-end">
                                                <a class="btn btn-primary text-white" id="update-tracking">Update</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Modal -->


                    </div>
                </div>

                <!-- Footer -->
                <?php require "components/bottomfooter.php"; ?>
                <!-- / Footer -->

            </div>
        </div>
    </div>

    </div>


    <?php require "components/footer.php"; ?>
    <script src="<?php echo base_url(); ?>public/admin/custom/js/order-details.js"></script>


</body>

</html>