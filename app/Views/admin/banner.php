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
                            <h4 class="page-title fw-semibold fs-18 mb-0">Manage Banner</h4>
                            <div class="ms-md-1 ms-0">
                                <nav>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item active" aria-current="page">Manage Banner</li>
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
                                            data-bs-target="#largeModal-" id="add-detail">Add
                                            Details</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered text-nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Title</th>
                                                        <th>Description (Small Text)</th>
                                                        <th>Description</th>
                                                        <th>Image</th>
                                                        <th>Link</th>
                                                        <th>Active Status</th>
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
                        <div class="modal fade" id="banner-modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-6">
                                            <h4 class="banner-title mb-2"></h4>
                                        </div>
                                        <form id="banner-form" class="row g-6" onsubmit="return false">
                                            <div class="col-12 col-md-12">
                                                <label class="form-label" for="banner_title">Title</label>
                                                <input type="text" id="banner_title" name="banner_title"
                                                    class="form-control" placeholder="Title*" />
                                                <span class="error text-danger banner_title mt-5"></span>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="banner_desc1">Description (Small
                                                    Text)</label>
                                                <input type="text" id="banner_desc1" name="banner_desc1"
                                                    class="form-control" placeholder="Description (Small Text)*" />
                                                <span class="error text-danger banner_desc1 mt-5"></span>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="banner_desc2">Description</label>
                                                <input type="text" id="banner_desc2" name="banner_desc2"
                                                    class="form-control" placeholder="Description*" />
                                                <span class="error text-danger banner_desc2 mt-5"></span>
                                            </div>

                                            <div class="col-12 col-md-12">
                                                <label for="banner_image" class="form-label">Banner Image</label>
                                                <input class="form-control" type="file" id="banner_image"
                                                    name="banner_image">
                                                <img src="" id="banner_image_url" alt="image" width="130px"
                                                    style="padding-top: 15px; display:none;">
                                                <span class="error text-danger banner_image mt-5"></span>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <label class="form-label" for="banner_link">Link</label>
                                                <input type="text" id="banner_link" name="banner_link"
                                                    class="form-control" placeholder="Link*" />
                                                <span class="error text-danger banner_link mt-5"></span>
                                            </div>
                                            <div class="col-12 text-end">
                                                <a class="btn btn-primary text-white" id="btn-submit"></a>

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
    <script src="<?php echo base_url(); ?>public/admin/custom/js/banner.js"></script>


</body>

</html>