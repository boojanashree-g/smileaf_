<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>
<style>
    .blurred-label {
        opacity: 0.5;
        pointer-events: none;
        cursor: not-allowed;
        background-color: rgba(136, 131, 131, 0.72);
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
                                                <a href="<?= esc(base_url() . $products[0]['main_image']) ?>"
                                                    data-rel="lightcase:myCollection">
                                                    <img id="main-image" src="<?= esc(base_url() . $products[0]['main_image']) ?>"
                                                        alt="Image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ltn__shop-details-small-img slick-arrow-2">
                                            <?php foreach ($image_data as $images): ?>
                                                <div class="single-small-img sub-image" data-image="<?= $images['image_path'] ?>">
                                                    <img src="<?= base_url() ?><?= $images['image_path'] ?>" alt="Image">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modal-product-info shop-details-info ps-0">
                                        <h3><?= esc($products[0]['prod_name']) ?></h3>
                                        <div class="product-price">
                                            <?php
                                            $priceToShow = null;
                                            $mrpToShow = null;
                                            $allOutOfStock = true;

                                            // Check if any variant is in stock
                                            foreach ($variant_data['list'] as $variant) {
                                                if (!is_array($variant))
                                                    continue;

                                                if ((int) $variant['quantity'] > 0) {
                                                    $allOutOfStock = false;

                                                    $priceToShow = $variant['offer_price'];
                                                    $mrpToShow = $variant['mrp'];
                                                    break;
                                                }
                                            }

                                            // If all are out of stock
                                            if ($allOutOfStock) {
                                                $priceToShow = $variant_data['lowest_offer_price'];
                                                $mrpToShow = $variant_data['lowest_mrp'];
                                            }
                                            ?>

                                            <span id="offer-price">₹<?= esc($priceToShow) ?></span>
                                            <del id="mrp-price"
                                                style="<?= ($priceToShow != $mrpToShow) ? '' : 'display:none;' ?>">
                                                ₹<?= esc($mrpToShow) ?>
                                            </del>
                                        </div>

                                    </div>
                                    <div class="modal-product-meta ltn__product-details-menu-1">
                                        <ul>
                                            <li>
                                                <strong>Quantity: (No. of plates)</strong>
                                                <span class="quantity-options">
                                                    <?php
                                                    $lowestSet = false;

                                                    foreach ($variant_data['list'] as $variant):
                                                        if (!is_array($variant))
                                                            continue;

                                                        $packQty = $variant['pack_qty'];
                                                        $quantity = (int) $variant['quantity'];
                                                        $inputId = "mqty-" . $packQty;

                                                        $mrp = $variant['mrp'];
                                                        $offerPrice = $variant['offer_price'];

                                                        $isDisabled = ($quantity == 0) ? 'disabled' : '';
                                                        $labelClass = ($quantity == 0) ? 'blurred-label' : '';

                                                        // First available (in-stock) variant gets checked
                                                        $isChecked = (!$lowestSet && $quantity > 0) ? 'checked' : '';
                                                        if ($isChecked)
                                                            $lowestSet = true;
                                                        ?>
                                                        <input class="pack_qty" type="radio" id="<?= $inputId ?>"
                                                            name="pack_qty" value="<?= $packQty ?>" data-mrp="<?= $mrp ?>"
                                                            data-offer="<?= $offerPrice ?>" data-quantity="<?= $quantity ?>"
                                                            data-prodid="<?= $products[0]['prod_id'] ?>" <?= $isChecked ?>
                                                            <?= $isDisabled ?>>

                                                        <label for="<?= $inputId ?>"
                                                            class="<?= $labelClass ?>"><?= $packQty ?></label>
                                                    <?php endforeach; ?>
                                                </span>

                                            </li>
                                        </ul>
                                    </div>

                                    <?php
                                    $lowestInStockQty = null;
                                    $hasStock = false;
                                    foreach ($variant_data['list'] as $variant) {
                                        if (!is_array($variant))
                                            continue;
                                        $qty = (int) $variant['quantity'];

                                        if ($qty > 0) {
                                            $hasStock = true;
                                            if ($lowestInStockQty === null || $variant['quantity'] < $lowestInStockQty) {
                                                $lowestInStockQty = $variant['quantity'];
                                            }
                                        }
                                    }
                                    if ($lowestInStockQty === null) {
                                        $lowestInStockQty = $variant_data['lowest_quantity'];
                                    }
                                    ?>

                                    <div class="ltn__product-details-menu-2">
                                        <ul>
                                            <li>
                                                <div class="cart-plus-minus">
                                                    <input type="text" value="1" name="quantity"
                                                        data-maxqty="<?= $lowestInStockQty ?>"
                                                        class="cart-plus-minus-box selected-qty"
                                                        <?= !$hasStock ? 'disabled' : '' ?>>
                                                </div>
                                            </li>
                                            <li>
                                                <?php if ($hasStock): ?>
                                                <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle- theme-btn-1 btn addto_cartbtn"
                                                    style="width:auto;   background-color: #37724f !important;">
                                                    <span class="addto_cart_text"><i class="icon-shopping-cart pe-2"></i>ADD TO CART</span>
                                                </a>
                                                <?php else: ?>
                                                    <a href="tel:+919999999999" 
                                                        class="ltn__utilize-toggle theme-btn-1 btn"
                                                        style="width:auto; background-color: #cc0000 !important;">
                                                        <span class="addto_cart_text">
                                                            <i class="icon-phone pe-2"></i>CONTACT US TO ORDER
                                                        </span>
                                                    </a>
                                                <?php endif; ?>
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
                                
                                    <?= esc(strip_tags(trim($products[0]['description']))) ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="liton_tab_details_1_2">
                                <div class="ltn__shop-details-tab-content-inner">
                                   
                                    <p><?= esc(strip_tags(trim($products[0]['product_usage']))) ?></p>
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
            $('input[name="pack_qty"]').on('change', function () {
                var $initialInput = $('.cart-plus-minus input[name="quantity"]');
                $initialInput.val(1).data("maxqty", $initialInput.val());



                var offer = parseFloat($(this).data('offer')).toFixed(2);
                var mrp = parseFloat($(this).data('mrp')).toFixed(2);

                var qty = parseInt($(this).data('quantity')) || 1;
                if (qty <= 0) {
                    qty = 1
                }


                $('#offer-price').text('₹' + offer);

                if (mrp !== offer) {
                    $('#mrp-price').text('₹' + mrp).show();
                } else {
                    $('#mrp-price').hide();
                }

                var $qtyInput = $('.cart-plus-minus input[name="quantity"]');
                if ($qtyInput.length) {
                    $qtyInput.data("maxqty", qty);

                } else {
                    console.warn('Quantity input not found in DOM!');
                }


            });

            // Quantity +/- logic
            $(".cart-plus-minus").prepend('<div class="dec qtybutton">-</div>');
            $(".cart-plus-minus").append('<div class="inc qtybutton">+</div>');

            $(".qtybutton").on("click", function () {

                const selectedVariant = $("input[name='pack_qty']:checked");

                if (selectedVariant.length === 0) {
                    showToast("This item is currently out of stock.Contact us", "error");
                    $(".qtybutton").prop("disabled", true);
                    return;
                }
                var $button = $(this);
                var $input = $button.parent().find("input");


                var oldValue = parseInt($input.val()) || 1;
                var maxQty = parseInt($input.data("maxqty")) || 9999;


                if ($button.hasClass("inc")) {
                    let currentValue = parseInt($input.val());

                    if (currentValue < maxQty) {
                        $input.val(currentValue + 1);
                    } else {
                        showToast("Maximum Stock Reached", "info");
                    }
                } else {
                    let currentValue = parseInt($input.val());
                    if (currentValue > 1) {
                        $input.val(currentValue - 1);
                    }
                }
            });



            // Dynamic Image rendering  
            const base_Url = "<?= base_url() ?>";
            $(".sub-image").click(function(){
                let currentImg = $(this).data("image");
                let mainImage =  base_Url + currentImg;

                $("#main-image").attr("src" ,mainImage)


               
            })
        });

    </script>


    <script src="<?php echo base_url() ?>custom/js/commoncart.js"></script>
     


</body>

</html>