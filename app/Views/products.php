<!doctype html>
<html class="no-js" lang="zxx">
<?php require("components/head.php") ?>

<style>
    .color-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        cursor: pointer;
        display: inline-block;
    }

    .color-circle.border {
        border: 2px solid #ccc;
    }

    .wishlist-active {
        background-color: red !important;
        color: #fff;
    }
</style>


<body class="products_page">
    <!-- Body main wrapper start -->
    <div class="wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>
        <!-- HEADER AREA END -->

        <?php require("components/breadcrumbs.php") ?>

        <!-- PRODUCT DETAILS AREA START -->
        <div class="ltn__product-area ltn__product-gutter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 order-lg-2">
                        <div class="ltn__shop-options">
                            <ul>
                                <li>
                                    <div class="ltn__grid-list-tab-menu ">
                                        <div class="nav">
                                            <a class="active show" data-bs-toggle="tab" href="#liton_product_grid"><i
                                                    class="fas fa-th-large"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_product_list"><i
                                                    class="fas fa-list"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="short-by text-center">
                                        <select class="nice-select">
                                            <option>Default sorting</option>
                                            <option>Sort by popularity</option>
                                            <option>Sort by new arrivals</option>
                                            <option>Sort by price: low to high</option>
                                            <option>Sort by price: high to low</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="showing-product-number text-right text-end">
                                        <span><?= count($products) . ' ' . (count($products) == 1 ? 'Product' : 'Products') ?></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <!-- Grid View Tab -->
                            <div class="tab-pane fade active show" id="liton_product_grid">
                                <div class="ltn__product-tab-content-inner ltn__product-grid-view">
                                    <div class="row" id="product-grid-container">
                                        <!-- ltn__product-item -->
                                        <?php if (!empty($products)): ?>
                                            <?php foreach ($products as $product): ?>
                                                <div class="col-xl-4 col-sm-12   col-12 product-item"
                                                    data-name="<?= strtolower(esc($product['prod_name'])) ?>">
                                                    <div class="ltn__product-item ltn__product-item-3 text-center">
                                                        <div class="product-img">
                                                            <a
                                                                href="<?= base_url("product-details/" . base64_encode($product['prod_id'])) ?>">
                                                                <img src="<?= base_url($product['main_image']) ?>"
                                                                    alt="<?= esc($product['prod_name']) ?>">
                                                            </a>
                                                            <?php if ($product['available_status'] == 0): ?>
                                                                <div class="product-badge">
                                                                    <ul>
                                                                        <li class="sale-badge">
                                                                            Out of stock
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="product-info">
                                                            <h2 class="product-title">
                                                                <a href="<?= base_url($product['url']) ?>">
                                                                    <span
                                                                        class="prod_name_span"><?= esc($product['prod_name']) ?></span>
                                                                </a>
                                                            </h2>
                                                            <div class="product_price_wrapper mt-0">
                                                                <div class="product-price mb-0">
                                                                    <span>₹<?= esc($product['lowest_offer_price'] ?? 0) ?></span>
                                                                    <?php if (!empty($product['lowest_offer_price']) && $product['lowest_offer_price'] != $product['lowest_mrp']): ?>
                                                                        <del>₹<?= esc($product['lowest_mrp']) ?></del>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <a href="#" title="Wishlist" class="wishlist-btn">
                                                                    <i class="far fa-heart"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="d-flex justify-content-evenly">
                                                            <a class="theme-btn-1 btn quick_btn  quick_btn_view"
                                                                data-prodid="<?= esc($product['prod_id']) ?>"
                                                                data-menuid="<?= $product['menu_id'] ?>"
                                                                data-submenuid=<?= $product['submenu_id'] ?>>
                                                                <i class="fas fa-shopping-cart"></i>
                                                                <span>Quick Buy</span>
                                                            </a>
                                                        </div> -->


                                                        <?php if ($product['available_status'] == 0) { ?>
                                                            <div class="d-flex justify-content-evenly">
                                                                <a href="<?= base_url("product-details/" . base64_encode($product['prod_id'])) ?>"
                                                                    class="theme-btn-1 btn quick_btn"
                                                                    data-prodid="<?= esc($product['prod_id']) ?>"
                                                                    data-menuid="<?= $product['menu_id'] ?>"
                                                                    data-submenuid=<?= $product['submenu_id'] ?>>
                                                                    <i class="fas fa-shopping-cart text-danger"></i>
                                                                    <span class="text-danger">Contact us to order</span>
                                                                </a>
                                                            </div>
                                                        <?php } else if ($product['available_status'] > 0) { ?>
                                                                <div class="d-flex justify-content-evenly">
                                                                    <a href="<?= base_url("product-details/" . base64_encode($product['prod_id'])) ?>"
                                                                        class="theme-btn-1 btn quick_btn"
                                                                        data-prodid="<?= esc($product['prod_id']) ?>"
                                                                        data-menuid="<?= $product['menu_id'] ?>"
                                                                        data-submenuid=<?= $product['submenu_id'] ?>>
                                                                        <i class="fas fa-shopping-cart"></i>
                                                                        <span>Buy Now</span>
                                                                    </a>
                                                                </div><?php } ?>

                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="col-12">
                                                <p>No products found.</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- List View Tab -->
                            <div class="tab-pane fade" id="liton_product_list">
                                <div class="ltn__product-tab-content-inner ltn__product-list-view">
                                    <div class="row" id="product-list-container">
                                        <!-- ltn__product-item -->
                                        <?php if (!empty($products)): ?>
                                            <?php foreach ($products as $product): ?>
                                                <div class="col-lg-12 product-item"
                                                    data-name="<?= strtolower(esc($product['prod_name'])) ?>">

                                                    <div class="ltn__product-item ltn__product-item-3" style="min-height:auto;">
                                                        <div class="product-img">
                                                            <a href="<?= base_url("product-details/" . base64_encode($product['prod_id'])) ?>">
                                                                <img src="<?= base_url($product['main_image']) ?>"
                                                                    alt="<?= esc($product['prod_name']) ?>">
                                                            </a>
                                                            <?php if ($product['available_status'] == 0): ?>
                                                                <div class="product-badge">
                                                                    <ul>
                                                                        <li class="sale-badge">
                                                                            Out of stock
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="product-info h-100">
                                                            <h2 class="product-title">
                                                                <a href="<?= base_url("product-details/" . base64_encode($product['prod_id'])) ?>">
                                                                    <?= esc($product['prod_name']) ?>
                                                                </a>
                                                            </h2>
                                                            <div class="product-price">
                                                                <span>₹<?= esc($product['lowest_mrp'] ?? '0') ?></span>
                                                                <?php if (!empty($product['lowest_offer_price']) && $product['lowest_offer_price'] != $product['lowest_mrp']): ?>
                                                                    <del>₹<?= esc($product['lowest_offer_price']) ?></del>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="product-brief">
                                                                <?= $product['description'] ?? 'Premium quality product available at best prices.' ?>
                                                            </div>
                                                            <div class="product-hover-action">
                                                                <ul>
                                                                    <!-- <li>
                                                                        <a class="quick_btn_list"
                                                                            data-prodid="<?= esc($product['prod_id']) ?>"
                                                                            data-menuid="<?= $product['menu_id'] ?>"
                                                                            data-submenuid=<?= $product['submenu_id'] ?>>
                                                                            <i class="far fa-eye"></i>
                                                                        </a>
                                                                    </li> -->
                                                                    <!-- <li>
                                                                        <a href="#" title="Wishlist" data-bs-toggle="modal"
                                                                            data-bs-target="#liton_wishlist_modal">
                                                                            <i class="far fa-heart"></i>
                                                                        </a>
                                                                    </li> -->

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="col-12">
                                                <p>No products found.</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <aside class="sidebar ltn__shop-sidebar">
                            <div class="widget ltn__menu-widget">
                                <h4 class="ltn__widget-title ltn__widget-title-border">Product Availability</h4>
                                <ul>
                                    <li>
                                        <label><input type="checkbox" class="filter-checkbox" name="availability[]"
                                                value="1">&nbsp;&nbsp; Available</label>
                                    </li>
                                    <li>
                                        <label><input type="checkbox" class="filter-checkbox" name="availability[]"
                                                value="0">&nbsp;&nbsp; Out of Stock</label>
                                    </li>
                                </ul>
                            </div>

                            <!-- Category Widget -->
                            <div class="widget ltn__menu-widget">
                                <h4 class="ltn__widget-title ltn__widget-title-border">Product Types</h4>
                                <ul>
                                    <?php if (!empty($productTypes)): ?>
                                        <?php foreach ($productTypes as $type): ?>
                                            <li>
                                                <label>
                                                    <input type="checkbox" class="filter-checkbox" name="type_id[]"
                                                        value="<?= esc($type->type_id) ?>">
                                                    &nbsp;&nbsp;<?= esc($type->type_name) ?>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li>No product types found.</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="widget ltn__menu-widget">
                                <h4 class="ltn__widget-title ltn__widget-title-border">Product Shape</h4>
                                <ul>
                                    <?php if (!empty($productShape)): ?>
                                        <?php foreach ($productShape as $shape): ?>
                                            <li>
                                                <label>
                                                    <input type="checkbox" class="filter-checkbox" name="shape_id[]"
                                                        value="<?= esc($shape->shape_id) ?>">
                                                    &nbsp;&nbsp;<?= esc($shape->shape_name) ?>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li>No product types found.</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="widget ltn__menu-widget">
                                <h4 class="ltn__widget-title ltn__widget-title-border">Product Size</h4>
                                <ul>
                                    <?php if (!empty($productsize)): ?>
                                        <?php foreach ($productsize as $size): ?>
                                            <li>
                                                <label>
                                                    <input type="checkbox" class="filter-checkbox" name="size_id[]"
                                                        value="<?= esc($size->size_id) ?>">
                                                    &nbsp;&nbsp;<?= esc($size->size_name) ?>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li>No product types found.</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER AREA START -->
        <?php require("components/footer.php") ?>

        <!-- FOOTER AREA END -->

        <!-- MODAL AREA START (Add To Cart Modal) -->
        <div class="modal fade" id="quick_buy_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered ">
                <div class="modal-content border-0 shadow-lg p-3 quick-modal-view">
                    <!-- Dynamic Modal Data -->
                </div>
            </div>
        </div>



        <!-- Main JS -->

        <script src="<?php echo base_url() ?>public/assets/js/filter.js"></script>
        <script src="<?php echo base_url() ?>custom/js/productlist.js"></script>
        <script src="<?php echo base_url() ?>public/assets/js/main.js"></script>

        <!-- All JS Plugins -->
        <script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>


</body>

</html>