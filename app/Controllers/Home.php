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

        $data['featured_products'] = $db->table('tbl_featured_products a')
            ->select(' a.*,b.slug')
            ->join('tbl_submenu b', 'a.sub_id = b.sub_id', 'left')
            ->where('a.flag !=', 0)
            ->where('b.flag !=', 0)
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
        $sourceType = 'cart';
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1 AND source_type = ?";
        $usercount = $this->db->query($query, [$userID, $sourceType])->getResultArray();
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

    public function productDetails()
    {
        $encodedID = $this->request->uri->getSegment(2);
        $prod_id = base64_decode($encodedID);

        $prodQry = "SELECT * FROM `tbl_products` WHERE flag = 1 AND `prod_id` = ?";
        $prodData = $this->db->query($prodQry, [$prod_id])->getResultArray();

        $variantQry = "SELECT * FROM `tbl_variants` WHERE `prod_id` = ? AND flag = 1";
        $variantData = $this->db->query($variantQry, [$prod_id])->getResultArray();


        // Related Products
        $shapeID = $prodData[0]['shape_id'];
        $typeID = $prodData[0]['type_id'];
        $sizeID = $prodData[0]['size_id'];

        $relatedProd = $this->relatedProducts($shapeID, $typeID, $sizeID, $prod_id);

        $lowestOffer = null;
        foreach ($variantData as $variant) {
            if ($lowestOffer === null || $variant['offer_price'] < $lowestOffer['offer_price']) {
                $lowestOffer = $variant;
            }
        }

        $imageQuery = "SELECT * FROM `tbl_images` WHERE `prod_id` = ? AND `flag` = 1";
        $imageData = $this->db->query($imageQuery, [$prod_id])->getResultArray();


        $res = [
            'code' => 200,
            'status' => 'success',
            'products' => $prodData,
            'variant_data' => [ // group properly
                'list' => $variantData, // the pure DB result
                'lowest_mrp' => $lowestOffer['mrp'] ?? null,
                'lowest_offer_price' => $lowestOffer['offer_price'] ?? null,
                'lowest_quantity' => $lowestQty ?? 0,
            ],
            'image_data' => $imageData,
            'related_products' => $relatedProd
        ];


        $res = array_merge($res, $this->getMenuData(), [
            'page_title' => 'Product View',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Product View']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png')
        ]);

        return view('productsView', $res);
    }

    private function relatedProducts($shapeID, $typeID, $sizeID, $prod_id)
    {
        $query = "SELECT * FROM `tbl_products` WHERE `type_id` = ? AND `shape_id` = ? AND `size_id`  = ? AND `prod_id` != ?  AND `flag` = 1";
        $rawProducts = $this->db->query($query, [$typeID, $shapeID, $sizeID, $prod_id])->getResultArray();


        $products = [];
        foreach ($rawProducts as $product) {
            $prodId = $product['prod_id'];

            // Fetch variants
            $variantQuery = $this->db->query("SELECT variant_id, pack_qty, mrp, offer_type, offer_details, offer_price, stock_status, quantity,weight
              FROM `tbl_variants` WHERE `flag` = 1 AND `prod_id` = ?", [$prodId])->getResultArray();
            // Fetch product images
            $imageQuery = $this->db->query("SELECT `image_path` FROM `tbl_images` WHERE `flag` = 1 AND `prod_id` = ?", [$prodId])->getResultArray();

            $product['variants'] = $variantQuery;
            $product['product_images'] = array_column($imageQuery, 'image_path');


            $totalVariant = count($variantQuery);

            $lowestOffer = null;
            $stockCount = 0;
            foreach ($variantQuery as $variant) {
                if ($lowestOffer === null || $variant['offer_price'] < $lowestOffer['offer_price']) {
                    $lowestOffer = $variant;
                }
                if ($variant['stock_status'] <= 0 && $variant['quantity'] <= 0) {
                    $stockCount += 1;
                }
            }

            $stockStatus = $stockCount < $totalVariant ? 1 : 0;

            if ($lowestOffer) {
                $product['lowest_mrp'] = $lowestOffer['mrp'];
                $product['lowest_offer_price'] = $lowestOffer['offer_price'];
                $product['lowest_quantity'] = $lowestOffer['quantity'];
                $product['available_status'] = $stockStatus;

            } else {
                $product['lowest_mrp'] = null;
                $product['lowest_offer_price'] = null;
                $product['lowest_quantity'] = null;
                $product['available_status'] = $stockStatus;

            }

            $products[] = $product;
        }

        return $products;

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
        $sourceType = 'cart';
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1 AND source_type = ?";
        $cartData = $this->db->query($query, [$userID, $sourceType])->getResultArray();
        if ($cartData > 0) {
            $res['cart_count'] = sizeof($cartData);

        } else {
            $res['cart_count'] = 0;
        }

        $productDetails = [];
        $sourceType = 'cart';
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
            WHERE a.flag = 1 AND b.flag = 1 AND c.flag = 1 AND b.cart_id = ? AND b.source_type = ?";

            $result = $this->db->query($query, [$cartID, $sourceType])->getResultArray();
            if ($result) {
                $productDetails = array_merge($productDetails ?? [], $result);
            }
        }

        $res['cart_product'] = $productDetails;


        return view('cart', $res);
    }


    private function calculateGstInclusive($price, $gstPercent)
    {
        $gstValue = ($price * $gstPercent) / (100 + $gstPercent);
        $paise = round(fmod($gstValue, 1) * 100, 2);
        return $paise < 50 ? floor($gstValue) : ceil($gstValue);
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
                // 'b.status' => 1,
                // 'b.flag' => 1,
                // 'c.type_status' => 1,
                // 'c.flag' => 1
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


            $totalVariant = count($variantQuery);

            $lowestOffer = null;
            $stockCount = 0;
            foreach ($variantQuery as $variant) {
                if ($lowestOffer === null || $variant['offer_price'] < $lowestOffer['offer_price']) {
                    $lowestOffer = $variant;
                }
                if ($variant['stock_status'] <= 0 && $variant['quantity'] <= 0) {
                    $stockCount += 1;
                }
            }

            $stockStatus = $stockCount < $totalVariant ? 1 : 0;

            if ($lowestOffer) {
                $product['lowest_mrp'] = $lowestOffer['mrp'];
                $product['lowest_offer_price'] = $lowestOffer['offer_price'];
                $product['lowest_quantity'] = $lowestOffer['quantity'];
                $product['available_status'] = $stockStatus;

            } else {
                $product['lowest_mrp'] = null;
                $product['lowest_offer_price'] = null;
                $product['lowest_quantity'] = null;
                $product['available_status'] = $stockStatus;

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

        // Get Order Summary
        $Orderquery = "SELECT * FROM `tbl_orders` WHERE `user_id` = ? AND `flag` = 1 AND  order_status <> 'initiated'";
        $orderDetails = $this->db->query($Orderquery, [$userID])->getResultArray();


        $orderSummaries = [];
        foreach ($orderDetails as $orders) {
            $orderID = $orders['order_id'];
            $courierCharge = $orders['courier_charge'];
            $orderSubTotal = $orders['sub_total'];
            $OrderTotalAmt = $orders['total_amt'];
            $orderDate = date('d-m-Y', strtotime($orders['order_date']));
            $deliveryTime = $orders['updated_at'];

            $query = "SELECT * FROM `tbl_order_item` WHERE `flag` = 1 AND `order_id` = ?";
            $itemDetails = $this->db->query($query, [$orderID])->getResultArray();

            $orderSummaries[$orderID] = [
                'order_id' => $orderID,
                'order_no' => $orders['order_no'],
                'bill_no' => $orders['bill_no'],
                'bill_date' => $orders['bill_date'],
                'order_status' => $orders['order_status'],
                'order_date' => $orderDate,
                'payment_status' => $orders['payment_status'],
                'payment_cancel_reason' => $orders['payment_cancel_reason'],
                'delivery_status' => $orders['delivery_status'],
                'delivery_message' => $orders['delivery_message'],
                'courier_charge' => $courierCharge,
                'order_sub_total' => $orderSubTotal,
                'order_total_amt' => $OrderTotalAmt,
                'delivered_time' => $deliveryTime,

                'items' => []
            ];

            foreach ($itemDetails as $item) {
                $prodID = $item['prod_id'];
                $variantID = $item['variant_id'];
                $quantity = $item['quantity'];
                $prod_price = $item['prod_price'];
                $sub_total = $item['sub_total'];

                $packQtyQuery = "SELECT
                            a.`pack_qty`,
                            b.prod_name,
                            b.main_image
                        FROM
                            `tbl_variants` AS a
                        INNER JOIN tbl_products AS b
                            ON a.prod_id = b.prod_id
                        WHERE
                            b.`flag` = 1 AND a.flag = 1 AND a.variant_id = ? AND a.prod_id = ?";
                $packData = $this->db->query($packQtyQuery, [$variantID, $prodID])->getRow();

                if ($packData) {
                    $productDetails = [
                        'prod_name' => $packData->prod_name,
                        'main_image' => $packData->main_image,
                        'pack_qty' => $packData->pack_qty,
                        'quantity' => $quantity,
                        'prod_price' => $prod_price,
                        'sub_total' => $sub_total,
                    ];
                    $orderSummaries[$orderID]['items'][] = $productDetails;
                }
            }
        }

        krsort($orderSummaries);
        $res['summary'] = $orderSummaries;

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
        $orderID = base64_decode($this->request->getGet('order_id'));


        $menuData = $this->getMenuData();
        $data = array_merge($menuData, [
            'page_title' => 'Order Tracking',
            'breadcrumb_items' => [
                ['label' => 'Home', 'url' => base_url()],
                ['label' => 'Order Tracking']
            ],
            'banner_image' => base_url('public/assets/img/banner/bg_4.png'),
            'order_id' => $orderID
        ]);

        return view('orderTracking', $data);
    }

    public function getOrderStatus()
    {
        $userID = session()->get('user_id');
        $orderNo = $this->request->getPost('order_no');
        $orderID = $this->request->getPost('main_orderid');

        $orderQuery = "SELECT 
                        DATE_FORMAT(`order_date`, '%d-%m-%Y %r') AS `order_date`,
                        DATE_FORMAT(`shipped_date`, '%d-%m-%Y %r') AS `shipped_date`,
                        DATE_FORMAT(`delivery_date`, '%d-%m-%Y %r') AS `delivery_date`,
                        `order_status`
                        FROM `tbl_orders`
                        WHERE `flag` = 1 AND `order_id` = ? AND `order_no` = ? AND `user_id` = ?
                        ";
        $orderDetails = $this->db->query($orderQuery, [$orderID, $orderNo, $userID])->getRowArray();


        $res = [
            'code' => 200,
            'orderdetails' => $orderDetails
        ];
        echo json_encode($res);
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