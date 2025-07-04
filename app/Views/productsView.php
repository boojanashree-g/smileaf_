<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>
<style>
    .qtybutton.disabled {
        background-color: #ccc;
        color: #666;
        cursor: not-allowed;
    }
</style>

<body>
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>
        <!-- HEADER AREA END -->

        <!-- BREADCRUMB AREA START -->
        <?php require("components/breadcrumbs.php") ?>
        <!-- BREADCRUMB AREA END -->

        <!-- SHOP DETAILS AREA START -->
        <div class="ltn__shop-details-area pb-10">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="ltn__shop-details-inner">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="ltn__shop-details-img-gallery">
                                        <div class="ltn__shop-details-large-img">
                                            <div class="single-large-img">
                                                <a href="<?php echo base_url() ?>" data-rel="lightcase:myCollection">
                                                    <img src="<?= base_url() ?><?= $products['main_image'] ?>"
                                                        alt="Image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ltn__shop-details-small-img slick-arrow-2">
                                            <?php foreach ($image_data as $images): ?>
                                                <div class="single-small-img">
                                                    <img src="<?= base_url() ?><?= $images['image_path'] ?>" alt="Image">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modal-product-info shop-details-info ps-0">
                                        <h3><?= esc($products['prod_name'] ?? 'Product Name') ?></h3>
                                        <div class="product-price">
                                            <span id="offer-price">₹<?= esc($lowest_offer['offer_price'] ?? 0) ?></span>
                                            <del id="mrp-price"
                                                style="<?= ($lowest_offer['offer_price'] != $lowest_offer['mrp']) ? '' : 'display:none;' ?>">
                                                ₹<?= esc($lowest_offer['mrp']) ?>
                                            </del>
                                        </div>
                                    </div>
                                    <div class="modal-product-meta ltn__product-details-menu-1">
                                        <ul>
                                            <li>
                                                <strong>Quantity: (No. of plates)</strong>
                                                <span class="quantity-options">
                                                    <?php
                                                    $lowestQty = $lowest_offer['pack_qty'];
                                                    foreach ($variant_data as $key => $variant):
                                                        if (!is_array($variant))
                                                            continue;

                                                        $packQty = $variant['pack_qty'];
                                                        $inputId = "mqty-" . $packQty;
                                                        $isChecked = ($variant['pack_qty'] == $lowestQty) ? 'checked' : '';
                                                        $mrp = $variant['mrp'];
                                                        $offerPrice = $variant['offer_price'];
                                                        $quantity = $variant['quantity'];
                                                        $offertype = $variant['offer_type'];
                                                        ?>
                                                        <input class="pack_qty" type="radio" id="<?= $inputId ?>"
                                                            name="pack_qty" value="<?= $packQty ?>" data-mrp="<?= $mrp ?>"
                                                            data-offer="<?= $offerPrice ?>" data-quantity="<?= $quantity ?>"
                                                            data-prodid="<?= $products[0]['prod_id'] ?>" <?= $isChecked ?>>
                                                        <label for="<?= $inputId ?>"><?= $packQty ?></label>

                                                    <?php endforeach; ?>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="ltn__product-details-menu-2">
                                        <ul>
                                            <li>
                                                <div class="cart-plus-minus">
                                                    <div class="dec qtybutton">-</div>
                                                    <input type="text" value="1" name="quantity"
                                                        data-maxqty="<?= $variant_data['lowest_quantity'] ?>"
                                                        class="cart-plus-minus-box selected-qty">
                                                    <div class="inc qtybutton">+</div>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="#ltn__utilize-cart-menu"
                                                    class="ltn__utilize-toggle theme-btn-1 btn addto_cartbtn"
                                                    style="width:auto;     background-color: #37724f !important;">
                                                    <span class="addto_cart_text"><i
                                                            class="icon-shopping-cart pe-2"></i>ADD TO CART</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- <div class="ltn__product-details-menu-3">
                                        <ul>
                                            <li>
                                                <a href="#" class="" title="Wishlist" data-bs-toggle="modal"
                                                    data-bs-target="#liton_wishlist_modal">
                                                    <i class="far fa-heart"></i>
                                                    <span>Add to Wishlist</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div> -->
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Shop Tab Start -->
                    <div class="ltn__shop-details-tab-inner ltn__shop-details-tab-inner-2">
                        <div class="ltn__shop-details-tab-menu">
                            <div class="nav">
                                <a class="active show" data-bs-toggle="tab"
                                    href="#liton_tab_details_1_1">Description</a>
                                <a data-bs-toggle="tab" href="#liton_tab_details_1_2" class="">Product Usage</a>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="liton_tab_details_1_1">
                                <div class="ltn__shop-details-tab-content-inner">
                                    <!-- <h4 class="title-2">Lorem ipsum dolor sit amet elit.</h4> -->
                                    <p><?= esc($products['description']) ?></p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="liton_tab_details_1_2">
                                <div class="ltn__shop-details-tab-content-inner">
                                    <!-- <h4 class="title-2">Usage</h4> -->
                                    <p><?= esc(strip_tags(trim($products['product_usage']))) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Shop Tab End -->
                </div>
            </div>
        </div>
    </div>
    <!-- SHOP DETAILS AREA END -->

    <!-- PRODUCT SLIDER AREA START -->
    <div class="ltn__product-slider-area ltn__product-gutter pb-70 products_page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title text-center">Related Products</h1>
                    </div>
                </div>
            </div>
            <div class="row ltn__related-product-slider-one-active slick-arrow-1">

                <?php if (!empty($product['relatedProducts']) && is_array($product['relatedProducts'])): ?>
                    <?php foreach ($product['relatedProducts'] as $related): ?>
                        <div class="col-lg-12">
                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                <div class="product-img">
                                    <a href="<?= base_url('product-details/' . base64_encode($related->prod_id)) ?>">
                                        <img src="<?= base_url($related->main_image ?? 'public/assets/img/default-product.png') ?>"
                                            alt="<?= esc($related->prod_name) ?>">
                                    </a>
                                    <div class="">
                                        <ul>
                                            <?php if (!empty($related->best_seller)): ?>
                                                <li class="bestseller-badge"><span>Best Seller</span></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h2 class="product-title">
                                        <a href="<?= base_url('product-details/' . $related->prod_id) ?>">
                                            <span class="prod_name_span"><?= esc($related->prod_name) ?></span>
                                        </a>
                                    </h2>
                                    <div class="product_price_wrapper mt-0">
                                        <div class="product-price mb-0">
                                            <span>₹<?= number_format(3625) ?></span>
                                            <del>₹<?= number_format(1152) ?></del>
                                        </div>
                                        <a href="#" title="Wishlist" class="wishlist-btn">
                                            <i class="far fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-evenly">
                                    <a class="theme-btn-1 btn quick_btn" data-prodid="<?= esc($related->prod_id) ?>"
                                        data-menuid="<?= esc($related->menu_id) ?>"
                                        data-submenuid="<?= esc($related->submenu_id) ?>">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Quick Buy</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>No related products found.</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- PRODUCT SLIDER AREA END -->

    <!-- FOOTER AREA START -->
    <?php require("components/footer.php") ?>
    <!-- FOOTER AREA END -->


    <?php require("components/common_modal.php") ?>
    </div>
    <!-- Body main wrapper end -->
    <script>
        $(document).ready(function () {
            $('input[name="pack_qty"]:checked').trigger('change');


            $('input[name="pack_qty"]').on('change', function () {
                var $initialInput = $('.cart-plus-minus input[name="quantity"]');
                var offer = parseFloat($(this).data('offer')).toFixed(2);
                var mrp = parseFloat($(this).data('mrp')).toFixed(2);
                var qty = parseInt($(this).data('quantity'));
                var $qtyInput = $('.cart-plus-minus input[name="quantity"]');


                $initialInput.val(1).data("maxqty", qty);

                // Update offer & mrp
                $('#offer-price').text('₹' + offer);
                if (mrp !== offer) {
                    $('#mrp-price').text('₹' + mrp).show();
                } else {
                    $('#mrp-price').hide();
                }

                // Disable or enable +/- buttons based on stock
                if (qty <= 0) {
                    $('.qtybutton').addClass('disabled');
                    $('.addto_cart_text').html('<i class="icon-call-in pe-2"></i>Contact Us to Order');
                    $('.addto_cartbtn').css({
                        'background-color': '#b22222',
                        'pointer-events': 'none',
                        'opacity': 0.7
                    });

                    // Highlight selected radio with red
                    $('label[for="' + $(this).attr("id") + '"]').css('background', 'red');

                } else {
                    $('.qtybutton').removeClass('disabled');
                    $('.addto_cart_text').html('<i class="icon-shopping-cart pe-2"></i>ADD TO CART');
                    $('.addto_cartbtn').css({
                        'background-color': '#37724f',
                        'pointer-events': 'auto',
                        'opacity': 1
                    });

                    // Reset label colors
                    $('label').css('color', '');
                }
            });

            // Inc/Dec Button Logic (with "disabled" class check)
            $(".qtybutton").on("click", function () {
                if ($(this).hasClass("disabled")) return;

                var $button = $(this);
                var $input = $button.parent().find("input");
                var oldValue = parseInt($input.val()) || 1;
                var maxQty = parseInt($input.data("maxqty")) || Infinity;

                if ($button.hasClass("inc")) {
                    if (oldValue < maxQty) {
                        $input.val(oldValue + 1);
                    }
                } else {
                    if (oldValue > 1) {
                        $input.val(oldValue - 1);
                    }
                }
            });
        });

    </script>


</body>

</html>