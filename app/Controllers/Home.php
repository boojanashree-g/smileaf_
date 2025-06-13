<?php

namespace App\Controllers;

<<<<<<< HEAD
use App\Models\admin\MainmenuModel;
use App\Models\admin\SubmenuModel;


=======
>>>>>>> 6692b5b (Feat : UI & Admin)
class Home extends BaseController
{
    public function index()
    {
<<<<<<< HEAD
        $mainmenumodel = new MainmenuModel();
        $submenumodel = new SubmenuModel();

        $mainmenus = $mainmenumodel->where('flag !=', 0)->findAll();
        $submenus = $submenumodel->where('flag !=', 0)->findAll();

        // Group submenus by menu_id
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
=======
        return view('index');
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
>>>>>>> 6692b5b (Feat : UI & Admin)
    }
    public function cart()
    {
        $data = [
<<<<<<< HEAD
            'page_title' => 'cart',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'cart']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
=======
        'page_title' => 'cart',
        'breadcrumb_items' => [
            ['label' => 'Home', 'url' => base_url()],
            ['label' => 'cart']
        ],
        'banner_image' => base_url('public/assets/img/banner/bg_4.png')
>>>>>>> 6692b5b (Feat : UI & Admin)
        ];

        return view('cart', $data);
    }
    public function checkout()
    {
        $data = [
<<<<<<< HEAD
            'page_title' => 'checkout',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'checkout']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
=======
        'page_title' => 'checkout',
        'breadcrumb_items' => [
            ['label' => 'Home', 'url' => base_url()],
            ['label' => 'checkout']
        ],
        'banner_image' => base_url('public/assets/img/banner/bg_4.png')
>>>>>>> 6692b5b (Feat : UI & Admin)
        ];

        return view('checkout', $data);
    }
    public function contact()
    {
        $data = [
<<<<<<< HEAD
            'page_title' => 'contact',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'contact']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
=======
        'page_title' => 'contact',
        'breadcrumb_items' => [
            ['label' => 'Home', 'url' => base_url()],
            ['label' => 'contact']
        ],
        'banner_image' => base_url('public/assets/img/banner/bg_4.png')
>>>>>>> 6692b5b (Feat : UI & Admin)
        ];

        return view('contact', $data);
    }
    public function products()
    {
        $data = [
<<<<<<< HEAD
            'page_title' => 'Products',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Products']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
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
=======
        'page_title' => 'Products',
        'breadcrumb_items' => [
            ['label' => 'Home', 'url' => base_url()],
            ['label' => 'Products']
        ],
        'banner_image' => base_url('public/assets/img/banner/bg_4.png')
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
>>>>>>> 6692b5b (Feat : UI & Admin)
    }
    public function myaccount()
    {
        return view('myaccount');
    }
    public function signup()
    {
        $data = [
<<<<<<< HEAD
            'page_title' => 'Sign-Up',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Sign-Up']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('signup', $data);
=======
        'page_title' => 'Sign-Up',
        'breadcrumb_items' => [
            ['label' => 'Home', 'url' => base_url()],
            ['label' => 'Sign-Up']
        ],
        'banner_image' => base_url('public/assets/img/banner/bg_4.png')
    ];

    return view('signup', $data);
>>>>>>> 6692b5b (Feat : UI & Admin)
    }
    public function signin()
    {
        $data = [
<<<<<<< HEAD
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
=======
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
>>>>>>> 6692b5b (Feat : UI & Admin)
    }
    public function privacyPolicy()
    {
        $data = [
<<<<<<< HEAD
            'page_title' => 'Privacy Policy',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Privacy Policy']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('privacyPolicy', $data);
=======
        'page_title' => 'Privacy Policy',
        'breadcrumb_items' => [
            ['label' => 'Home', 'url' => base_url()],
            ['label' => 'Privacy Policy']
        ],
        'banner_image' => base_url('public/assets/img/banner/bg_4.png')
    ];

    return view('privacyPolicy', $data);
>>>>>>> 6692b5b (Feat : UI & Admin)
    }
    public function orderTracking()
    {
        $data = [
<<<<<<< HEAD
            'page_title' => 'Order Tracking',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Order Tracking']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('orderTracking', $data);
=======
        'page_title' => 'Order Tracking',
        'breadcrumb_items' => [
            ['label' => 'Home', 'url' => base_url()],
            ['label' => 'Order Tracking']
        ],
        'banner_image' => base_url('public/assets/img/banner/bg_4.png')
    ];

    return view('orderTracking', $data);
>>>>>>> 6692b5b (Feat : UI & Admin)
    }
    public function productCategories()
    {
        $data = [
<<<<<<< HEAD
            'page_title' => 'Product Categories',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Product Categories']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ];

        return view('productCategories', $data);
    }

}
=======
        'page_title' => 'Product Categories',
        'breadcrumb_items' => [
            ['label' => 'Home', 'url' => base_url()],
            ['label' => 'Product Categories']
        ],
        'banner_image' => base_url('public/assets/img/banner/bg_4.png')
    ];

    return view('productCategories', $data);
    }

}
>>>>>>> 6692b5b (Feat : UI & Admin)
