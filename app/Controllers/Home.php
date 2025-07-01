<?php

namespace App\Controllers;

use App\Models\admin\MainmenuModel;
use App\Models\admin\SubmenuModel;
use App\Models\admin\BannerModel;
use App\Models\ProductModel;


class Home extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $db = \Config\Database::connect();
        $data = $this->session->get();

        $mainmenu = $this->getMenuData();
        $bannerModel = new BannerModel();
        $bannerData = $bannerModel->where(['flag !=' => 0, 'has_banner' => 1])->findAll();
        $data = array_merge($this->getMenuData(), [
            'bannerData' => $bannerData
        ]);

        $data['bestSeller'] = $db->table('tbl_products')
            ->where('flag !=', 0)
            ->where('best_seller', 1)
            ->get()
            ->getResultArray();

        $data['featured_products'] = $db->table('tbl_featured_products')
            ->where('flag !=', 0)
            ->get()
            ->getResultArray();



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

        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $this->db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $cartCount = sizeof($usercount);

        } else {
            $cartCount = 0;
        }
        return [
            'mainmenu' => $mainmenus,
            'submenu' => $groupedSubmenus,
            'cart_count' => $cartCount
        ];
    }

    public function productDetails($prod_id)
    {
        $db = \Config\Database::connect();
        $decode_prod_id = base64_decode($prod_id);
        $query = $db->query("SELECT * FROM tbl_products WHERE prod_id = $decode_prod_id AND flag = 1");
        $product = $query->getRowArray();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product not found.");
        }

        $prodId = $product['prod_id'];
        $productShapeId = $product['shape_id'];
        $productSizeId = $product['size_id'];
        $productTypeId = $product['type_id'];

        // Variants
        $variantQuery = $db->table('tbl_variants')
            ->select('variant_id, pack_qty, mrp, offer_type, offer_details, offer_price, stock_status, quantity, weight')
            ->where(['flag' => 1, 'prod_id' => $prodId])
            ->get()->getResultArray();

        // Images
        $imageQuery = $db->table('tbl_images')
            ->select('image_path')
            ->where(['flag' => 1, 'prod_id' => $prodId])
            ->get()->getResultArray();

        $product['variants'] = $variantQuery;
        $product['product_images'] = array_column($imageQuery, 'image_path');

        $relatedProducts = $db->query("SELECT *,((shape_id = '$productShapeId') + (size_id = '$productSizeId') + (type_id = '$productTypeId')) AS relevance_score FROM tbl_products WHERE prod_id != $decode_prod_id AND flag = 1 AND (shape_id = '$productShapeId' OR size_id = '$productSizeId' OR type_id = '$productTypeId') ORDER BY relevance_score DESC ")->getResult();
        $product['relatedProducts'] = $relatedProducts;

        // Find lowest offer
        $lowestOffer = null;
        foreach ($variantQuery as $variant) {
            if ($lowestOffer === null || $variant['offer_price'] < $lowestOffer['offer_price']) {
                $lowestOffer = $variant;
            }
        }

        if ($lowestOffer) {
            $product['lowest_mrp'] = $lowestOffer['mrp'];
            $product['lowest_offer_price'] = $lowestOffer['offer_price'];
            $product['lowest_quantity'] = $lowestOffer['quantity'];
        } else {
            $product['lowest_mrp'] = null;
            $product['lowest_offer_price'] = null;
            $product['lowest_quantity'] = null;
        }
        $data = array_merge($this->getMenuData(), [
            'page_title' => 'Product View',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Product View']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png'),
            'product' => $product
        ]);

        return view('productsView', $data);
    }

    public function cart()
    {


        $res = array_merge($this->getMenuData(), [
            'page_title' => 'Your Shopping Cart',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Cart']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);


        $userID = session()->get('user_id');

        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $cartData = $this->db->query($query, [$userID])->getResultArray();
        if ($cartData > 0) {
            $res['cart_count'] = sizeof($cartData);

        } else {
            $res['cart_count'] = 0;
        }

        $productDetails = [];
        foreach ($cartData as $item) {
            $cartID = $item['cart_id'];

            $query = "SELECT
                a.`prod_id`,
                a.`prod_name`,
                a.`main_quantity`,
                a.`main_image`,
                a.`has_variant`,
                a.url,
                b.cart_id,
                b.quantity AS cart_quantity,
                b.prod_price AS cart_prod_price,
                b.total_price AS cart_total_price,
                b.pack_qty AS cart_pack_qty,
                b.user_id,
                c.variant_id,
                c.pack_qty,
                c.mrp,
                c.offer_price,
                c.quantity AS variant_qty,
                d.submenu ,d.gst
            FROM `tbl_products` AS a
            INNER JOIN tbl_user_cart AS b ON a.prod_id = b.prod_id
            INNER JOIN tbl_variants AS c ON c.prod_id = b.prod_id AND c.pack_qty = b.pack_qty
            INNER JOIN tbl_submenu AS d  ON d.sub_id = a.submenu_id 
            WHERE a.flag = 1 AND b.flag = 1 AND c.flag = 1 AND b.cart_id = ?";

            $result = $this->db->query($query, [$cartID])->getResultArray();
            if ($result) {
                $productDetails = array_merge($productDetails ?? [], $result);
            }
        }

        $res['cart_product'] = $productDetails;


        return view('cart', $res);
    }
    public function checkout()
    {
        $res = array_merge($this->getMenuData(), [
            'page_title' => 'Checkout',
            'breadcrumb_items' => [
                    ['label' => 'Home', 'url' => base_url()],
                    ['label' => 'Checkout']
                ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);


        $userID = session()->get('user_id');

        $res['state'] = $this->db->query("SELECT `state_id`,`state_title` FROM `tbl_state` WHERE `flag` =1")->getResultArray();


        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $cartData = $this->db->query($query, [$userID])->getResultArray();
        if ($cartData > 0) {
            $res['cart_count'] = sizeof($cartData);

        } else {
            $res['cart_count'] = 0;
        }

        $productDetails = [];
        foreach ($cartData as $item) {
            $cartID = $item['cart_id'];

            $query = "SELECT
                a.`prod_id`,
                a.`prod_name`,
                a.`main_quantity`,
                a.`main_image`,
                a.`has_variant`,
                a.url,
                b.cart_id,
                b.quantity AS cart_quantity,
                b.prod_price AS cart_prod_price,
                b.total_price AS cart_total_price,
                b.pack_qty AS cart_pack_qty,
                b.user_id,
                c.variant_id,
                c.pack_qty,
                c.mrp,
                c.offer_price,
                c.quantity AS variant_qty,
                d.submenu ,d.gst
            FROM `tbl_products` AS a
            INNER JOIN tbl_user_cart AS b ON a.prod_id = b.prod_id
            INNER JOIN tbl_variants AS c ON c.prod_id = b.prod_id AND c.pack_qty = b.pack_qty
            INNER JOIN tbl_submenu AS d  ON d.sub_id = a.submenu_id 
            WHERE a.flag = 1 AND b.flag = 1 AND c.flag = 1 AND b.cart_id = ?";

            $result = $this->db->query($query, [$cartID])->getResultArray();
            if ($result) {
                $productDetails = array_merge($productDetails ?? [], $result);
            }
        }

        $res['checkout_product'] = $productDetails;

        $totalAmt = 0;
        $totalGstValue = 0;
        $deliveryCharge = 100;

        // Loop through each product
        foreach ($res['checkout_product'] as $i => $item) {
            $productPrice = (float) str_replace(',', '', $item['offer_price']);
            $cartQuantity = (int) $item['cart_quantity'];
            $mainQuantity = (int) $item['variant_qty'];
            $gstPercent = (float) $item['gst'];

            $priceCalculation = 0;
            $gstValue = 0;

            if ($cartQuantity <= $mainQuantity) {
                $priceCalculation = $productPrice * $cartQuantity;
                $res['checkout_product'][$i]['final_prod_price'] = round($priceCalculation, 2);

                // GST per item (inclusive)

                if ($gstPercent > 0) {
                    $gstValue = ($priceCalculation * $gstPercent) / (100 + $gstPercent);

                    $paise = round(fmod($gstValue, 1) * 100, 2);

                    $gstValue = $paise < 50 ? floor($gstValue) : ceil($gstValue);
                }
                // Accumulate totals per item
                $totalAmt += $priceCalculation;
                $totalGstValue += $gstValue;
            }
        }




        // Final calculations
        $totalAmt = round($totalAmt, 2);
        $totalGstValue = round($totalGstValue, 2);
        $subTotal = $totalAmt - $totalGstValue;
        $finalTotal = $totalAmt + $deliveryCharge;
        $halfGst = floor(($totalGstValue / 2) * 100) / 100;

        // Send to view
        $res['total_amt'] = $totalAmt;
        $res['total_gst'] = $totalGstValue;
        $res['cgst'] = $halfGst;
        $res['sgst'] = $halfGst;
        $res['subtotal'] = $subTotal;
        $res['delivery_charge'] = $deliveryCharge;
        $res['final_total'] = $finalTotal;

        $res['type'] = $this->request->getGet("type");
        $userID = session()->get("user_id");

        // Addres Details
        $userVerify = session()->get("otp_verify");
        $loginStatus = session()->get("loginStatus");

        if ($userVerify == "YES" && $loginStatus == "YES") {
            $query = "SELECT a.*, b.state_title, c.dist_name  , d.`user_id`,d.`username`,d.`number`,d.`email`
            FROM tbl_user_address AS a 
            INNER JOIN tbl_state AS b ON a.state_id = b.state_id
            INNER JOIN tbl_district AS c ON a.dist_id = c.dist_id
            INNER JOIN tbl_users AS d ON d.user_id = a.user_id
            WHERE a.user_id = $userID  AND a.flag = 1;";
            $res['address'] = $this->db->query($query, [$userID])->getResultArray();

            // User Details
            $userqry = "SELECT * FROM `tbl_users` WHERE `flag` = 1 AND `user_id` = ?  AND `is_verified` = 1";
            $res['user_details'] = $this->db->query($userqry, [$userID])->getResultArray();

        }
        return view('checkout', $res);
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




    public function products($encodedSubmenu = null, $encodedSubmenuId = null)
    {
        $db = \Config\Database::connect();
        $menuData = $this->getMenuData();

        // Decode submenu ID from URL 
        $submenuId = null;
        if ($encodedSubmenuId) {
            $submenuId = base64_decode($encodedSubmenuId);
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
            ->select(' a.*,b.size_name,c.type_name,d.shape_name')
            ->join('tbl_filter_size b', 'a.size_id = b.size_id', 'left')
            ->join('tbl_filter_type c', 'a.type_id = c.type_id', 'left')
            ->join('tbl_filter_shapes d', 'a.shape_id = d.shape_id', 'left')
            ->where([
                    'a.flag' => 1,
                    'b.status' => 1,
                    'b.flag' => 1,
                    'c.type_status' => 1,
                    'c.flag' => 1
                ])->orderBy('a.prod_id', 'ASC');




        // Apply submenu ID filter
        if ($submenuId) {
            $productsQuery->where('a.submenu_id', $submenuId);
        }


        // Apply other filters
        if (!empty($typeIds)) {

            $productsQuery->whereIn('a.type_id', (array) $typeIds);
        }

        if (!empty($sizeIds)) {
            $productsQuery->whereIn('a.size_id', (array) $sizeIds);
        }

        if (!empty($shapeIds)) {
            $productsQuery->whereIn('a.shape_id', (array) $shapeIds);
        }

        // Fetch product data
        $rawProducts = $productsQuery->get()->getResultArray();

        $products = [];

        foreach ($rawProducts as $product) {
            $prodId = $product['prod_id'];

            // Fetch variants
            $variantQuery = $db->table('tbl_variants')
                ->select('variant_id, pack_qty, mrp, offer_type, offer_details, offer_price, stock_status, quantity, weight')
                ->where(['flag' => 1, 'prod_id' => $prodId])
                ->get()->getResultArray();

            // Fetch product images
            $imageQuery = $db->table('tbl_images')
                ->select('image_path')
                ->where(['flag' => 1, 'prod_id' => $prodId])
                ->get()->getResultArray();

            $product['variants'] = $variantQuery;
            $product['product_images'] = array_column($imageQuery, 'image_path');


            $lowestOffer = null;
            foreach ($variantQuery as $variant) {
                if ($lowestOffer === null || $variant['offer_price'] < $lowestOffer['offer_price']) {
                    $lowestOffer = $variant;
                }
            }

            if ($lowestOffer) {
                $product['lowest_mrp'] = $lowestOffer['mrp'];
                $product['lowest_offer_price'] = $lowestOffer['offer_price'];
                $product['lowest_quantity'] = $lowestOffer['quantity'];
            } else {
                $product['lowest_mrp'] = null;
                $product['lowest_offer_price'] = null;
                $product['lowest_quantity'] = null;
            }


            $products[] = $product;
        }


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

        $res['menuData'] = $this->getMenuData();

        $res = array_merge($res['menuData'], [

            'page_title' => 'Wishlist',
            'breadcrumb_items' => [
                    ['label' => 'Home', 'url' => base_url()],
                    ['label' => 'Wishlist']
                ],

        ]);

        $userID = $this->session->get("user_id");


        $res['userData'] = $this->db->query("SELECT * FROM `tbl_users` WHERE `flag` = 1 AND `user_id` = $userID")->getResultArray();
        $res['state'] = $this->db->query("SELECT `state_id`,`state_title` FROM `tbl_state` WHERE `flag` =1")->getResultArray();

        $query = "SELECT a.*, b.state_title, c.dist_name 
        FROM tbl_user_address AS a 
        INNER JOIN tbl_state AS b ON a.state_id = b.state_id
        INNER JOIN tbl_district AS c ON a.dist_id = c.dist_id
        WHERE a.user_id = $userID  AND a.flag = 1;";
        $res['address'] = $this->db->query($query, [$userID])->getResultArray();


        return view('myaccount', $res);
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

        $data = $this->session->get();


        $menuData = $this->getMenuData();
        $data = array_merge($menuData, [
            'page_title' => 'Login / Signup',
            'breadcrumb_items' => [
                    ['label' => 'Home', 'url' => base_url()],
                    ['label' => 'Login / Signup']
                ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);
        $this->session->set('callback_url', previous_url());

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