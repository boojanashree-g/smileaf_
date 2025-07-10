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
                            <h4 class="page-title fw-semibold fs-18 mb-0">Order Details</h4>

                        </div>
                        <!-- Page Header Close -->

                        <div class="card mb-6">
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
                        </div>

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
                                        <form id="status-form" class="row g-6" onsubmit="return false">

                                            <div class="col-xl-12 mb-6 mb-xl-0">

                                                <div class="row mb-6 g-6">
                                                    <div class="col-md">

                                                        <div
                                                            class="form-check custom-option custom-option-basic checked">

                                                            <label class="form-check-label custom-option-content"
                                                                for="customRadioAddress1">
                                                                <input name="customRadioTemp" class="form-check-input"
                                                                    type="radio" value="" id="customRadioAddress1"
                                                                    checked="">
                                                                <span class="custom-option-header mb-2">
                                                                    <span class="fw-medium text-heading mb-0">John Doe
                                                                        (Default)</span>

                                                                </span>
                                                                <span class="custom-option-body">
                                                                    <small>4135 Parkway Street, Los Angeles, CA,
                                                                        90017.<br> Mobile : 1234567890 Card / Cash on
                                                                        delivery available</small>


                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Select address -->
                                                <div class="row mb-6">
                                                    <div class="col-12">
                                                        <ul class="list-group list-group-horizontal-md">
                                                            <li class="list-group-item flex-fill p-6 text-body">
                                                                <h6
                                                                    class="d-flex align-items-center gap-2 order-header">
                                                                    <i class="ti ti-package"></i>Order Details
                                                                </h6>
                                                                <address class="mb-0">
                                                                    <div class="d-flex mb-1">
                                                                        <b class="me-2" style="min-width: 160px;">Order
                                                                            Status</b>: <span
                                                                            class="ms-2">Pending</span>
                                                                    </div>
                                                                    <div class="d-flex mb-1">
                                                                        <b class="me-2"
                                                                            style="min-width: 160px;">Razorpay
                                                                            OrderID</b>: <span
                                                                            class="ms-2">RP123456789</span>
                                                                    </div>
                                                                    <div class="d-flex mb-1">
                                                                        <b class="me-2" style="min-width: 160px;">Order
                                                                            ID</b>: <span class="ms-2">ORD12345</span>
                                                                    </div>
                                                                    <div class="d-flex mb-1">
                                                                        <b class="me-2" style="min-width: 160px;">Order
                                                                            Date</b>: <span
                                                                            class="ms-2">10-Jul-2025</span>
                                                                    </div>
                                                                </address>
                                                            </li>


                                                            <li class="list-group-item flex-fill p-5 text-body">
                                                                <h6
                                                                    class="d-flex align-items-center gap-2 order-header">
                                                                    <i class="ti ti-credit-card"></i> Payment Details
                                                                </h6>
                                                                <address class="mb-0">
                                                                    <div class="d-flex mb-1">
                                                                        <b class="me-2"
                                                                            style="min-width: 160px;">Payment
                                                                            Status</b>: <span
                                                                            class="ms-2">Pending</span>
                                                                    </div>
                                                                    <div class="d-flex mb-1">
                                                                        <b class="me-2"
                                                                            style="min-width: 160px;">Razorpay
                                                                            PaymentID</b>: <span
                                                                            class="ms-2">RP123456789</span>
                                                                    </div>
                                                                    <div class="d-flex mb-1">
                                                                        <b class="me-2"
                                                                            style="min-width: 160px;">Payment
                                                                            Method</b>: <span
                                                                            class="ms-2">ORD12345</span>
                                                                    </div>

                                                                </address>
                                                            </li>

                                                        </ul>


                                                        <div class="col-xl-12 mb-6 mb-xl-0 mt-2">
                                                            <div class="card">
                                                                <h5 class="card-header order-header"><i
                                                                        class="ti ti-shopping-cart"></i> Order Items
                                                                </h5>
                                                                <div class="table-responsive text-nowrap">
                                                                    <table class="table">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th>S.No</th>
                                                                                <th>Items</th>
                                                                                <th>Product name</th>
                                                                                <th>MRP</th>
                                                                                <th>Offer Type</th>
                                                                                <th>Offer Details</th>
                                                                                <th>Quantity</th>
                                                                                <th>Total Price</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table-border-bottom-0">
                                                                            <tr>
                                                                                <td>1.</td>
                                                                                <td class="sorting_1">
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                                        <div
                                                                                            class="avatar-wrapper me-3 rounded-2 bg-label-secondary">
                                                                                            <div class="avatar"><img
                                                                                                    src="<?= base_url() ?>public/assets/img/logo.png"
                                                                                                    alt="Product-8"
                                                                                                    class="rounded">
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </td>

                                                                                <td>
                                                                                    <div
                                                                                        class="d-flex flex-column justify-content-center">
                                                                                        <span
                                                                                            class="text-heading text-wrap fw-medium">TraRecommended
                                                                                            Tabler Icons for Order
                                                                                            ItemsvelTabler Icons for
                                                                                            Order Items</span>
                                                                                        <span
                                                                                            class="text-truncate mb-0 d-none d-sm-block"><small>Choose

                                                                                                brands</small></span>
                                                                                    </div>
                                                                                </td>
                                                                                <td>₹500
                                                                                </td>
                                                                                <td><span
                                                                                        class="badge bg-label-primary me-1">none</span>
                                                                                </td>
                                                                                <td>-
                                                                                </td>
                                                                                <td>1
                                                                                </td>
                                                                                <td>₹500</td>

                                                                            </tr>

                                                                            <tr>
                                                                                <td>2.</td>
                                                                                <td class="sorting_1">
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                                        <div
                                                                                            class="avatar-wrapper me-3 rounded-2 bg-label-secondary">
                                                                                            <div class="avatar"><img
                                                                                                    src="<?= base_url() ?>public/assets/img/logo.png"
                                                                                                    alt="Product-8"
                                                                                                    class="rounded">
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </td>

                                                                                <td>
                                                                                    <div
                                                                                        class="d-flex flex-column justify-content-center">
                                                                                        <span
                                                                                            class="text-heading text-wrap fw-medium">TraReco</span>
                                                                                        <span
                                                                                            class="text-truncate mb-0 d-none d-sm-block"><small>Choose

                                                                                                brands</small></span>
                                                                                    </div>
                                                                                </td>
                                                                                <td>₹500
                                                                                </td>
                                                                                <td><span
                                                                                        class="badge bg-label-primary me-1">none</span>
                                                                                </td>
                                                                                <td>-
                                                                                </td>
                                                                                <td>1
                                                                                </td>
                                                                                <td>₹500</td>

                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="4"></td>
                                                                                <td colspan="3">
                                                                                    <div class="fw-semibold"
                                                                                        style="text-align: right;">
                                                                                        Sub Total
                                                                                        :</div>
                                                                                </td>
                                                                                <td colspan="5">
                                                                                    <span class="fs-16 fw-semibold">
                                                                                        ₹300.00</span>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td colspan="4"></td>
                                                                                <td colspan="3">
                                                                                    <div class="fw-semibold"
                                                                                        style="text-align: right;">
                                                                                        CGST(Includes)
                                                                                        :</div>
                                                                                </td>
                                                                                <td colspan="5">
                                                                                    <span class="fs-16 fw-semibold">
                                                                                        ₹0.00</span>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td colspan="4"></td>
                                                                                <td colspan="3">
                                                                                    <div class="fw-semibold"
                                                                                        style="text-align: right;">
                                                                                        SGST(Includes)
                                                                                        :</div>
                                                                                </td>
                                                                                <td colspan="5">
                                                                                    <span class="fs-16 fw-semibold">
                                                                                        ₹0.00</span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="4"></td>
                                                                                <td colspan="3">
                                                                                    <div class="fw-semibold"
                                                                                        style="text-align: right;">
                                                                                        Shipping
                                                                                        :</div>
                                                                                </td>
                                                                                <td colspan="5">
                                                                                    <span class="fs-16 fw-semibold">
                                                                                        ₹100.00</span>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td colspan="4"></td>
                                                                                <td colspan="3">
                                                                                    <div class="fw-semibold"
                                                                                        style="text-align: right;">Total
                                                                                        Price :</div>
                                                                                </td>
                                                                                <td colspan="5">
                                                                                    <span class="fs-16 fw-semibold">
                                                                                        ₹400</span>
                                                                                </td>
                                                                            </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

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