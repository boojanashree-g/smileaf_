<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr"
    data-theme="theme-default" data-assets-path="<?php echo base_url(); ?>assets/"
    data-template="vertical-menu-template" data-style="light">

<?php require "components/head.php"; ?>
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
</style>

<body>
        <!-- Loader -->
    <div id="ajax-loader" class="d-none">
        <div class="loader"></div>
    </div>
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
                            <h4 class="page-title fw-semibold fs-18 mb-0">Manage Headers</h4>
                            <div class="ms-md-1 ms-0">
                                <nav>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item active" aria-current="page">Manage Headers</li>
                                        <li class="breadcrumb-item active" aria-current="page">Sub Menu</li>
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
                                                        <th>Menu</th>
                                                        <th>SubMenu</th>
                                                        <th>GST</th>
                                                        <th>Status</th>
                                                        <th>Image</th>
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
                        <div class="modal fade" id="submenu-modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-simple">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-6">
                                            <h4 class="submenu-title mb-2"></h4>
                                        </div>
                                        <form id="submenu-form" class="row g-6" onsubmit="return false">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" >Menu</label>
                                                <select class="form-select" for="menu_id" name="menu_id"
                                                    id="menu_id">
                                                    <option value="">Select Menu</option>
                                                    <?php foreach($menu as $mainmenu)
                                                    { ?>
                                                      <option value="<?= $mainmenu['menu_id'] ?>"><?= $mainmenu['menu_name'] ?></option>
                                                    <?php } ?>
                                                
                                                </select>
                                                <span class="error text-danger menu_id mt-5"></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="submenu">SubMenu</label>
                                                <input type="text" id="submenu" name="submenu" class="form-control"
                                                    placeholder="Submenu*" />
                                                <span class="error text-danger submenu mt-5"></span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="gst">GST</label>
                                                <input type="number" id="gst" name="gst" class="form-control"
                                                    placeholder="GST" />
                                                <span class="error text-danger gst mt-5"></span>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label for="image_url" class="form-label">Image</label>
                                                <input class="form-control" type="file" id="image_url"
                                                    name="image_url" accept="image/png, image/jpeg, image/jpg">
                                                <img src="" id="image_url_disp" alt="image" width="130px"
                                                    style="padding-top: 15px; display:none;">
                                                <span class="error text-danger image_url mt-5"></span>
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
    <script src="<?php echo base_url(); ?>public/admin/custom/js/submenu.js"></script>


</body>

</html>