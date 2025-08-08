<!doctype html>
<html class="no-js" lang="zxx">
<?php require("components/head.php") ?>

<body>


    <!-- Body main wrapper start -->
    <div class="wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>

        <!-- HEADER AREA END -->

        <!-- PRODUCT DETAILS AREA START -->
        <div class="ltn__product-area ltn__product-gutter product_categories">
            <div class="container">
                <div class="row">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="liton_product_grid">
                            <div class="ltn__product-tab-content-inner ltn__product-grid-view">
                                <div class="row">
                                    <!-- ltn__product-item -->
                                    <div class="row">
                                        <?php if (!empty($submenus)): ?>
                                            <?php foreach ($submenus as $submenu): ?>
                                                <div class="col-xl-3 col-sm-6 col-12">
                                                    <div class="ltn__product-item ltn__product-item-3 text-center">
                                                        <div class="product-img">
                                                            <a
                                                                href="<?= base_url('products/' . $submenu['slug'] . '/' . base64_encode($submenu['sub_id'])) ?>">
                                                                <img src="<?= base_url($submenu['image_url']) ?>" alt="#"
                                                                    loading="lazy">
                                                            </a>
                                                        </div>
                                                        <div class="home_products product-info">
                                                            <h2 class="product-title">
                                                                <a href="<?= base_url('products/' . $submenu['slug'] . '/' . base64_encode($submenu['sub_id'])) ?>"
                                                                    class="featured_prod_name">
                                                                    <span><?= esc($submenu['submenu']) ?></span>
                                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                                </a>
                                                            </h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>No products found under this category.</p>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT DETAILS AREA END -->


    <!-- FOOTER AREA START -->
    <?php require("components/footer.php") ?>

    <!-- FOOTER AREA END -->


    </div>
    <!-- Body main wrapper end -->

    <!-- All JS Plugins -->
    <script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
    <!-- Main JS -->
    <script src="<?php echo base_url() ?>public/assets/js/main.js"></script>

</body>

</html>