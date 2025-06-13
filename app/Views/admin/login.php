<!DOCTYPE html>

<html lang="en" class="light-style layout-wide  customizer-hide" dir="ltr" data-theme="theme-default"
    data-template="vertical-menu-template" data-style="light">

<?php require("components/head.php"); ?>

<body>
    <div class="container-xxl">

        <div class="authentication-wrapper authentication-basic container-p-y">

            <div class="authentication-inner py-6">
                <div class="alert  d-flex align-items-center alert-dismissible d-none" role="alert" id="login-alert">

                </div>
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="#" class="app-brand-link">
                                <img src="<?= base_url() ?>public/admin/img/smileaf_black.png" width="190" />
                            </a>
                        </div>
                        <!-- /Logo -->

                        <form id="admin-login-form" class="mb-4">
                            <div class="mb-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Enter your username" autofocus>
                                <span class="name-error invalid-error"></span>
                            </div>
                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                                <span class="password-error invalid-error"></span>
                            </div>
                            <div class="my-8">

                            </div>
                            <div class="mb-6">
                                <button type="button" class="btn btn-primary d-grid w-100"
                                    id="admin-loginbtn">Login</button>
                            </div>
                        </form>



                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>



    <?php require("components/footer.php"); ?>
    <script src="<?= base_url() ?>public/admin/custom/js/admin-login.js"></script>

</body>

</html>