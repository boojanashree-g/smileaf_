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
                            <h4 class="page-title fw-semibold fs-18 mb-0">Manage Filters</h4>
                            <div class="ms-md-1 ms-0">
                                <nav>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item active" aria-current="page">Manage Filters</li>
                                        <li class="breadcrumb-item active" aria-current="page">Filter Types</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!-- Page Header Close -->


                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header d-grid  d-md-flex justify-content-md-end">
                                        <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            id="add-detail">Add
                                            Details</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered text-nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Type Name</th>
                                                        <th>Status</th>
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
                        <div class="modal fade" id="type-modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-simple">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-6">
                                            <h4 class="type-title mb-2"></h4>
                                        </div>
                                        <form id="menu-form" class="row g-6" onsubmit="return false">
                                            <div class="col-12 col-md-12">
                                                <label class="form-label" for="type_name">Type Name</label>
                                                <input type="text" id="type_name" name="type_name" class="form-control"
                                                    placeholder="Type Name*" />
                                                <span class="error text-danger type_name mt-5"></span>
                                            </div>

                                            <div class="col-12 text-end">
                                                <a class="btn btn-primary text-white" id="btn-submit"></a>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="status-modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-simple">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-6">
                                            <h4 class="status-title mb-2"></h4>
                                        </div>
                                        <form id="status-form" class="row g-6" onsubmit="return false">
                                            <div class="col-12 col-md-12">
                                                <label class="form-label" for="status">Status</label>
                                                <select id="update-status" class="form-select" name="status">
                                                    <option value="">Select Option</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>

                                                </select>
                                                <span class="error text-danger update-status mt-5"></span>
                                            </div>

                                            <div class="col-12 text-end">
                                                <a class="btn btn-primary text-white" id="submit-status">Submit</a>

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
    <script src="<?php echo base_url(); ?>public/admin/custom/js/filter-type.js"></script>


</body>

</html>