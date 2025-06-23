<!-- MODAL AREA START (Add To Cart Modal) -->
<div class="modal fade" id="quick_buy_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Areca Palm Leaf plate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="font-size: 1.5rem;"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-start">
                    <!-- Product Image -->
                    <div class="col-md-6 text-center mb-3">
                        <img src="<?= base_url('public/assets/img/plate_img/square-plate/4square.png') ?>"
                            class="img-fluid rounded" alt="Product Image" style="max-width: 100%;">
                    </div>

                    <!-- Product Info -->
                    <div class="col-md-6">
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
                                            <input type="radio" id="mqty-10" name="mquantity" value="10" checked>
                                            <label for="mqty-10">10</label>

                                            <input type="radio" id="mqty-15" name="mquantity" value="15">
                                            <label for="mqty-15">15</label>

                                            <input type="radio" id="mqty-20" name="mquantity" value="20">
                                            <label for="mqty-20">20</label>

                                            <input type="radio" id="mqty-25" name="mquantity" value="25">
                                            <label for="mqty-25">25</label>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="ltn__product-details-menu-2">
                                <ul>
                                    <li>
                                        <div class="cart-plus-minus">
                                            <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle theme-btn-1 btn" style="width:auto;     background-color: #37724f !important;" >
                                            <span><i class="icon-shopping-cart pe-2"></i>ADD TO CART</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="ltn__product-details-menu-3">
                                <ul>
                                    <li>
                                        <a href="<?php echo base_url('checkout') ?>" class="buy_now_btn" >
                                            <span>Buy Now</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#ltn__utilize-cart-menu" class="view_details" >
                                            <span>View details </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <hr>
                            <div class="ltn__social-media">
                                <ul>
                                    <li>Share:</li>
                                    <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                    <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL AREA START (Add To Cart Modal) -->
    <div class="ltn__modal-area ltn__add-to-cart-modal-area">
        <div class="modal fade" id="add_to_cart_modal" tabindex="-1">
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
                                            <img src="<?php echo base_url() ?>public/assets/img/plate_img/square-plate/4square.png" alt="#">
                                        </div>
                                         <div class="modal-product-info">
                                            <h5><a href="<?php echo base_url('productDetails') ?>">10"Square Plates</a></h5>
                                            <p class="added-cart"><i class="fa fa-check-circle"></i>  Successfully added to your Cart</p>
                                            <div class="btn-wrapper">
                                                <a href="<?php echo base_url('cart') ?>" class="theme-btn-1 btn ">View Cart</a>
                                                <a href=""<?php echo base_url('checkout') ?>" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                                            </div>
                                         </div>
                                         <!-- additional-info -->
                                         <div class="additional-info d-none">
                                            <p>We want to give you <b>10% discount</b> for your first order, <br>  Use discount code at checkout</p>
                                            <div class="payment-method">
                                                <img src="<?php echo base_url() ?>public/assets/img/icons/payment.png" alt="#">
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
 <div id="ltn__utilize-cart-menu" class="ltn__utilize ltn__utilize-cart-menu">
            <div class="ltn__utilize-menu-inner ltn__scrollbar">
                <div class="ltn__utilize-menu-head">
                    <span class="ltn__utilize-menu-title">Cart</span>
                    <button class="ltn__utilize-close">×</button>
                </div>
                <div class="mini-cart-product-area ltn__scrollbar">
                    <div class="mini-cart-item clearfix">
                        <div class="mini-cart-img">
                            <a href="#"><img
                                    src="<?php echo base_url() ?>public/assets/img/plate_img/round-plate/10RSP.jpg"
                                    alt="Image"></a>
                            <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                        </div>
                        <div class="mini-cart-info">
                            <h6><a href="#">Red Hot Tomato</a></h6>
                            <span class="mini-cart-quantity">1 x $65.00</span>
                        </div>
                    </div>
                    <div class="mini-cart-item clearfix">
                        <div class="mini-cart-img">
                            <a href="#"><img
                                    src="<?php echo base_url() ?>public/assets/img/plate_img/round-plate/10RSP.jpg"
                                    alt="Image"></a>
                            <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                        </div>
                        <div class="mini-cart-info">
                            <h6><a href="#">Vegetables Juices</a></h6>
                            <span class="mini-cart-quantity">1 x $85.00</span>
                        </div>
                    </div>
                    <div class="mini-cart-item clearfix">
                        <div class="mini-cart-img">
                            <a href="#"><img
                                    src="<?php echo base_url() ?>public/assets/img/plate_img/round-plate/10RSP.jpg"
                                    alt="Image"></a>
                            <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                        </div>
                        <div class="mini-cart-info">
                            <h6><a href="#">Orange Sliced Mix</a></h6>
                            <span class="mini-cart-quantity">1 x $92.00</span>
                        </div>
                    </div>
                    <div class="mini-cart-item clearfix">
                        <div class="mini-cart-img">
                            <a href="#"><img
                                    src="<?php echo base_url() ?>public/assets/img/plate_img/round-plate/10RSP.jpg"
                                    alt="Image"></a>
                            <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                        </div>
                        <div class="mini-cart-info">
                            <h6><a href="#">Orange Fresh Juice</a></h6>
                            <span class="mini-cart-quantity">1 x $68.00</span>
                        </div>
                    </div>
                </div>
                <div class="mini-cart-footer">
                    <div class="mini-cart-sub-total">
                        <h5>Subtotal: <span>$310.00</span></h5>
                    </div>
                    <div class="btn-wrapper">
                        <a href="<?php echo base_url('cart') ?>" class="theme-btn-1 btn btn-effect-1">View Cart</a>
                        <a href="<?php echo base_url('checkout') ?>" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                    </div>
                    <p>Free Shipping on All Orders Over $100!</p>
                </div>

            </div>
        </div>
    <!-- Styling -->
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
    </style>
    <!-- MODAL AREA END -->