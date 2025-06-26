<div class="modal-header border-0">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
        style="font-size: 1.5rem;"></button>
</div>
<div class="modal-body p-0">
    <div class="row align-items-start">
        <!-- Product Image -->
        <div class="col-md-6 text-center mb-3">
            <img src="<?= esc(base_url() . $products[0]['main_image']) ?>" class="img-fluid rounded" alt="Product Image"
                style="max-width: 100%;">
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <div class="modal-product-info">
                <h3><?= esc($products[0]['prod_name']) ?></h3>
                <div class="product-price">
                    <span id="offer-price">₹<?= esc($variant_data['lowest_offer_price'] ?? 0) ?></span>
                    <del id="mrp-price"
                        style="<?= ($variant_data['lowest_offer_price'] != $variant_data['lowest_mrp']) ? '' : 'display:none;' ?>">
                        ₹<?= esc($variant_data['lowest_mrp']) ?>
                    </del>
                </div>

                <div class="modal-product-meta ltn__product-details-menu-1">
                    <ul>
                        <li>
                            <strong>Quantity: (No. of plates)</strong>
                            <span class="quantity-options">
                                <?php
                                $lowestQty = $variant_data['lowest_quantity'];
                                foreach ($variant_data as $key => $variant):
                                    if (!is_array($variant))
                                        continue;

                                    $packQty = $variant['pack_qty'];
                                    $inputId = "mqty-" . $packQty;
                                    $isChecked = ($variant['quantity'] == $lowestQty) ? 'checked' : '';


                                    $mrp = $variant['mrp'];
                                    $offerPrice = $variant['offer_price'];
                                    $quantity = $variant['quantity'];

                                    ?>
                                    <input class="pack_qty" type="radio" id="<?= $inputId ?>" name="pack_qty" value="<?= $packQty ?>"
                                        data-mrp="<?= $mrp ?>" data-offer="<?= $offerPrice ?>"
                                        data-quantity="<?= $quantity ?>" 
                                        data-prodid="<?=$products[0]['prod_id'] ?>" <?= $isChecked ?>>
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
                                <input type="text" value="1" name="quantity" 
                                    data-maxqty="<?= $variant_data['lowest_quantity'] ?>" class="cart-plus-minus-box selected-qty">
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
                            <a href="<?php echo base_url('checkout') ?>" class="buy_now_btn">
                                <span>Buy Now</span>
                            </a>
                        </li>
                        <hr>
                        <li class="view_socialmedia_wrappers">
                            <a href="#ltn__utilize-cart-menu" class="view_details">
                                <span>View details<i class="fas fa-arrow-alt-circle-right"></i></span>
                            </a>
                            <ul>
                                <li>Share:</li>
                                <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <div class="ltn__social-media">
                    
                </div>
            </div>
        </div>
    </div>
</div>

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
            var $button = $(this);
            var $input = $button.parent().find("input");


            var oldValue = parseInt($input.val()) || 1;
            var maxQty = parseInt($input.data("maxqty")) || Infinity;

            if ($button.hasClass("inc")) {
                if (oldValue < maxQty) {
                    $input.val(oldValue + 1);
                }
            } else {
              
                 if (oldValue == 1) {
                   return false;
                }
                else if (oldValue >=1) {
                    $input.val(oldValue - 1);
                }
            }
        });
    });

</script>

<script src="<?php echo base_url() ?>custom/js/commoncart.js"></script>