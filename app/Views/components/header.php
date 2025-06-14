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
                    <div class="search_bar">
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
                        <div class="mini-cart-icon">
                            <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle">
                                <i class="icon-shopping-cart"></i>
                                <sup>2</sup>
                            </a>
                        </div>
                        <div class="mini-cart-icon">
                            <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle">
                                <i class="far fa-heart"></i>
                                <sup>0</sup>
                            </a>
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
                                                            <a href="<?= base_url('/product-categories/' . $child['slug']) ?>">
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
                            <!-- <ul>
                                     <li><a href="<?php echo base_url() ?>">Home</a></li>
                                     <li><a href="<?php echo base_url('products') ?>">Shop</a></li>
                                     <li><a href="<?php echo base_url() ?>">Disposable Dinnerware</a></li>
                                     <li><a href="<?php echo base_url() ?>">Reusable Dinnerware</a></li>
                                     <li><a href="<?php echo base_url() ?>">Accessories</a></li>
                                     <li><a href="<?php echo base_url('contact') ?>">Contact</a></li>
                                     <li><a href="<?php echo base_url() ?>">Bulk Enquiry</a></li>

                                 </ul> -->
                        </div>
                    </nav>
                </div>
            </div>
            <div class="ltn__header-options ltn__header-options-2 d-lg-none">
                <div class="mobile-menu-toggle d-xl-none ">
                    <a href="#ltn__utilize-mobile-menu" class="ltn__utilize-toggle">
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
    <!-- ltn__header-middle-area end -->
</header>
