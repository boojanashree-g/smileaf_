<header class="ltn__header-area ltn__header-5 ltn__header-transparent">

    <!-- ltn__header-middle-area start -->
    <div
        class="ltn__header-middle-area ltn__header-sticky ltn__sticky-bg-black ltn__logo-right-menu-option plr--9--- header_parent pb-0">
        <div class="container">
            <!-- <div class="primaryHeader"> -->
            <div class="row">
                <div class="col-lg-12 col-12 primaryHeader">
                    <div class="site-logo-wrap">
                        <div class="site-logo"
                            data-logo-default="<?php echo base_url('public/assets/img/logo-2.png'); ?>">
                            <a href="<?php echo base_url() ?>">
                                <img id="site-logo-img" src="<?php echo base_url('public/assets/img/logo-2.png'); ?>"
                                    alt="Logo">
                            </a>
                        </div>
                    </div>
                    <div class="search_bar dsmnone ">
                        <form class="search-form" action="#" method="GET">
                            <div class="search-input-wrap">
                                <input type="text" name="query" placeholder="Search Product..." class="search-input" />
                                <button type="submit" class="search-icon-btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="headerRightContent">
                        <!-- user-menu -->
                        <div class="ltn__drop-menu user-menu">
                            <ul>
                                <li>
                                    <a href="#"><i class="icon-user"></i></a>
                                    <ul>
                                        <li><a href="<?php echo base_url('signin') ?>">Sign in</a></li>
                                        <li><a href="<?php echo base_url('signup') ?>">Register</a></li>
                                        <li><a href="<?php echo base_url('myaccount') ?>">My Account</a></li>
                                        <li><a href="<?php echo base_url('wishlist') ?>">Wishlist</a></li>
                                        <li><a href="<?php echo base_url('contact') ?>">Contact</a></li>
                                        <li><a href="<?php echo base_url() ?>">Bulk Enquiry</a></li>

                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- mini-cart -->
                        <div class="mini-cart-icon dsmnone dmdnone d-block">
                            <a href="<?php echo base_url('cart') ?>" class="header-icons">
                                <i class="icon-shopping-cart"></i>
                                <sup>2</sup>
                            </a>
                        </div>
                        <div class="mini-cart-icon dsmnone dmdnone d-block">
                            <a href="<?php echo base_url('wishlist') ?>" class="header-icons">
                                <i class="far fa-heart"></i>
                                <sup>0</sup>
                            </a>
                        </div>
                        <div class="ltn__header-options ltn__header-options-2 d-lg-none">
                            <div class="mobile-menu-toggle d-xl-none ">
                                <a href="#ltn__utilize-mobile-menu" class="header-icons">
                                    <svg viewBox="0 0 800 600">
                                        <path
                                            d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200"
                                            id="top"></path>
                                        <path d="M300,320 L540,320" id="middle"></path>
                                        <path
                                            d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190"
                                            id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) ">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col header-menu-column menu-color-white">
                <div class="header-menu d-none d-xl-block">
                    <nav>
                        <div class="ltn__main-menu">
                            <ul>
                                <li><a href="<?php echo base_url() ?>">Home</a></li>
                                <li><a href="<?php echo base_url('products') ?>">Shop</a></li>
                                <?php if (!empty($mainmenu)): ?>
                                    <?php foreach ($mainmenu as $menu): ?>
                                        <?php
                                        $menuSlug = base_url('/product-categories/' . $menu['slug']);
                                        $hasChildren = isset($submenu[$menu['menu_id']]);
                                        ?>

                                        <?php if ($hasChildren): ?>
                                            <li class="menu-icon">
                                                <a href="<?= $menuSlug ?>"><?= esc($menu['menu_name']) ?> <span
                                                        class="dropdown-arrow">▼</span></a>
                                                <ul class="sub-menu">
                                                    <?php foreach ($submenu[$menu['menu_id']] as $child): ?>
                                                        <li>
                                                            <a href="<?= base_url('/products/' . base64_encode($child['sub_id']))  ?>">
                                                                <?= esc($child['submenu']) ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <a href="<?= $menuSlug ?>"><?= esc($menu['menu_name']) ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <li><a href="<?php echo base_url('contact') ?>">Contact</a></li>
                                <li><a href="<?php echo base_url() ?>">Bulk Enquiry</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>            
        </div>
    </div>
    </div>
    <!-- ltn__header-middle-area end -->
      <!-- Utilize Cart Menu Start -->
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
        <!-- Utilize Cart Menu End -->

        <!-- Utilize Mobile Menu Start -->
        <div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
            <div class="ltn__utilize-menu-inner ltn__scrollbar">
                <div class="ltn__utilize-menu-head">
                    <div class="site-logo">
                        <a href="<?php echo base_url() ?>"><img
                                src="<?php echo base_url() ?>public/assets/img/logo-2.png" alt="Logo"></a>
                    </div>
                    <button class="ltn__utilize-close">×</button>
                </div>
                <div class="ltn__utilize-menu-search-form">
                    <form action="#">
                        <input type="text" placeholder="Search...">
                        <button><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="ltn__utilize-menu">
                    <ul>
                        <li><a href="<?php echo base_url() ?>">Home</a></li>
                        <li><a href="<?php echo base_url('products') ?>">Shop</a></li>
                        <li><a href="<?php echo base_url() ?>">Disposable Dinnerware</a></li>
                        <li><a href="<?php echo base_url() ?>">Reusable Dinnerware</a></li>
                        <li><a href="<?php echo base_url() ?>">Accessories</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <div class="ltn__utilize-buttons ltn__utilize-buttons-2">
                    <ul>
                        <li>
                            <a href="<?php echo base_url('myaccount') ?>" title="My Account">
                                <span class="utilize-btn-icon">
                                    <i class="far fa-user"></i>
                                </span>
                                My Account
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('wishlist') ?>" title="Wishlist">
                                <span class="utilize-btn-icon">
                                    <i class="far fa-heart"></i>
                                    <sup>3</sup>
                                </span>
                                Wishlist
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('cart') ?>" title="Shoping Cart">
                                <span class="utilize-btn-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                    <sup>5</sup>
                                </span>
                                Shoping Cart
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="ltn__social-media-2">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                        <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Utilize Mobile Menu End -->

        <div class="ltn__utilize-overlay"></div>
</header>
