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
                                    <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                        <div class="card-body text-center">
                                            <h2>
                                                <i class="ti ti-shopping-cart text-success display-6"></i>
                                            </h2>
                                            <h4>Monthly Sales</h4>
                                            <h5>2362</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                        <div class="card-body text-center">
                                            <h2>
                                                <i class="ti ti-world text-info display-6"></i>
                                            </h2>
                                            <h4>Monthly Visits</h4>
                                            <h5>687,123</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                        <div class="card-body text-center">
                                            <h2>
                                                <i class="ti ti-gift text-danger display-6"></i>
                                            </h2>
                                            <h4>Products</h4>
                                            <h5>985</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="card drag-item cursor-move mb-lg-0 mb-6">
                                        <div class="card-body text-center">
                                            <h2>
                                                <i class="ti ti-user text-primary display-6"></i>
                                            </h2>
                                            <h4>Users</h4>
                                            <h5>105,652</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Cards Draggable ends -->

                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="text-body">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear())

                                    </script>, made with ❤️ by <a href="https://pixinvent.com/" target="_blank"
                                        class="footer-link">Pixinvent</a>
                                </div>
                                <div class="d-none d-lg-inline-block">

                                    <a href="https://themeforest.net/licenses/standard" class="footer-link me-4"
                                        target="_blank">License</a>
                                    <a href="https://1.envato.market/pixinvent_portfolio" target="_blank"
                                        class="footer-link me-4">More Themes</a>

                                    <a href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/"
                                        target="_blank" class="footer-link me-4">Documentation</a>


                                    <a href="https://pixinvent.ticksy.com/" target="_blank"
                                        class="footer-link d-none d-sm-inline-block">Support</a>

                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>



        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>


        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>

    </div>
    <!-- / Layout wrapper -->


    <?php require("components/footer.php"); ?>
    <!-- <script src="<?php echo base_url(); ?>custom/js/dashboard.js"></script> -->


</body>

</html>