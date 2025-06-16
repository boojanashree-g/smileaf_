<?php

namespace App\Controllers;

use App\Models\admin\MainmenuModel;
use App\Models\admin\SubmenuModel;
use App\Models\ProductModel;


class Home extends BaseController
{
    public function index()
    {
        $mainmenumodel = new MainmenuModel();
        $submenumodel = new SubmenuModel();
        $mainmenus = $mainmenumodel->where('flag !=', 0)->findAll();
        $submenus = $submenumodel->where('flag !=', 0)->findAll();
        $groupedSubmenus = [];
        foreach ($submenus as $submenu) {
            $groupedSubmenus[$submenu['menu_id']][] = $submenu;
        }
        $data['mainmenu'] = $mainmenus;
        $data['submenu'] = $groupedSubmenus;
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
        $productModel = new ProductModel();
        $allProducts = $productModel->where('flag !=', 0, false)->findAll();
        $data = [
            'page_title' => 'Products',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Products']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png'),
            'products' => $allProducts
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
        $MainmenuModel = new MainmenuModel();
        $submenuModel = new SubmenuModel();

        // Get main menu based on slug
        $menuData = $MainmenuModel->where('slug', $slug)->first();

        if (!$menuData) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Main menu not found");
        }

        $menuId = $menuData['menu_id'];

        // Get all submenus under this menu
        $submenuData = $submenuModel->where('menu_id', $menuId)->findAll();

        $data = [
            'page_title' => $menuData['menu_name'],
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => $menuData['menu_name']]
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png'),
            'submenus' => $submenuData
        ];
        // echo"<pre>";
        // print_r($data);
        // exit();
        return view('productCategories', $data);
    }


}
