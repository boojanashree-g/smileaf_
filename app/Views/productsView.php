<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php")?>

<body>
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php")?>
        <!-- HEADER AREA END -->

        <!-- BREADCRUMB AREA START -->
        <?php require("components/breadcrumbs.php")?>
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
                                                <a href="<?php echo base_url() . $product['main_image']  ?>"
                                                    data-rel="lightcase:myCollection">
                                                    <img src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                        alt="Image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ltn__shop-details-small-img slick-arrow-2">
                                            <?php foreach( $product['product_images'] as $images): ?>
                                            <div class="single-small-img">
                                                <img src="<?php echo base_url() . $images ?>" alt="Image">
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modal-product-info shop-details-info ps-0">
                                        <h3><?= esc($product['prod_name'] ?? 'Product Name') ?></h3>                                                
                                        <div class="product-price">
                                            <span id="offer-price">₹<?= esc($product['lowest_offer_price'] ?? 0) ?></span>
                                            <del id="mrp-price"
                                                style="<?= ($product['lowest_offer_price'] != $product['lowest_mrp']) ? '' : 'display:none;' ?>">
                                                ₹<?= esc($product['lowest_mrp']) ?>
                                            </del>
                                        </div>
                                    </div>
                                    <div class="modal-product-meta ltn__product-details-menu-1">
                                        <ul>
                                            <li>
                                                <strong>Quantity: (No. of plates)</strong>
                                                <span class="quantity-options">
                                                    <?php
                                                        $lowestQty = $product['lowest_quantity'];                                                    
                                                        foreach ($product['variants'] as $key => $variant):
                                                        if (!is_array($variant))
                                                            continue;

                                                        $packQty = $variant['pack_qty'];
                                                        $inputId = "mqty-" . $packQty;
                                                        $isChecked = ($variant['quantity'] == $lowestQty) ? 'checked' : '';
                                                        $mrp = $variant['mrp'];
                                                        $offerPrice = $variant['offer_price'];
                                                        $quantity = $variant['quantity'];
                                                        $offertype = $variant['offer_type'];
                                                    ?>
                                                        <input class="pack_qty" type="radio" id="<?= $inputId ?>" name="pack_qty" value="<?= $packQty ?>" data-mrp="<?= $mrp ?>" data-offer="<?= $offerPrice ?>" data-quantity="<?= $quantity ?>"  data-prodid="<?=$products[0]['prod_id'] ?>" <?= $isChecked ?>>
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
                                                        data-maxqty="<?= $variant_data['lowest_quantity'] ?>" class="cart-plus-minus-box selected-qty">
                                                        <div class="inc qtybutton">+</div>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle theme-btn-1 btn addto_cartbtn"
                                                    style="width:auto;     background-color: #37724f !important;">
                                                    <span class="addto_cart_text"><i class="icon-shopping-cart pe-2"></i>ADD TO CART</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="ltn__product-details-menu-3">
                                        <ul>
                                            <li>
                                                <a href="#" class="" title="Wishlist" data-bs-toggle="modal"
                                                    data-bs-target="#liton_wishlist_modal">
                                                    <i class="far fa-heart"></i>
                                                    <span>Add to Wishlist</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
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
                                     <p><?= esc($product['prod_name']) ?></p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="liton_tab_details_1_2">
                                <div class="ltn__shop-details-tab-content-inner">
                                    <!-- <h4 class="title-2">Usage</h4> -->
                                    <p><?= esc(strip_tags(trim($product['product_usage']))) ?></p>
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

            <?php if (!empty($product['relatedProducts']) && is_array($product['relatedProducts'])) : ?>
                <?php foreach ($product['relatedProducts'] as $related): ?>
                    <div class="col-lg-12">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?= base_url('product-details/' . $related->prod_id) ?>">
                                    <img src="<?= base_url($related->main_image ?? 'public/assets/img/default-product.png') ?>"
                                         alt="<?= esc($related->prod_name) ?>">
                                </a>
                                <div class="">
                                    <ul>
                                        <?php if (!empty($related->best_seller)) : ?>
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
                                <a class="theme-btn-1 btn quick_btn"
                                   data-prodid="<?= esc($related->prod_id) ?>"
                                   data-menuid="<?= esc($related->menu_id) ?>"
                                   data-submenuid="<?= esc($related->submenu_id) ?>">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Quick Buy</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
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

    <!-- MODAL AREA START (Quick View Modal) -->
    <div class="ltn__modal-area ltn__quick-view-modal-area">
        <div class="modal fade" id="quick_view_modal" tabindex="-1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <!-- <i class="fas fa-times"></i> -->
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ltn__quick-view-modal-inner">
                            <div class="modal-product-item">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="modal-product-img">
                                            <img src="<?php echo base_url() ?>public/assets/img/plate_img/round-plate/10RSP.jpg"
                                                alt="#">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="modal-product-info">
                                            <h3>Rounded plates</h3>
                                            <div class="product-price">
                                                <span>₹149.00</span>
                                                <del>₹165.00</del>
                                                <p class="discount_percentage mt-2">Save 10%</p>
                                            </div>
                                            <div class="modal-product-meta ltn__product-details-menu-1">
                                                <ul>
                                                    <li>
                                                        <strong>Quantity: (No. of plates)</strong>
                                                        <span class="quantity-options">
                                                            <input type="radio" id="mqty-10" name="mquantity" value="10"
                                                                checked>
                                                            <label for="mqty-10">10</label>

                                                            <input type="radio" id="mqty-15" name="mquantity"
                                                                value="15">
                                                            <label for="mqty-15">15</label>

                                                            <input type="radio" id="mqty-20" name="mquantity"
                                                                value="20">
                                                            <label for="mqty-20">20</label>

                                                            <input type="radio" id="mqty-25" name="mquantity"
                                                                value="25">
                                                            <label for="mqty-25">25</label>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="ltn__product-details-menu-2">
                                                <ul>
                                                    <li>
                                                        <div class="cart-plus-minus">
                                                            <input type="text" value="02" name="qtybutton"
                                                                class="cart-plus-minus-box">
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="theme-btn-1 btn " title="Add to Cart"
                                                            data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                                            <i class="fas fa-shopping-cart"></i>
                                                            <span>ADD TO CART</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="ltn__product-details-menu-3">
                                                <ul>
                                                    <li>
                                                        <a href="#" class="" title="Wishlist" data-bs-toggle="modal"
                                                            data-bs-target="#liton_wishlist_modal">
                                                            <i class="far fa-heart"></i>
                                                            <span>Add to Wishlist</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <hr>
                                            <div class="ltn__social-media">
                                                <ul>
                                                    <li>Share:</li>
                                                    <li><a href="#" title="Facebook"><i
                                                                class="fab fa-facebook-f"></i></a></li>
                                                    <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                                                    </li>
                                                    <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" title="Instagram">
                                                            <i class="fab fa-instagram"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL AREA END -->



    <!-- MODAL AREA START (Wishlist Modal) -->
    <div class="ltn__modal-area ltn__add-to-cart-modal-area">
        <div class="modal fade" id="liton_wishlist_modal" tabindex="-1">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ltn__quick-view-modal-inner">
                            <div class="modal-product-item">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="modal-product-img">
                                            <img src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png"
                                                alt="#">
                                        </div>
                                        <div class="modal-product-info">
                                            <h5><a href="<?php echo base_url('productDetails') ?>">10"Square Plates</a>
                                            </h5>
                                            <p class="added-cart"><i class="fa fa-check-circle"></i> Successfully added
                                                to your Wishlist</p>
                                            <div class="btn-wrapper">
                                                <a href="<?php echo base_url('wishlist')?>"
                                                    class="theme-btn-1 btn ">View Wishlist</a>
                                            </div>
                                        </div>
                                        <!-- additional-info -->
                                        <div class="additional-info d-none">
                                            <p>We want to give you <b>10% discount</b> for your first order, <br> Use
                                                discount code at checkout</p>
                                            <div class="payment-method">
                                                <img src="<?php echo base_url() ?>public/assets/img/icons/payment.png"
                                                    alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL AREA END -->
    <?php require("components/common_modal.php")?>
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


        $(".qtybutton").on("click", function () {
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