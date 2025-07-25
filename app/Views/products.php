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
        <!-- PRODUCT DETAILS AREA START -->
        <div class="ltn__product-area ltn__product-gutter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 order-lg-2">
                        <!-- Mobile Filter/Sort Buttons (for small screens only) -->

                        <div class="ltn__shop-options">
                            <ul>
                                <li>
                                    <div class="ltn__grid-list-tab-menu ">
                                        <div class="nav">
                                            <a class="active show" data-bs-toggle="tab" href="#liton_product_grid"><i
                                                    class="fas fa-th-large"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_product_list"><i
                                                    class="fas fa-list dsmnone"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-lg-none d-flex justify-content-end ">
                                        <button class="btn btn-outline-secondary me-2" id="mobileFilterBtn"
                                            data-bs-toggle="modal" data-bs-target="#mobileFilterModal">
                                            <i class="fas fa-filter"></i>
                                        </button>

                                    </div>
                                </li>
                                <li class="dsmnone">
                                    <div class="short-by text-center">
                                        <select id="sortSelect" class="nice-select">
                                            <option value="default">Default sorting</option>
                                            <option value="popularity">Sort by popularity</option>
                                            <option value="new">Sort by new arrivals</option>
                                            <option value="priceLowHigh">Sort by price: low to high</option>
                                            <option value="priceHighLow">Sort by price: high to low</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="dsmnone">
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
                                                <div class="col-xl-4 col-sm-12 col-md-6 col-12 product-item"
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
                                                                <a
                                                                    href="<?= base_url("product-details/" . base64_encode($product['prod_id'])) ?>">
                                                                    <span
                                                                        class="prod_name_span"><?= esc($product['prod_name']) ?></span>
                                                                </a>
                                                            </h2>
                                                            <div class="product_price_wrapper mt-0">
                                                                <div class="product-price mb-0">
                                                                    <span>
                                                                        ₹<?= number_format((float) ($product['lowest_offer_price'] ?? 0), 0) ?>
                                                                    </span>
                                                                    <?php if (!empty($product['lowest_offer_price']) && $product['lowest_offer_price'] != $product['lowest_mrp']): ?>
                                                                        <del>
                                                                            ₹<?= number_format((float) ($product['lowest_mrp']), 0) ?>
                                                                        </del>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <!-- <a href="#" title="Wishlist" class="wishlist-btn">
                                                                    <i class="far fa-heart"></i>
                                                                </a> -->
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
                                                                    <i class="fab fa-whatsapp text-success me-2"></i>
                                                                    <span class="text-success">Contact us to order</span>
                                                                </a>
                                                            </div>
                                                        <?php } else if ($product['available_status'] > 0) { ?>
                                                                <div class="d-flex justify-content-evenly">
                                                                    <a href="<?= base_url("product-details/" . base64_encode($product['prod_id'])) ?>"
                                                                        class="theme-btn-1 btn quick_btn"
                                                                        data-prodid="<?= esc($product['prod_id']) ?>"
                                                                        data-menuid="<?= $product['menu_id'] ?>"
                                                                        data-submenuid=<?= $product['submenu_id'] ?>
                                                                        style="border:1px solid;">
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
                            <div class="tab-pane fade dsmnone" id="liton_product_list">
                                <div class="ltn__product-tab-content-inner ltn__product-list-view">
                                    <div class="row" id="product-list-container">
                                        <!-- ltn__product-item -->
                                        <?php if (!empty($products)): ?>
                                            <?php foreach ($products as $product): ?>
                                                <div class="col-lg-12 col-12product-item"
                                                    data-name="<?= strtolower(esc($product['prod_name'])) ?>">

                                                    <div class="ltn__product-item ltn__product-item-3" style="min-height:auto;">
                                                        <div class="product-img">
                                                            <a
                                                                href="<?= base_url("product-details/" . base64_encode($product['prod_id'])) ?>">
                                                                <img src="<?= base_url($product['main_image']) ?>"
                                                                    alt="<?= esc($product['prod_name']) ?>" width="290">
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
                                                                <a
                                                                    href="<?= base_url("product-details/" . base64_encode($product['prod_id'])) ?>">
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
                    <div class="col-lg-3 d-none d-lg-block">
                        <?php require("components/product_filter_sidebar.php") ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Filter Modal -->
        <div class="modal fade" id="mobileFilterModal" tabindex="-1" aria-labelledby="mobileFilterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mobileFilterModalLabel">Filters</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php require("components/product_filter_sidebar.php") ?>
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
        <script>


            const base_url = "<?= base_url() ?>";

            $('#sortSelect').on('change', function () {
                const sortBy = $(this).val();
                console.log("Selected sort option:", sortBy);

                const gridTargetElement = $('#product-grid-container');
                gridTargetElement.html('<p>Loading...</p>');

                $.ajax({
                    url: base_url + 'product-sort',
                    method: 'GET',
                    data: { sort: sortBy },
                    dataType: 'json',
                    success: function (response) {
                        console.log("Full response:", response);



                        let products = response.products?.data || [];
                        console.log(products);
                        if (response.success) {
                            const html = generateGridHtml(products);
                            $('#product-grid-container').html(html);
                        } else {
                            $('#product-grid-container').html('<p>No products found.</p>');
                        }
                    },
                    error: function () {
                        gridTargetElement.html('<p class="text-danger">Error loading sorted products.</p>');
                    }
                });
            });

            function generateGridHtml(products) {
                let html = "";
                products.forEach(product => {
                    const productUrl = `${base_url}products/${product.prod_id}`;
                    const offerPrice = parseFloat(product.lowest_offer_price || 0);
                    const mrp = parseFloat(product.lowest_mrp || 0);
                    const outOfStock = product.available_status == 0;
                    console.log(product);

                    html += `
            <div class="col-xl-4 col-sm-12 col-12 product-item">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                <div class="product-img">
                    <a href="${productUrl}">
                    <img src="${base_url}${product.main_image}" alt="${product.prod_name}">
                    </a>
                    ${outOfStock ? '<div class="product-badge"><ul><li class="sale-badge">Out of stock</li></ul></div>' : ''}
                </div>
                <div class="product-info">
                    <h2 class="product-title"><a href="${productUrl}"><span class="prod_name_span">${product.prod_name}</span></a></h2>
                    <div class="product_price_wrapper mt-0">
                    <div class="product-price mb-0">
                        <span>₹${offerPrice.toFixed(2)}</span>
                        ${offerPrice !== mrp ? `<del>₹${mrp.toFixed(2)}</del>` : ''}
                    </div>
                    </div>
                </div>
                <div class="d-flex justify-content-evenly">
                    <a href="${productUrl}" class="theme-btn-1 btn quick_btn">
                    <i class="fas fa-whatsapp ${outOfStock ? 'text-danger' : ''}"></i>
                    <span>${outOfStock ? 'Contact us to order' : 'Buy Now'}</span>
                    </a>
                </div>
                </div>
            </div>
            `;
                });

                return html;
            }
        </script>
        <script src="<?php echo base_url() ?>public/assets/js/filter.js"></script>
        <script src="<?php echo base_url() ?>custom/js/productlist.js"></script>
        <script src="<?php echo base_url() ?>public/assets/js/main.js"></script>
        <!-- All JS Plugins -->
        <script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>

</body>

</html>