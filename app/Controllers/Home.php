<?php

namespace App\Controllers;

use App\Models\admin\MainmenuModel;
use App\Models\admin\SubmenuModel;
use App\Models\admin\BannerModel;
use App\Models\ProductModel;


class Home extends BaseController
{
    public function index()
    {    
        $mainmenu = $this->getMenuData();
        $bannerModel = new BannerModel();
        $bannerData = $bannerModel->where(['flag !=' => 0, 'has_banner' => 1])->findAll();
        $data = array_merge($this->getMenuData(), [
            'bannerData' => $bannerData
        ]);
        return view('index', $data);
    }

    private function getMenuData()
    {
        $mainmenuModel = new MainmenuModel();
        $submenuModel = new SubmenuModel();

        $mainmenus = $mainmenuModel->where('flag !=', 0)->findAll();
        $submenus = $submenuModel->where('flag !=', 0)->findAll();

        $groupedSubmenus = [];
        foreach ($submenus as $submenu) {
            $groupedSubmenus[$submenu['menu_id']][] = $submenu;
        }

        return [
            'mainmenu' => $mainmenus,
            'submenu' => $groupedSubmenus
        ];
    }

    public function productDetails()
    {
        $data = array_merge($this->getMenuData(), [
            'page_title' => 'Product View',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Product View']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);

        return view('productsView', $data);
    }
    public function cart()
    {
        $data = array_merge($this->getMenuData(), [
            'page_title' => 'cart',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'cart']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);

        return view('cart', $data);
    }
    public function checkout()
    {
        $data = array_merge($this->getMenuData(), [
            'page_title' => 'checkout',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'checkout']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);

        return view('checkout', $data);
    }
    public function contact()
    {
        $data = array_merge($this->getMenuData(), [
            'page_title' => 'contact',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'contact']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);

        return view('contact', $data);
    }
    
    public function products($encodedSubmenuId = null)
    {
        $db = \Config\Database::connect();
        $menuData = $this->getMenuData();

        // Decode submenu ID from URL
        $submenuId = null;
        if ($encodedSubmenuId) {
            $submenuId = base64_decode($encodedSubmenuId);
            if (!is_numeric($submenuId)) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Invalid product category");
            }
        }

        // Filter parameters from query string
        $typeIds = $this->request->getGet('type_id');
        $sizeIds = $this->request->getGet('size_id');
        $shapeIds = $this->request->getGet('shape_id');

        // Detect AJAX
        $isAjax = $this->request->isAJAX() ||
            $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest' ||
            $this->request->getGet('ajax') == '1';

        // Load filter dropdowns only if not AJAX
        if (!$isAjax) {
            $typeQuery = $db->table('tbl_filter_type')->where('flag !=', 0)->get();
            $sizeQuery = $db->table('tbl_filter_size')->where('flag !=', 0)->get();
            $shapeQuery = $db->table('tbl_filter_shapes')->where('flag !=', 0)->get();

            $productTypes = $typeQuery->getResult();
            $productsize = $sizeQuery->getResult();
            $productShape = $shapeQuery->getResult();
        }

        // Build products query
        $productsQuery = $db->table('tbl_products a')
            ->select('a.*, b.size_name, d.type_name, e.mrp, e.stock_status, e.offer_price')
            ->join('tbl_filter_size b', 'a.size_id = b.size_id', 'left')
            ->join('tbl_filter_type d', 'a.type_id = d.type_id', 'left')
            ->join('tbl_variants e', 'a.prod_id = e.prod_id', 'left')
            ->where('a.flag !=', 0);

        // Apply submenu ID filter
        if ($submenuId) {
            $productsQuery->where('a.submenu_id', $submenuId);
        }

        // Apply other filters
        if (!empty($typeIds)) {
            $productsQuery->whereIn('a.type_id', (array)$typeIds);
        }

        if (!empty($sizeIds)) {
            $productsQuery->whereIn('a.size_id', (array)$sizeIds);
        }

        if (!empty($shapeIds)) {
            $productsQuery->whereIn('a.shape_id', (array)$shapeIds);
        }

        // Fetch product data
        $products = $productsQuery->get()->getResult();

        // Return JSON for AJAX
        if ($isAjax) {
            return $this->response->setJSON([
                'success' => true,
                'products' => $products,
                'count' => count($products),
                'mainmenus' => $menuData,
                'groupedSubmenus' => $menuData['submenu']
            ]);
        }

        // For normal page rendering
        $data = array_merge($menuData, [
            'page_title' => 'Products',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Products']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png'),
            'products' => $products,
            'productTypes' => $productTypes ?? [],
            'productsize' => $productsize ?? [],
            'productShape' => $productShape ?? [],
        ]);

        return view('products', $data);
    }


    public function wishlist()
    {
        $menuData = $this->getMenuData();

        $data = array_merge($menuData, [

            'page_title' => 'Wishlist',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Wishlist']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);

        return view('wishlist', $data);
    }
    public function myaccount()
    {
        $menuData = $this->getMenuData();

        return view('myaccount',$menuData);
    }
    public function signup()
    {
        $menuData = $this->getMenuData();

        $data = array_merge($menuData, [
            'page_title' => 'Sign-Up',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Sign-Up']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);

        return view('signup', $data);
    }
    public function signin()
    {
        $menuData = $this->getMenuData();
        $data = array_merge($menuData, [
            'page_title' => 'Sign-In',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Sign-In']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);

        return view('signin', $data);
    }
    public function termsAndConditions()
    {
        $menuData = $this->getMenuData();
        $data = array_merge($menuData, [
            'page_title' => 'Terms & Conditions',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Terms & Conditions']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);

        return view('termsAndConditions', $data);
    }
    public function privacyPolicy()
    {
        $menuData = $this->getMenuData();
        $data = array_merge($menuData, [
            'page_title' => 'Privacy Policy',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Privacy Policy']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);

        return view('privacyPolicy', $data);
    }
    public function orderTracking()
    {
        $menuData = $this->getMenuData();
        $data = array_merge($menuData, [
            'page_title' => 'Order Tracking',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Order Tracking']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);

        return view('orderTracking', $data);
    }
    public function productCategories($slug)
{
    $mainmenuModel = new MainmenuModel(); 
    $submenuModel = new SubmenuModel();

    $menuData = $mainmenuModel->where('slug', $slug)->first();

    if (!$menuData) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Main menu not found");
    }

    $menuId = $menuData['menu_id'];
    $submenuData = $submenuModel->where('menu_id', $menuId)->findAll();

    // Get common menu data
    $menus = $this->getMenuData();

    // Merge everything
    $data = array_merge($menus, [
        'page_title' => $menuData['menu_name'],
        'breadcrumb_items' => [
            ['label' => 'Home', 'url' => base_url()],
            ['label' => $menuData['menu_name']]
        ],
        'banner_image' => base_url('public/assets/img/banner/bg_4.png'),
        'submenus' => $submenuData
    ]);

    return view('productCategories', $data);
}

}