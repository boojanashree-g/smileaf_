<!doctype html>
<html class="no-js" lang="zxx">
<?php require("components/head.php") ?>
<style>
    .card {
        border: 0;
        display: flex;
        align-items: center;
    }

    .card .card-header {
        background-color: unset;
        border-bottom: unset;
        padding: 24px;
        border-bottom: unset;
        border-top-left-radius: unset;
        border-top-right-radius: unset;
    }

    .card-header:first-child {
        border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
    }

    .btn-primary,
    .btn-primary.disabled,
    .btn-primary:disabled {
        background-color: #c62931;
        border-color: #d3d3d3;
        font-weight: 500;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px 30px;
        0 width: auto;
        max-width: max-content;
        margin: 0 !important;
    }

    .prod_details_h4 {
        width: 200px;
        display: block;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        text-transform: capitalize;
    }

    .proceed_checkout {
        border-radius: 0;
        background-color: #ec7b00;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }

    .proceed_checkout i {
        margin-left: 10px !important;
    }

    .cart-product-info h4 {
        margin: 5px 0;
    }

    .cart_details {
        margin: 30px 0 0 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 700 !important;
    }
</style>

<body>

    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>
        <!-- HEADER AREA END -->



        <!-- SHOPING CART AREA START -->
        <div class="liton__shoping-cart-area ">


            <div class="container">
                <div class="row">

                    <?php
                    if ($cart_count <= 0) {
                        $shoppingTotalClass = "d-none"
                            ?>
                        <div class="container-fluid ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body cart">
                                            <div class="col-sm-12 empty-cart-cls text-center">
                                                <img src="https://i.imgur.com/dCdflKN.png" width="130" height="130"
                                                    class="img-fluid mb-4 mr-3">
                                                <h3><strong>Your Cart is Empty</strong></h3>
                                                <a href="<?php echo base_url('products') ?>"
                                                    class="btn btn-primary cart-btn-transform m-3" data-abc="true"><i
                                                        class="icon-left-arrow pe-2"></i>continue shopping</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } else {
                        ?>

                        <div class="col-lg-8">
                            <h4 class="cart_details">Cart Details</h4>
                            <?=
                                $shoppingTotalClass = "";
                            foreach ($cart_product as $cart) {
                                ?>

                                <div class="shoping-cart-inner">
                                    <div class="shoping-cart-table table-responsive">

                                        <table class="table">
                                            <tbody>

                                                <tr>
                                                    <td class="cart-product-remove cart-delete"
                                                        data-cartid="<?= $cart['cart_id'] ?>">x</td>
                                                    <td class="cart-product-image">
                                                        <a><img src="<?php echo base_url() ?><?= $cart['main_image'] ?>"
                                                                alt="<?= $cart['prod_name'] ?>"></a>
                                                    </td>
                                                    <td class="cart-product-info">
                                                        <h4>
                                                            <a class="prod_details_h4"
                                                                href="<?php echo base_url() ?>product-details/<?= $cart['url'] ?>"><?= $cart['prod_name'] ?></a>
                                                        </h4>
                                                        <span>Pack of <?= $cart['cart_pack_qty'] ?></span><br>
                                                        <?php
                                                        $stockStatus = $cart['variant_qty'] <= 0 ? "<span class='text-red'>Out of Stock</span>" : "";
                                                        echo $stockStatus;
                                                        ?>
                                                    </td>
                                                    <!-- <td>
                                                        <h4>Pack of <?= $cart['cart_pack_qty'] ?></h4>
                                                    </td> -->
                                                    <!-- <td class="cart-product-price">₹<?= number_format((float) $cart['cart_prod_price'], 2) ?></td> -->

                                                    <td class="cart-product-quantity">
                                                        <div class="cart-plus-minus">
                                                            <!--  -  -->
                                                            <div class="dec qtybutton btn-decrement"
                                                                data-cartid="<?= $cart['cart_id'] ?>">-
                                                            </div>

                                                            <!-- Final Price -->
                                                            <input type="text" value="<?= $cart['cart_quantity'] ?>"
                                                                name="qtybutton"
                                                                class="cart-plus-minus-box quantity_<?= $cart['cart_id'] ?>"
                                                                data-originalprice="<?= $cart['offer_price'] ?>" readonly>

                                                            <!--  + -->
                                                            <div class="inc qtybutton btn-increment"
                                                                data-cartid="<?= $cart['cart_id'] ?>"
                                                                data-finalstock="<?= $cart['variant_qty'] ?>">+
                                                            </div>

                                                        </div>
                                                    </td>
                                                    <td class="cart-product-subtotal total_<?= $cart['cart_id'] ?>"
                                                        data-gst="<?= $cart['gst'] ?>">
                                                        ₹<?= $cart['cart_total_price'] ?>
                                                    </td>
                                                </tr>
                                            <?php }
                    } ?>


                                        <!-- <tr class="cart-coupon-row">
                                        <td colspan="6">
                                            <div class="cart-coupon">
                                                <input type="text" name="cart-coupon" placeholder="Coupon code">
                                                <button type="submit" class="btn theme-btn-2 btn-effect-2">Apply Coupon</button>
                                            </div>
                                        </td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <input type="hidden" id="outof_stock_status" value="<?= session()->get('outof_status') ?>"
                        data-checkout="<?= session()->get('checkout') ?>">
                    <div class="col-lg-4">
                        <div class="shoping-cart-total <?= $shoppingTotalClass ?>">
                            <h4 class="cart_details mb-4">Cart Totals</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Sub total</td>
                                        <td class="order-subtotal">-</td>
                                    </tr>
                                    <tr>
                                        <td>CGST(Includes)</td>
                                        <td class="gst-td">-</td>
                                    </tr>
                                    <tr>
                                        <td>SGST(Includes)</td>
                                        <td class="sgst-td">-</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Charge</td>
                                        <td class="shipping-charge">₹100.00</td>
                                    </tr>

                                    <tr>
                                        <td><strong>Order Total</strong></td>
                                        <td><strong class="order_total_amt"></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="btn-wrapper cart_action_div text-right text-end">
                                <a class="proceed_checkout">Proceed
                                    to checkout
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                <a href="<?php echo base_url('products') ?>" class="continue_shopping_btn"
                                    data-abc="true">
                                    <i class="icon-left-arrow pe-2"></i>continue shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal HTML -->
        <div id="delete-modal" class="modal fade delete-modall">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header flex-column">
                        <div class="icon-box">
                            <i class="material-icons">&#xE5CD;</i>
                        </div>
                        <h4 class="modal-title w-100">Are you sure?</h4>

                    </div>
                    <div class="modal-body">
                        <p>Do you really want to delete the product? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary delete-cancel"
                            data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger btn-delete">Delete</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- SHOPING CART AREA END -->

        <!-- FOOTER AREA START -->
        <?php require("components/footer.php") ?>
        <!-- FOOTER AREA END -->


    </div>
    <!-- Body main wrapper end -->

    <!-- All JS Plugins -->
    <script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
    <!-- Main JS -->
    <script src="<?php echo base_url() ?>custom/js/cart.js"></script>

    <script src="<?php echo base_url() ?>public/assets/js/main.js"></script>



</body>

</html>