<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template"
    data-style="light">
<?php require "components/head.php"; ?>

<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php require "components/sidenavbar.php"; ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php require "components/topnavbar.php"; ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <!-- Basic  -->
                            <div class="col-12">
                                <div class="card mb-6">
                                    <h5 class="card-header">Basic</h5>
                                    <div class="card-body">
                                        <form action="https://demos.pixinvent.com/upload" class="dropzone needsclick"
                                            id="dropzone-basic">
                                            <div class="dz-message needsclick">
                                                Drop files here or click to upload
                                                <span class="note needsclick">(This is just a demo dropzone. Selected
                                                    files are
                                                    <span class="fw-medium">not</span> actually
                                                    uploaded.)</span>
                                            </div>
                                            <div class="fallback">
                                                <input name="file" type="file" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /Basic  -->
                            <!-- Multi  -->
                            <div class="col-12">
                                <div class="card">
                                    <h5 class="card-header">Multiple</h5>
                                    <div class="card-body">
                                        <form action="https://demos.pixinvent.com/upload" class="dropzone needsclick"
                                            id="dropzone-multi">
                                            <div class="dz-message needsclick">
                                                Drop files here or click to upload
                                                <span class="note needsclick">(This is just a demo dropzone. Selected
                                                    files are
                                                    <span class="fw-medium">not</span> actually
                                                    uploaded.)</span>
                                            </div>
                                            <div class="fallback">
                                                <input name="file" type="file" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Multi  -->
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
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , made with ❤️ by
                                    <a href="https://pixinvent.com/" target="_blank" class="footer-link">Pixinvent</a>
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

    <div class="buy-now">
        <a href="https://1.envato.market/vuexy_admin" target="_blank" class="btn btn-danger btn-buy-now">Buy Now</a>
    </div>

    <!-- Footer -->
    <?php require "components/bottomfooter.php"; ?>
    <!-- / Footer -->

</body>

</html>

<!-- beautify ignore:end -->