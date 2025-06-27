<!doctype html>
<html class="no-js" lang="zxx">
<?php require("components/head.php") ?>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

    <!-- Body main wrapper start -->
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>
        <!-- HEADER AREA END -->

        <!-- BREADCRUMB AREA START -->
        <?php require("components/breadcrumbs.php") ?>
        <!-- BREADCRUMB AREA END -->

        <!-- SHOPING CART AREA START -->
        <div class="liton__shoping-cart-area mb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shoping-cart-inner">
                            <div class="shoping-cart-table table-responsive">
                                <table class="table">
                                    <!-- <thead>
                                    <th class="cart-product-remove">Remove</th>
                                    <th class="cart-product-image">Image</th>
                                    <th class="cart-product-info">Product</th>
                                    <th class="cart-product-price">Price</th>
                                    <th class="cart-product-quantity">Quantity</th>
                                    <th class="cart-product-subtotal">Subtotal</th>
                                </thead> -->
                                    <tbody>

                                        <?php
                                        if ($cart_count <= 0) {

                                            $shoppingTotalClass = "d-none" ?>
                                            <h3>Your cart is empty !!!</h3>
                                        <?php } else {
                                            $shoppingTotalClass = "";
                                            foreach ($cart_product as $cart) {

                                                ?>

                                                <tr>
                                                    <td class="cart-product-remove cart-delete" data-cartid="<?= $cart['cart_id'] ?>"
                                                       >x</td>
                                                    <td class="cart-product-image">
                                                        <a href="<?php echo base_url() ?>product-details/<?= $cart['url'] ?>"><img
                                                                src="<?php echo base_url() ?><?= $cart['main_image'] ?>"
                                                                alt="#"></a>
                                                    </td>
                                                    <td class="cart-product-info">
                                                        <h4><a
                                                                href="<?php echo base_url() ?>product-details/<?= $cart['url'] ?>"><?= $cart['prod_name'] ?></a>
                                                        </h4>
                                                    </td>
                                                    <td>
                                                        <h4>Pack of <?= $cart['cart_pack_qty'] ?></h4>
                                                    </td>
                                                   <td class="cart-product-price">₹<?= number_format((float)$cart['cart_prod_price'], 2) ?></td>

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
                                        }
                                        ?>

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
                            <div class="shoping-cart-total mt-50 <?= $shoppingTotalClass ?>">
                                <h4>Cart Totals</h4>
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
                                <div class="btn-wrapper text-right text-end">
                                    <a href="<?php echo base_url('checkout') ?>"
                                        class="theme-btn-1 btn btn-effect-1">Proceed to checkout</a>
                                </div>
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
                        <button type="button" class="btn btn-secondary delete-cancel" data-dismiss="modal">Cancel</button>
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