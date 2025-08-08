<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo" id="brand-logo">
        <a href="<?= base_url() ?>admin/dashboard" class="app-brand-link">
            <img class="p-2" width="" src="" id="sidenav-img">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item parent-item">
            <a href="<?= base_url() ?>admin/dashboard" class="menu-link menu-toggle-">
                <i class="menu-icon tf-icons ti ti-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <li class="menu-item parent-item">
            <a href="<?= base_url() ?>admin/order-details" class="menu-link menu-toggle-">
                <i class="menu-icon tf-icons ti ti-shopping-cart"></i>

                <div data-i18n="Order Details">Order Details</div>
            </a>
        </li>
        <li class="menu-item parent-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-package"></i>

                <div data-i18n="Manage Products">Manage Products</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= base_url('admin/product-details') ?>" class="menu-link">
                        <div data-i18n="Product Details">Product Details</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= base_url('admin/featured-products') ?>" class="menu-link">
                        <div data-i18n="Product Details">Featured Product </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= base_url('admin/filter-types') ?>" class="menu-link">
                        <div data-i18n="Product Types">Product Types</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= base_url('admin/filter-shapes') ?>" class="menu-link">
                        <div data-i18n="Product Shapes">Product Shapes</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= base_url('admin/filter-size') ?>" class="menu-link">
                        <div data-i18n="Product Size">Product Size</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item parent-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>

                <div data-i18n="Manage Customer">Manage Customers</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= base_url('admin/customer-details') ?>" class="menu-link">
                        <div data-i18n="Customer Details">Customer Details</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item parent-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">

                <i class="menu-icon tf-icons ti ti-layout-grid"></i>
                <div data-i18n="Manage Headers">Manage Headers</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= base_url('admin/main-menu') ?>" class="menu-link">
                        <div data-i18n="Main Menu">Main Menu</div>
                    </a>
                </li>
            </ul>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= base_url('admin/sub-menu') ?>" class="menu-link">
                        <div data-i18n="Sub Menu">Sub Menu</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- <li class="menu-item parent-item">
            .
            <a href="javascript:void(0);" class="menu-link menu-toggle">

                <i class="menu-icon tf-icons ti ti-filter"></i>
                <div data-i18n="Manage Filters">Manage Filters</div>
            </a>


        </li> -->
        <li class="menu-item parent-item">
            <a href="<?= base_url() ?>admin/banner" class="menu-link menu-toggle-">
                <i class="menu-icon tf-icons ti ti-wallet"></i>
                <div data-i18n="Manage Banner">Manage Banner</div>
            </a>

        </li>
        <li class="menu-item parent-item">
            <a href="<?= base_url() ?>admin/courier" class="menu-link menu-toggle-">

                <i class="menu-icon tf-icons ti ti-truck"></i>

                <div data-i18n="Manage Banner">Manage Delivery Offers</div>
            </a>

        </li>
    </ul>
</aside>