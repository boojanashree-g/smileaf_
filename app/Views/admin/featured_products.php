<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr"
    data-theme="theme-default" data-assets-path="<?php echo base_url(); ?>assets/"
    data-template="vertical-menu-template" data-style="light">

<?php require "components/head.php"; ?>

<body>
    <!-- Loader -->
    <div id="ajax-loader" class="d-none">
        <div class="loader"></div>
    </div>

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
                            <h4 class="page-title fw-semibold fs-18 mb-0">Manage Featured Products</h4>
                            <div class="ms-md-1 ms-0">
                                <nav>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item active" aria-current="page">Manage Featured Products
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Featured Products</li>
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
                                                        <th>SubMenu</th>
                                                        <th>Image</th>
                                                        <th>Product Name</th>
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
                        <div class="modal fade" id="product-modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-simple">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-6">
                                            <h4 class="subcat-title mb-2"></h4>
                                        </div>
                                        <form id="featured-product-form" class="row g-6" onsubmit="return false">
                                            <div class="col-12 col-md-6 col-lg-6">
                                                <label class="form-label">Sub Menu</label>
                                                <select id="sub_id" name="sub_id" class="form-select">
                                                    <option value="">Select Submenu</option>
                                                    <?php foreach ($submenu as $row): ?>
                                                        <option value="<?= esc($row['sub_id']) ?>">
                                                            <?= esc($row['submenu']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="error text-danger sub_id mt-5"></span>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-6">
                                                <label class="form-label" for="prod_name">Product Name</label>
                                                <input type="text" id="prod_name" name="prod_name" class="form-control"
                                                    placeholder="Product Name*" />
                                                <span class="error text-danger prod_name mt-5"></span>
                                            </div>

                                            <div class="col-5 col-md-6 col-lg-6">
                                                <label for="main_image" class="form-label">Product Image(Allowed size
                                                    below 500KB)</label>
                                                <input class="form-control" type="file" id="main_image"
                                                    name="main_image" accept="image/*">

                                                <span class="error text-danger main_image mt-5"></span>
                                            </div>
                                            <div class="col-1 col-md-1">
                                                <img src="" id="main_image_url" alt="image" width="80px" height="80px"
                                                    style="display:none;">
                                            </div>



                                            <div class="col-12 text-end">
                                                <a class="btn btn-primary text-white" id="btn-submit">Submit</a>

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
    <script src="<?php echo base_url(); ?>public/admin/custom/js/featured-product.js"></script>
    <!-- <! File upload js---->
    <script src="<?php echo base_url() ?>public/admin/js/forms-file-upload.js"></script>


</body>

</html>