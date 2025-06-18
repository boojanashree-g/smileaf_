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
        $mainmenumodel = new MainmenuModel();
        $submenumodel = new SubmenuModel();
        $bannerModel = new BannerModel();
        $mainmenus = $mainmenumodel->where('flag !=', 0)->findAll();
        $submenus = $submenumodel->where('flag !=', 0)->findAll();
        $bannerData = $bannerModel->where(['flag !=' => 0, 'has_banner' => 1])->findAll();
        $groupedSubmenus = [];
        foreach ($submenus as $submenu) {
            $groupedSubmenus[$submenu['menu_id']][] = $submenu;
        }
        $data['mainmenu'] = $mainmenus;
        $data['submenu'] = $groupedSubmenus;
        $data['bannerData'] = $bannerData;
        return view('index', $data);
    }


    public function productDetails()
    {
        $data = [
            'page_title' => 'Product View',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Product View']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('productsView', $data);
    }
    public function cart()
    {
        $data = [
            'page_title' => 'cart',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'cart']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('cart', $data);
    }
    public function checkout()
    {
        $data = [
            'page_title' => 'checkout',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'checkout']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('checkout', $data);
    }
    public function contact()
    {
        $data = [
            'page_title' => 'contact',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'contact']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('contact', $data);
    }
       public function products()
        {
            $db = \Config\Database::connect();
            
            // Get filter parameters
            $typeIds = $this->request->getGet('type_id');
            $sizeIds = $this->request->getGet('size_id');
            $availability = $this->request->getGet('availability');
            
            // Check if it's an AJAX request
            $isAjax = $this->request->isAJAX() ||
                    $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest' ||
                    $this->request->getGet('ajax') == '1';
            
            // Get filter options for dropdowns (only for non-AJAX requests)
            if (!$isAjax) {
                $typeQuery = $db->table('tbl_filter_type')->where('flag !=', 0)->get();
                $sizeQuery = $db->table('tbl_filter_size')->where('flag !=', 0)->get();
                $productTypes = $typeQuery->getResult();
                $productsize = $sizeQuery->getResult();
            }
            
            // Build products query
            $productsQuery = $db->table('tbl_products a')
                ->select('a.*, b.size_name, d.type_name')
                ->join('tbl_filter_size b', 'a.size_id = b.size_id', 'left')
                ->join('tbl_filter_type d', 'a.type_id = d.type_id', 'left')
                ->where('a.flag !=', 0);
            
            // Apply type filter
            if (!empty($typeIds)) {
                if (is_array($typeIds)) {
                    $productsQuery->whereIn('a.type_id', $typeIds);
                } else {
                    $productsQuery->where('a.type_id', $typeIds);
                }
            }
            
            // Apply size filter
            if (!empty($sizeIds)) {
                if (is_array($sizeIds)) {
                    $productsQuery->whereIn('a.size_id', $sizeIds);
                } else {
                    $productsQuery->where('a.size_id', $sizeIds);
                }
            }
            
            // Apply availability filter
            if (!empty($availability)) {
                if (is_array($availability)) {
                    $productsQuery->whereIn('a.availability', $availability);
                } else {
                    $productsQuery->where('a.availability', $availability);
                }
            }
            
            // Execute query
            $products = $productsQuery->get()->getResult();
            
            // Handle AJAX request
            if ($isAjax) {
                $this->response->setContentType('application/json');
                
                return $this->response->setJSON([
                    'success' => true,
                    'products' => $products, // Send the raw product data
                    'count' => count($products)
                ]);
            }
            
            // Handle regular page request
            $data = [
                'page_title' => 'Products',
                'breadcrumb_items' => [
                    ['label' => 'Home', 'url' => base_url()],
                    ['label' => 'Products']
                ],
                'banner_image' => base_url('public/assets/img/banner/bg_4.png'),
                'products' => $products,
                'productTypes' => $productTypes ?? [],
                'productsize' => $productsize ?? []
            ];
            
            return view('products', $data);
        }



    public function wishlist()
    {
        $data = [
            'page_title' => 'Wishlist',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Wishlist']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('wishlist', $data);
    }
    public function myaccount()
    {
        return view('myaccount');
    }
    public function signup()
    {
        $data = [
            'page_title' => 'Sign-Up',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Sign-Up']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('signup', $data);
    }
    public function signin()
    {
        $data = [
            'page_title' => 'Sign-In',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Sign-In']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('signin', $data);
    }
    public function termsAndConditions()
    {
        $data = [
            'page_title' => 'Terms & Conditions',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Terms & Conditions']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('termsAndConditions', $data);
    }
    public function privacyPolicy()
    {
        $data = [
            'page_title' => 'Privacy Policy',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Privacy Policy']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('privacyPolicy', $data);
    }
    public function orderTracking()
    {
        $data = [
            'page_title' => 'Order Tracking',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Order Tracking']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

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
        $allMainMenus = $mainmenuModel->where('flag !=', 0)->findAll();
        $allSubMenus = $submenuModel->where('flag !=', 0)->findAll();
        $groupedSubmenus = [];
        foreach ($allSubMenus as $sub) {
            $groupedSubmenus[$sub['menu_id']][] = $sub;
        }

        $data = [
            'page_title' => $menuData['menu_name'],
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => $menuData['menu_name']]
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png'),
            'submenus' => $submenuData, 
            'mainmenu' => $allMainMenus,
            'submenu' => $groupedSubmenus 
        ];

        return view('productCategories', $data);
    }
}
