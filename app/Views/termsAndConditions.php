<!doctype html>
<html class="no-js" lang="zxx">
<?php require("components/head.php") ?>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

    <!-- Body main wrapper start -->
    <div class="wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>

          <!-- Utilize Cart Menu Start -->
        <div id="ltn__utilize-cart-menu" class="ltn__utilize ltn__utilize-cart-menu">
            <div class="ltn__utilize-menu-inner ltn__scrollbar">
                <div class="ltn__utilize-menu-head">
                    <span class="ltn__utilize-menu-title">Cart</span>
                    <button class="ltn__utilize-close">×</button>
                </div>
                <div class="mini-cart-product-area ltn__scrollbar">
                    <div class="mini-cart-item clearfix">
                        <div class="mini-cart-img">
                            <a href="#"><img src="<?php  echo base_url()?>public/assets/img/plate_img/round-plate/10RSP.jpg" alt="Image"></a>
                            <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                        </div>
                        <div class="mini-cart-info">
                            <h6><a href="#">Red Hot Tomato</a></h6>
                            <span class="mini-cart-quantity">1 x $65.00</span>
                        </div>
                    </div>
                    <div class="mini-cart-item clearfix">
                        <div class="mini-cart-img">
                            <a href="#"><img src="<?php  echo base_url()?>public/assets/img/plate_img/round-plate/10RSP.jpg" alt="Image"></a>
                            <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                        </div>
                        <div class="mini-cart-info">
                            <h6><a href="#">Vegetables Juices</a></h6>
                            <span class="mini-cart-quantity">1 x $85.00</span>
                        </div>
                    </div>
                    <div class="mini-cart-item clearfix">
                        <div class="mini-cart-img">
                            <a href="#"><img src="<?php  echo base_url()?>public/assets/img/plate_img/round-plate/10RSP.jpg" alt="Image"></a>
                            <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                        </div>
                        <div class="mini-cart-info">
                            <h6><a href="#">Orange Sliced Mix</a></h6>
                            <span class="mini-cart-quantity">1 x $92.00</span>
                        </div>
                    </div>
                    <div class="mini-cart-item clearfix">
                        <div class="mini-cart-img">
                            <a href="#"><img src="<?php  echo base_url()?>public/assets/img/plate_img/round-plate/10RSP.jpg" alt="Image"></a>
                            <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                        </div>
                        <div class="mini-cart-info">
                            <h6><a href="#">Orange Fresh Juice</a></h6>
                            <span class="mini-cart-quantity">1 x $68.00</span>
                        </div>
                    </div>
                </div>
                <div class="mini-cart-footer">
                    <div class="mini-cart-sub-total">
                        <h5>Subtotal: <span>$310.00</span></h5>
                    </div>
                    <div class="btn-wrapper">
                        <a href="<?php echo base_url('cart')?>" class="theme-btn-1 btn btn-effect-1">View Cart</a>
                        <a href="<?php echo base_url('checkout')?>" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                    </div>
                    <p>Free Shipping on All Orders Over $100!</p>
                </div>

            </div>
        </div>
        <!-- Utilize Cart Menu End -->

        <!-- Utilize Mobile Menu Start -->
        <div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
            <div class="ltn__utilize-menu-inner ltn__scrollbar">
                <div class="ltn__utilize-menu-head">
                    <div class="site-logo">
                        <a href="<?php echo base_url() ?>"><img
                                src="<?php echo base_url() ?>public/assets/img/logo-2.png" alt="Logo"></a>
                    </div>
                    <button class="ltn__utilize-close">×</button>
                </div>
                <div class="ltn__utilize-menu-search-form">
                    <form action="#">
                        <input type="text" placeholder="Search...">
                        <button><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="ltn__utilize-menu">
                    <ul>
                        <li><a href="<?php echo base_url() ?>">Home</a></li>
                        <li><a href="<?php echo base_url('products') ?>">Shop</a></li>
                        <li><a href="<?php echo base_url() ?>">Disposable Dinnerware</a></li>
                        <li><a href="<?php echo base_url() ?>">Reusable Dinnerware</a></li>
                        <li><a href="<?php echo base_url() ?>">Accessories</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <div class="ltn__utilize-buttons ltn__utilize-buttons-2">
                    <ul>
                        <li>
                            <a href="<?php echo base_url('myaccount') ?>" title="My Account">
                                <span class="utilize-btn-icon">
                                    <i class="far fa-user"></i>
                                </span>
                                My Account
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('wishlist') ?>" title="Wishlist">
                                <span class="utilize-btn-icon">
                                    <i class="far fa-heart"></i>
                                    <sup>3</sup>
                                </span>
                                Wishlist
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('cart') ?>" title="Shoping Cart">
                                <span class="utilize-btn-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                    <sup>5</sup>
                                </span>
                                Shoping Cart
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="ltn__social-media-2">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                        <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Utilize Mobile Menu End -->

        <div class="ltn__utilize-overlay"></div>
        <div class="ltn__utilize-overlay"></div>

        <!-- BREADCRUMB AREA START -->
            <?php require("components/breadcrumbs.php")?>
        <!-- BREADCRUMB AREA END -->

        <div class=" container max-w-4xl mx-auto px-4 py-8">
            <p class="mb-6">
                Welcome to <strong>Smileaf</strong>. By accessing or using our website
                <a href="https://smileaf.in" class="text-blue-600 underline"><strong>https://smileaf.in</strong></a>
                and placing orders for our eco-friendly areca leaf products, you agree to the following terms.Please read them carefully.

            </p>

            <div class="space-y-6">
                <section>
                    <h2 class="text-xl font-semibold text-green-600">1. Use of Our Online Store</h2>
                    <p>
                        Smileaf operates an e-commerce platform offering kitchenware products. By using our online store, you represent that you are at least 18 years old or accessing the site under the supervision of a parent or guardian, and you agree to comply with all applicable laws.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-green-600">2. General Requirements</h2>
                    <p>
                        You agree not to use Smileaf for any unlawful or unauthorized purpose. You must not violate any local, state, national, or international law when using our platform. Any breach of these general conditions may result in suspension or termination of your access without notice.                   
                    </p>
                    </section>

                <section>
                    <h2 class="text-xl font-semibold text-green-600">3. Information Accuracy and Completeness</h2>
                    <p>
                        While we endeavor to provide precise product descriptions—covering dimensions, weights, and materials—errors may occur. Smileaf does not warrant that product information, pricing, or other content on the site is error-free, complete, or current. We reserve the right to correct any inaccuracies and update information at any time.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">4.Limited Rights to Use Site Content</h2>
                    <p>
                        Subject to your compliance with these terms, Smileaf grants you a non-exclusive, non-transferable, revocable license to view, download, and print content from the site solely for your personal, non-commercial use. Any other use, including reproduction, distribution, or modification of Smileaf content, is strictly prohibited without our prior written consent.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">5.Third-Party Materials</h2>
                    <p>
                        Our website may contain links to third-party sites or display content provided by partners, such as shipping carriers or payment processors like Razorpay. Smileaf does not control and is not responsible for the accuracy, legality, or content of those external sites or materials.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">6. No Guarantees</h2>
                    <p>
                        All products are provided “as is” and “as available.” Smileaf expressly disclaims all warranties, whether express or implied, including implied warranties of merchantability, fitness for a particular purpose, and non-infringement, to the fullest extent permitted by law.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">7.Limitations on Liability</h2>
                    <p>
                        In no event shall Smileaf, its directors, officers, employees, or suppliers be liable for any indirect, incidental, special, or consequential damages arising from your use of our website or purchase of our products, even if advised of the possibility of such damages. Our total liability for any claim related to our services shall not exceed the amount paid by you for the relevant order.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">8.Legal Disclaimer</h2>
                    <p>
                        Smileaf’s areca leaf products are handcrafted from naturally fallen leaves. Variations in color, shape, and thickness are inherent to the material and do not constitute defects. Please review product images and specifications carefully before ordering.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">9.Permitted and Prohibited Uses</h2>
                    <p>
                        You may browse, order, and review products on Smileaf. You may not (a) use automated means to scrape or index our content; (b) upload harmful code or malware; (c) impersonate another person; or (d) interfere with the operation or security of our site.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">10.Indemnification</h2>
                    <p>
                        You agree to indemnify and hold harmless Smileaf and its affiliates from any claim, demand, loss, or damage—including reasonable attorneys’ fees—arising out of your breach of these terms, your use of the site, or your violation of any law or third-party rights.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">11.Billing and Account Details</h2>
                    <p>
                        You represent and warrant that all billing information you provide is accurate and that you are authorized to use the payment methods you submit. Smileaf reserves the right to refuse or cancel any orders for reasons including without limitation: product or service availability, errors in description or pricing, or suspicion of fraudulent or unauthorized transactions.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">12.User Contributions</h2>
                    <p>
                        You may submit reviews, ratings, and feedback regarding our products. By posting, you grant Smileaf a perpetual, irrevocable, royalty-free license to use, reproduce, and distribute your contributions in any medium. You warrant that your submissions are your own and do not violate any third-party rights.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">13.Privacy of Personal Data</h2>
                    <p>
                        Your privacy is important to us. Please review our Privacy Policy, which explains how we collect, use, and protect your Personal Information, including name, address, transaction history, and payment details. The Privacy Policy is incorporated herein by reference.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">14. Entire Agreement</h2>
                    <p>
                        These Terms & Conditions, together with our Privacy Policy and any other legal notices published by Smileaf on the site, constitute the entire agreement between you and Smileaf concerning your use of our platform, superseding any prior agreements.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">15.Applicable Law</h2>
                    <p>
                        These terms shall be governed by and construed in accordance with the laws of India, without regard to conflict-of-law principles. You agree to submit to the exclusive jurisdiction of the courts located in [Your State/City], India for any disputes arising under these terms.
                    </p>
                </section>
                <section>
                    <h2 class="text-xl font-semibold text-green-600">16 .Modifications to These Terms</h2>
                    <p>
                        Smileaf may revise these Terms & Conditions at any time by updating this page. The revised terms become effective immediately upon posting. Your continued use of the site after changes are posted constitutes your acceptance of the modified terms.
                    </p>
                </section>

                <!-- Repeat for each section from 4 to 17 -->
                <section class="mb-5">
                    <h2 class="text-xl font-semibold text-green-600">17. Contact Us</h2>
                    <p>
                        If you have any questions or wish to access, correct, amend, or delete personal information,
                        contact us at:
                    </p>
                    <ul class="list-disc ml-6 mt-2">
                        <li><strong>Email:</strong> <a href="mailto:smileafproducts@gmail.com"
                                class="text-blue-600">smileafproducts@gmail.com</a></li>
                        <li><strong>Phone:</strong> <a href="tel:+919842578248" class="text-blue-600">+91-9842578248</a>
                        </li>
                    </ul>
                    <strong> Thank you for choosing Smileaf—where quality areca leaf products meet sustainable dining.</strong>
                </section>
            </div>
        </div>

            <!-- FOOTER AREA START -->
            <?php require("components/footer.php") ?>

            <!-- FOOTER AREA END -->

        
        <!-- Body main wrapper end -->

</body>

</html>