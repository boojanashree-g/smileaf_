<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

    <!-- Body main wrapper start -->
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>

        <!-- HEADER AREA END -->

        <!-- BREADCRUMB AREA START -->
             <?php require("components/breadcrumbs.php")?>
        <!-- BREADCRUMB AREA END -->

        <!-- CONTACT ADDRESS AREA START -->
        <div class="ltn__contact-address-area mb-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow">
                            <div class="ltn__contact-address-icon">
                                <img src="<?php echo base_url() ?>public/assets/img/icons/10.png" alt="Icon Image">
                            </div>
                            <h3>Email Address</h3>
                            <p>info@cactusintl.com</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow">
                            <div class="ltn__contact-address-icon">
                                <img src="<?php echo base_url() ?>public/assets/img/icons/11.png" alt="Icon Image">
                            </div>
                            <h3>Phone Number</h3>
                            <p>(+91) 9842578248<br>(+91) 9788331756</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow">
                            <div class="ltn__contact-address-icon">
                                <img src="<?php echo base_url() ?>public/assets/img/icons/12.png" alt="Icon Image">
                            </div>
                            <h3>Office Address</h3>
                            <p>Cactus International, 3/142,Near Varadaraja Mills(Unit 2),SundakkamPalayam,Nambiyam
                                Palayam Post, Avinashi,Tirupur,Tamilnadu, India - 641670.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CONTACT ADDRESS AREA END -->

        <!-- CONTACT MESSAGE AREA START -->
        <div class="ltn__contact-message-area mb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ltn__form-box contact-form-box box-shadow white-bg">
                            <h4 class="title-2">Get A Quote</h4>
                            <form id="contact-form"
                                action="https://tunatheme.com/tf/html/broccoli-preview/broccoli/mail.php" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-item input-item-name ltn__custom-icon">
                                            <input type="text" name="name" placeholder="Enter your name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-item input-item-email ltn__custom-icon">
                                            <input type="email" name="email" placeholder="Enter email address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-item">
                                            <select class="nice-select">
                                                <option>Select Service Type</option>
                                                <option>Gardening </option>
                                                <option>Landscaping </option>
                                                <option>Vegetables Growing</option>
                                                <option>Land Preparation</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-item input-item-phone ltn__custom-icon">
                                            <input type="text" name="phone" placeholder="Enter phone number">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-item input-item-textarea ltn__custom-icon">
                                    <textarea name="message" placeholder="Enter message"></textarea>
                                </div>
                                <p><label class="input-info-save mb-0"><input type="checkbox" name="agree"> Save my
                                        name, email, and website in this browser for the next time I comment.</label>
                                </p>
                                <div class="btn-wrapper mt-0">
                                    <button class="btn theme-btn-1 btn-effect-1 text-uppercase" type="submit">get an
                                        free service</button>
                                </div>
                                <p class="form-messege mb-0 mt-20"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CONTACT MESSAGE AREA END -->

        <!-- GOOGLE MAP AREA START -->
        <div class="google-map mb-120">

            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9334.271551495209!2d-73.97198251485975!3d40.668170674982946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25b0456b5a2e7%3A0x68bdf865dda0b669!2sBrooklyn%20Botanic%20Garden%20Shop!5e0!3m2!1sen!2sbd!4v1590597267201!5m2!1sen!2sbd"
                width="100%" height="100%" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>
        <!-- GOOGLE MAP AREA END -->

        <!-- FOOTER AREA START -->
        <?php require("components/footer.php") ?>
        <!-- FOOTER AREA END -->
    </div>
    <!-- Body main wrapper end -->

    <!-- All JS Plugins -->
    <script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
    <!-- Contact Form -->
    <script src="<?php echo base_url() ?>public/assets/js/contact.js"></script>
    <!-- Main JS -->
    <script src="<?php echo base_url() ?>public/assets/js/main.js"></script>

</body>

<!-- Mirrored from tunatheme.com/tf/html/broccoli-preview/broccoli/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 26 May 2025 07:24:20 GMT -->

</html>