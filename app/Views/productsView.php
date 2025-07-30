<!doctype html>
<html class="no-js" lang="zxx">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<?php require("components/head.php") ?>
<style>
    .blurred-label {
        opacity: 0.5;
        pointer-events: none;
        cursor: not-allowed;
        background-color: rgba(136, 131, 131, 0.72);
    }
    .slick-track #main-image{
        object-fit: contain;
    display: block;
    max-height: 449px;
    width: 100%;
    padding: 4%;
    margin: 2% 3%;
    margin-bottom: 1px;
    border: 1px solid #eee;
    }
    .sub-image img{
        max-height: 100px;
        border: 1px solid #eee;
    }
    .products_page .ltn__product-item-3{
        margin: 10px;
    }




</style>

<body>
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>
        <!-- HEADER AREA END -->

        <!-- BREADCRUMB AREA START -->
        <!-- BREADCRUMB AREA END -->

        <!-- SHOP DETAILS AREA START -->
        <div class="ltn__shop-details-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="ltn__shop-details-inner">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="ltn__shop-details-img-gallery">
                                        <div class="ltn__shop-details-large-img">
                                            <div class="single-large-img">
                                                <a class="main-url" href="<?= esc(base_url() . $products[0]['main_image']) ?>"
                                                    data-rel="lightcase:myCollection">
                                                    <img id="main-image" src="<?= esc(base_url() . $products[0]['main_image']) ?>"
                                                        alt="Image">
                                                </a>
                                            </div>
                                        </div>
                                    
                                        <div class="ltn__shop-details-small-img slick-arrow-2">
                                            <!-- First: main image -->
                                            <div class="single-small-img sub-image active" data-image="<?= $products[0]['main_image'] ?>">
                                                <img src="<?= base_url() . $products[0]['main_image'] ?>" alt="Main Image">
                                            </div>

                                          
                                            <?php foreach ($image_data as $images): ?>
                                                <div class="single-small-img sub-image" data-image="<?= $images['image_path'] ?>">
                                                    <img src="<?= base_url() . $images['image_path'] ?>" alt="Image">
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

                                          <span id="offer-price">₹<?= number_format((float)$priceToShow, 0) ?></span>
                                            <del id="mrp-price"
                                                style="<?= ($priceToShow != $mrpToShow) ? '' : 'display:none;' ?>">
                                                ₹<?= number_format((float)$mrpToShow, 0) ?>
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
                                        $packQty =$variant['pack_qty']; 

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
                                        <!-- <ul>
                                            <li> -->
                                                <div class="cart-plus-minus">
                                                    <input type="text" value="1" name="quantity"
                                                        data-maxqty="<?= $lowestInStockQty ?>"
                                                        class="cart-plus-minus-box selected-qty"
                                                        <?= !$hasStock ? 'disabled' : '' ?>>
                                                </div>
                                            <!-- </li>
                                            <li> -->
                                                <div class="cart_buynow_wrapper mt-3">
                                                    <?php if ($hasStock): ?>
                                                    <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle- theme-btn-1 btn addto_cartbtn" data-source="cart"
                                                        style="width:auto;   background-color: #ff8e00 !important; border-radius: 5px; padding: 10px 25px;">
                                                        <span class="addto_cart_text" style="font-size: 18px; font-weight: 500;"><i class="icon-shopping-cart pe-2"></i>Add To Cart</span>
                                                    </a>

                                                    <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle- theme-btn-1 btn buynow_btn" data-source="buy_now"
                                                        style="width:auto;   background-color: #37724f !important; border-radius: 5px; padding: 10px 25px;">
                                                        <span class="addto_buynow" style="font-size: 18px; font-weight: 500;"><i class="icon-shopping-bags pe-2"></i>Buy Now</span>
                                                    </a>
                                                    <?php else:
                                                        $productName=esc($products[0]['prod_name']);
                                                        $packquantity=$packQty;
                                                        $whatsapp_message=urlencode("Welcome to Smileaf!\nProduct Name: $productName\nPackingQuantity: $packquantity");
                                                        ?>
                                                    <a href="https://wa.me/9842578248?text=<?= $whatsapp_message ?>" 
                                                        class="theme-btn-1 btn whatsapp-order-btn"
                                                        target="_blank"
                                                        style="width: fit-content; background-color: #cc0000 !important; border-radius: 10px;">
                                                       
                                                        <span class="addto_cart_text">CONTACT US TO ORDER</span>
                                                    </a>

                                                    <?php endif; ?>
                                                </div>
                                            <!-- </li>
                                        </ul> -->
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
                                    <!-- <hr> -->
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
                <?php if (!empty($related_products) && is_array($related_products)): ?>
                    <?php foreach ($related_products as $related): ?>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                <div class="product-img">
                                    <a href="<?= base_url("product-details/" . base64_encode($related['prod_id'])) ?>">
                                        <img src="<?= base_url($related['main_image']) ?>"
                                            alt="<?= esc($related['prod_name']) ?>"
                                            loading="lazy">
                                    </a>
                                    <?php if ($related['available_status'] == 0): ?>
                                        <div class="product-badge">
                                            <ul>
                                                <li class="sale-badge">Out of stock</li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <h2 class="product-title">
                                        <a href="<?= base_url($related['url']) ?>">
                                            <span class="prod_name_span"><?= esc($related['prod_name']) ?></span>
                                        </a>
                                    </h2>
                                    <div class="product_price_wrapper mt-0">
                                       <div class="product-price mb-0">
                                            <span>
                                                ₹<?= number_format((float)($related['lowest_offer_price'] ?? 0), 0) ?>
                                            </span>
                                            <?php if (!empty($related['lowest_offer_price']) && $related['lowest_offer_price'] != $related['lowest_mrp']): ?>
                                                <del>
                                                    ₹<?= number_format((float)$related['lowest_mrp'], 0) ?>
                                                </del>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>
                                <?php if ($related['available_status'] == 0) { ?>
                                <div class="d-flex justify-content-evenly">
                                    <a href="<?= base_url("product-details/" . base64_encode($related['prod_id'])) ?>" class="theme-btn-1 btn quick_btn" data-prodid="<?= esc($related['prod_id']) ?>" data-menuid="<?= $related['menu_id'] ?>" data-submenuid=<?= $related['submenu_id'] ?>>
                                        <i class="fab fa-whatsapp text-success me-2"></i>
                                        <span class="text-success">Contact us to order</span>
                                    </a>
                                </div>
                                <?php } else if ($related['available_status'] > 0) { ?>
                                    <div class="d-flex justify-content-evenly">
                                        <a href="<?= base_url("product-details/" . base64_encode($related['prod_id'])) ?>" class="theme-btn-1 btn quick_btn" data-prodid="<?= esc($related['prod_id']) ?>" data-menuid="<?= $related['menu_id'] ?>" data-submenuid=<?= $related['submenu_id'] ?> style="border:1px solid;">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Buy Now</span>
                                        </a>
                                    </div>
                                <?php } ?>
                                <!-- <div class="d-flex justify-content-center mt-2">
                                    <a href="<?= base_url("product-details/" . base64_encode($related['prod_id'])) ?>"
                                    class="theme-btn-1 btn quick_btn <?= $related['available_status'] == 0 ? 'text-danger' : '' ?>"
                                    data-prodid="<?= esc($related['prod_id']) ?>"
                                    data-menuid="<?= $related['menu_id'] ?>"
                                    data-submenuid="<?= $related['submenu_id'] ?>">
                                        <i class="fas fa-shopping-cart <?= $related['available_status'] == 0 ? 'text-danger' : '' ?>"></i>
                                        <span class="<?= $related['available_status'] == 0 ? 'text-danger' : '' ?>">
                                            <?= $related['available_status'] == 0 ? 'Contact us to order' : 'Buy Now' ?>
                                        </span>
                                    </a>
                                </div> -->
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



                var offer = parseFloat($(this).data('offer')) ||0;
                var mrp = parseFloat($(this).data('mrp')) ||0;

                var qty = parseInt($(this).data('quantity')) || 1;
                if (qty <= 0) {
                    qty = 1
                }

                var formattedOffer = offer.toLocaleString('en-IN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0,
                });

                var formattedMrp = mrp.toLocaleString('en-IN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0,
                });


               $('#offer-price').text('₹' + formattedOffer);

                if (mrp !== offer) {
                    $('#mrp-price').text('₹' + formattedMrp).show();
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

                $("#main-image").attr("src" ,mainImage);
                $(".main-url").attr("href" ,mainImage) ;  



               
            })
        });

    </script>
    <script src="<?php echo base_url() ?>custom/js/commoncart.js"></script>
</body>

</html>