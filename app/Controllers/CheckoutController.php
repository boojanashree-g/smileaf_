<?php

namespace App\Controllers;

use App\Models\OrderModal;
use App\Models\OrderItemModal;

use App\Models\admin\MainmenuModel;
use App\Models\admin\SubmenuModel;

class CheckoutController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }


    public function placeOrder()
    {
        $OrderModal = new OrderModal();
        $OrderItemModal = new OrderItemModal();

        $userID = session()->get("user_id");
        $type = $this->request->getPost("type");
        $subid = $this->request->getPost("subid");


        //Order No
        $orderTotal = "SELECT COUNT(`order_id`) AS total_count  FROM `tbl_orders`";
        $orderTotalData = $this->db->query($orderTotal)->getRow();

        $currentYear = date('Y');

        if ($orderTotalData > 0) {
            $orderTotal = $orderTotalData->total_count;

            $finalOrdernumber = $orderTotal + 1;
            $orderNumberLength = strlen((string) $finalOrdernumber);


            if ($finalOrdernumber < 10000) {
                $orderNO = "SML" . $currentYear . str_pad($finalOrdernumber, 4, '0', STR_PAD_LEFT);
            } else {
                $orderNO = "SML" . $currentYear . $finalOrdernumber;
            }
        } else {
            $orderNO = "SML" . $currentYear . "0001";

        }
        // end Order No


        if ($type == "cart") {
            $cartQuery = "SELECT * FROM `tbl_user_cart` WHERE `user_id` = ? AND `flag` =1 AND source_type = ?";
            $cartData = $this->db->query($cartQuery, [$userID, $type])->getResultArray();
        } else if ($type == "buy_now") {
            $cartQuery = "SELECT * FROM `tbl_user_cart` WHERE `user_id` = ? AND `flag` =1 AND source_type = ?";
            $cartData = $this->db->query($cartQuery, [$userID, $type])->getResultArray();
        }

        if (empty($cartData)) {
            return json_encode(['code' => 400, 'status' => false, 'message' => 'No products have been selected!!.']);
        }

        //if 0
        $price_count = 0;
        $OrderPrice = 0;
        $prodPrice = 0;
        $totalGSTvalue = 0;

        if ($type == "cart") {
            foreach ($cartData as $i => $item) {
                $prodID = $item['prod_id'];
                $cartQuantity = $item['quantity'];
                $cartPackqty = $item['pack_qty'];
                $cartPrice = $item['prod_price'];
                $cartTotal = $item['total_price'];
                $originalPrice = $cartPrice;

                $subIDs = isset($subid[$i]) ? $subid[$i] : [];

                // Main Product
                $mainProductQuery = "SELECT main_quantity, has_variant, submenu_id FROM tbl_products WHERE `prod_id` = ?";
                $mainProductData = $this->db->query($mainProductQuery, [$prodID])->getRow();

                if (!$mainProductData) {
                    return json_encode(['code' => 400, 'status' => false, 'message' => 'Invalid product in cart.']);
                }

                $mainVariantQuery = "SELECT * FROM `tbl_variants` WHERE `prod_id` = ? AND pack_qty = ? AND `flag` = 1";
                $mainVariantData = $this->db->query($mainVariantQuery, [$prodID, $cartPackqty])->getRow();

                if (!$mainVariantData) {
                    return json_encode(['code' => 400, 'status' => false, 'message' => 'Invalid Product Variants in cart.']);
                }

                $mainQuantity = $mainVariantData->quantity;
                $mainPrice = $mainVariantData->offer_price;
                $productSubID = $mainVariantData->submenu_id;

                $finalPrice = ($cartPrice == $mainPrice) ? $cartPrice : $mainPrice;

                if ($cartQuantity <= $mainQuantity && $cartPrice == $mainPrice && $cartPrice != 0 && $originalPrice != 0) {
                    $OrderPrice += $cartTotal;
                    $prodPrice = $cartTotal;
                } elseif (($mainPrice == 0 && $cartPrice == 0) || $mainPrice == 0) {
                    $price_count += 1;
                    $OrderPrice += $mainPrice * $cartQuantity;
                    $prodPrice = $mainPrice * $cartQuantity;
                } else {
                    $OrderPrice += $mainPrice * $cartQuantity;
                    $prodPrice = $mainPrice * $cartQuantity;
                }

                // Handle array of subIDs
                if (is_array($subIDs)) {
                    foreach ($subIDs as $subID) {
                        if ($subID != $productSubID) {
                            $query = "SELECT `gst` FROM `tbl_submenu` WHERE `flag` = 1 AND `sub_id` = ?";
                            $GSTData = $this->db->query($query, [$subID])->getRow();

                            if ($GSTData && $GSTData->gst > 0) {
                                $gstPercent = $GSTData->gst;
                                $gstValue = $this->calculateGstInclusive($prodPrice, $gstPercent);
                                $totalGSTvalue += $gstValue;
                            }
                        }
                    }
                } else {
                    // Single subID fallback
                    if ($subIDs != $productSubID) {

                        $query = "SELECT `gst` FROM `tbl_submenu` WHERE `flag` = 1 AND `sub_id` = ?";
                        $GSTData = $this->db->query($query, [$subIDs])->getRow();

                        if ($GSTData && $GSTData->gst > 0) {
                            $gstPercent = $GSTData->gst;
                            $gstValue = $this->calculateGstInclusive($prodPrice, $gstPercent);
                            $totalGSTvalue += $gstValue;
                        }
                    }
                }
            }
        } else if ($type == "buy_now") {
            $prodID = $cartData[0]['prod_id'];
            $cartQuantity = $cartData[0]['quantity'];
            $cartPackqty = $cartData[0]['pack_qty'];
            $cartPrice = $cartData[0]['prod_price'];
            $cartTotal = $cartData[0]['total_price'];
            $originalPrice = $cartPrice;

            $subIDs = isset($subid[0]) ? $subid[0] : [];


            // Main Product
            $mainProductQuery = "SELECT main_quantity, has_variant, submenu_id FROM tbl_products WHERE `prod_id` = ?";
            $mainProductData = $this->db->query($mainProductQuery, [$prodID])->getRow();



            if (!$mainProductData) {
                return json_encode(['code' => 400, 'status' => false, 'message' => 'Invalid product in cart.']);
            }

            $mainVariantQuery = "SELECT * FROM `tbl_variants` WHERE `prod_id` = ? AND pack_qty = ? AND `flag` = 1";
            $mainVariantData = $this->db->query($mainVariantQuery, [$prodID, $cartPackqty])->getRow();

            if (!$mainVariantData) {
                return json_encode(['code' => 400, 'status' => false, 'message' => 'Invalid Product Variants in cart.']);
            }

            $mainQuantity = $mainVariantData->quantity;
            $mainPrice = $mainVariantData->offer_price;
            $productSubID = $mainVariantData->submenu_id;

            $finalPrice = ($cartPrice == $mainPrice) ? $cartPrice : $mainPrice;



            if ($cartQuantity <= $mainQuantity && $cartPrice == $mainPrice && $cartPrice != 0 && $originalPrice != 0) {
                $OrderPrice += $cartTotal;
                $prodPrice = $cartTotal;
            } elseif (($mainPrice == 0 && $cartPrice == 0) || $mainPrice == 0) {
                $price_count += 1;
                $OrderPrice += $mainPrice * $cartQuantity;
                $prodPrice = $mainPrice * $cartQuantity;
            } else {
                $OrderPrice += $mainPrice * $cartQuantity;
                $prodPrice = $mainPrice * $cartQuantity;
            }



            // Handle array of subIDs
            if (is_array($subIDs)) {
                foreach ($subIDs as $subID) {
                    if ($subID != $productSubID) {
                        $query = "SELECT `gst` FROM `tbl_submenu` WHERE `flag` = 1 AND `sub_id` = ?";
                        $GSTData = $this->db->query($query, [$subID])->getRow();

                        if ($GSTData && $GSTData->gst > 0) {
                            $gstPercent = $GSTData->gst;
                            $gstValue = $this->calculateGstInclusive($prodPrice, $gstPercent);
                            $totalGSTvalue += $gstValue;
                        }
                    }
                }
            } else {
                // Single subID fallback
                if ($subIDs != $productSubID) {

                    $query = "SELECT `gst` FROM `tbl_submenu` WHERE `flag` = 1 AND `sub_id` = ?";
                    $GSTData = $this->db->query($query, [$subIDs])->getRow();

                    if ($GSTData && $GSTData->gst > 0) {
                        $gstPercent = $GSTData->gst;
                        $gstValue = $this->calculateGstInclusive($prodPrice, $gstPercent);
                        $totalGSTvalue += $gstValue;
                    }
                }
            }
        }


        $totalGstValue = round($totalGSTvalue, 2);
        $halfGst = floor(($totalGstValue / 2) * 100) / 100;


        // Shipping 100rs 
        $totalShipping = 100;
        $courierType = "Default";

        $finalOrderPrice = $OrderPrice + $totalShipping;
        $finalSubTotal = $finalOrderPrice - $totalShipping;



        // Fetch default address for the user
        $addressQuery = "SELECT `add_id` 
                 FROM `tbl_user_address` 
                 WHERE `user_id` = ? AND `flag` = 1 AND `default_addr` = 1";
        $addressData = $this->db->query($addressQuery, [$userID])->getRow();

        if (!$addressData) {
            return json_encode(['status' => false, 'message' => 'Default address not found!']);
        }

        $addID = $addressData->add_id;


        if ($price_count > 0) {
            $res['code'] = 400;
            $res['message'] = "Invalid Product Price";

            echo json_encode($res);
        } else {
            $orderData = [
                'order_no' => $orderNO,
                'user_id' => $userID,
                'total_amt' => $finalOrderPrice,
                'sub_total' => $finalSubTotal,
                'add_id' => $addID,
                'order_status' => "initiated",
                'order_date' => date('Y-m-d H:i:s'),
                'courier_charge' => $totalShipping,
                'courier_type' => $courierType,
                'gst' => $totalGstValue,
                'cgst' => $halfGst,
                'sgst' => $halfGst,

            ];


            $insertOrder = $OrderModal->insert($orderData);

            $OrderID = $this->db->insertID();
            $paymetRedirectCheck = 'ORD_' . time() . bin2hex(random_bytes(3));
            $sess = [
                'order_id' => $OrderID,
                'current_order_id' => $paymetRedirectCheck
            ];
            $this->session->set($sess);

            $affectedRows = $this->db->affectedRows();

            // Data storing in Order items
            if ($affectedRows == 1) {
                $inner_affectedRows = 0;
                if ($type == "cart") {
                    foreach ($cartData as $item) {
                        $prodID = $item['prod_id'];
                        $cartQuantity = $item['quantity'];
                        $cartPackqty = $item['pack_qty'];
                        $cartPrice = $item['prod_price'];
                        $cartTotal = $item['total_price'];

                        // Main Product
                        $mainProductQuery = "SELECT main_quantity , has_variant  FROM tbl_products WHERE `prod_id` = ?";
                        $mainProductData = $this->db->query($mainProductQuery, [$prodID])->getRow();

                        $mainVariantQuery = "SELECT * FROM `tbl_variants` WHERE `prod_id` = ? AND  pack_qty = ? AND `flag` = 1";
                        $mainVariantData = $this->db->query($mainVariantQuery, [$prodID, $cartPackqty])->getRow();

                        $mainQuantity = $mainVariantData->quantity;
                        $mainPackQty = $mainVariantData->pack_qty;
                        $mainPrice = $mainVariantData->offer_price;
                        $variantID = $mainVariantData->variant_id;
                        $variantMRP = $mainVariantData->mrp;
                        $offerType = $mainVariantData->offer_type;
                        $offerDetails = $mainVariantData->offer_details;


                        $finalPrice = ($cartPrice == $mainPrice) ? $cartPrice : $mainPrice;


                        if ($cartQuantity <= $mainQuantity && $cartPrice == $mainPrice && $cartPrice != 0 && $originalPrice != 0) {
                            $OrderPrice = $cartTotal;

                        } else if ($mainPrice == 0 && $cartPrice == 0 || $mainPrice == 0) {
                            $OrderPrice = $mainPrice * $cartQuantity;
                        } else {
                            $OrderPrice = $mainPrice * $cartQuantity;
                        }


                        $itemData = [
                            'order_id' => $OrderID,
                            'prod_id' => $prodID,
                            'variant_id' => $variantID,
                            'quantity' => $cartQuantity,
                            'prod_price' => $finalPrice,
                            'sub_total' => $OrderPrice,
                            'mrp' => $variantMRP,
                            'offer_price' => $mainPrice,
                            'offer_type' => $offerType,
                            'offer_details' => $offerDetails,
                        ];

                        $insertItem = $OrderItemModal->insert($itemData);

                        $inner_affectedRows = $this->db->affectedRows();

                        if ($inner_affectedRows == 1) {
                            $res['code'] = 200;
                            $res['message'] = "Data inserted successfully";

                        } else {
                            $res['code'] = 400;
                            $res['message'] = "Failed to insert data";

                        }
                    }

                    echo json_encode($res);
                } else if ($type == "buy_now") {
                    $prodID = $cartData[0]['prod_id'];
                    $cartQuantity = $cartData[0]['quantity'];
                    $cartPackqty = $cartData[0]['pack_qty'];
                    $cartPrice = $cartData[0]['prod_price'];
                    $cartTotal = $cartData[0]['total_price'];

                    // Main Product
                    $mainProductQuery = "SELECT main_quantity , has_variant  FROM tbl_products WHERE `prod_id` = ?";
                    $mainProductData = $this->db->query($mainProductQuery, [$prodID])->getRow();


                    $mainVariantQuery = "SELECT * FROM `tbl_variants` WHERE `prod_id` = ? AND  pack_qty = ? AND `flag` = 1";
                    $mainVariantData = $this->db->query($mainVariantQuery, [$prodID, $cartPackqty])->getRow();

                    $mainQuantity = $mainVariantData->quantity;
                    $mainPackQty = $mainVariantData->pack_qty;
                    $mainPrice = $mainVariantData->offer_price;
                    $variantID = $mainVariantData->variant_id;
                    $variantMRP = $mainVariantData->mrp;
                    $offerType = $mainVariantData->offer_type;
                    $offerDetails = $mainVariantData->offer_details;


                    $finalPrice = ($cartPrice == $mainPrice) ? $cartPrice : $mainPrice;


                    if ($cartQuantity <= $mainQuantity && $cartPrice == $mainPrice && $cartPrice != 0 && $originalPrice != 0) {
                        $OrderPrice = $cartTotal;

                    } else if ($mainPrice == 0 && $cartPrice == 0 || $mainPrice == 0) {
                        $OrderPrice = $mainPrice * $cartQuantity;
                    } else {
                        $OrderPrice = $mainPrice * $cartQuantity;
                    }


                    $itemData = [
                        'order_id' => $OrderID,
                        'prod_id' => $prodID,
                        'variant_id' => $variantID,
                        'quantity' => $cartQuantity,
                        'prod_price' => $finalPrice,
                        'sub_total' => $OrderPrice,
                        'mrp' => $variantMRP,
                        'offer_price' => $mainPrice,
                        'offer_type' => $offerType,
                        'offer_details' => $offerDetails,
                    ];

                    $insertItem = $OrderItemModal->insert($itemData);

                    $inner_affectedRows = $this->db->affectedRows();

                    if ($inner_affectedRows == 1) {
                        $res['code'] = 200;
                        $res['message'] = "Data inserted successfully";

                    } else {
                        $res['code'] = 400;
                        $res['message'] = "Failed to insert data";
                    }

                    echo json_encode($res);
                }


            }

        }


    }


    private function calculateGstInclusive($price, $gstPercent)
    {
        $gstValue = ($price * $gstPercent) / (100 + $gstPercent);
        $paise = round(fmod($gstValue, 1) * 100, 2);
        return $paise < 50 ? floor($gstValue) : ceil($gstValue);
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
        $source_type = 'cart';
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1 AND source_type = ?";
        $usercount = $this->db->query($query, [$userID, $source_type])->getResultArray();
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

        $sourceType = $this->request->getGet("type");

        if ($sourceType == 'cart') {
            $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1 AND source_type = ?";
            $cartData = $this->db->query($query, [$userID, $sourceType])->getResultArray();
        } else if ($sourceType == 'buy_now') {
            $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1 AND source_type = ?";
            $cartData = $this->db->query($query, [$userID, $sourceType])->getResultArray();
        }


        $query = "SELECT cart_id  FROM tbl_user_cart WHERE user_id = ? AND flag =1 AND source_type = ?";
        $cartCount = $this->db->query($query, [$userID, 'cart'])->getResultArray();
        if (count($cartCount) > 0) {
            $res['cart_count'] = sizeof($cartCount);

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
                d.sub_id ,d.gst
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


        $gst_subid_list = [];
        // Loop through each product
        foreach ($res['checkout_product'] as $i => $item) {
            $productPrice = (float) str_replace(',', '', $item['offer_price']);
            $cartQuantity = (int) $item['cart_quantity'];
            $mainQuantity = (int) $item['variant_qty'];
            $gstPercent = (float) $item['gst'];
            $subID = $item['sub_id'];

            $priceCalculation = 0;
            $gstValue = 0;

            if ($cartQuantity <= $mainQuantity) {
                $priceCalculation = $productPrice * $cartQuantity;
                $res['checkout_product'][$i]['final_prod_price'] = round($priceCalculation, 2);

                // GST per item (inclusive)
                if ($gstPercent > 0) {
                    $gst_subid[] = $gst_subid;
                    $gstValue = $this->calculateGstInclusive($priceCalculation, $gstPercent);
                    $gst_subid_list[] = $subID;
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
        $res['gst_subid_list'] = $gst_subid_list;
        $res['type'] = $sourceType;

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

    public function getSingleAddress()
    {
        $addID = $this->request->getPost('add_id');
        $userID = session()->get('user_id');

        $query = "SELECT a.*, b.state_title, c.dist_name 
        FROM tbl_user_address AS a 
        INNER JOIN tbl_state AS b ON a.state_id = b.state_id
        INNER JOIN tbl_district AS c ON a.dist_id = c.dist_id
        WHERE a.user_id = ? AND a.add_id = ?  AND a.flag = 1;";
        $result = $this->db->query($query, [$userID, $addID])->getRowArray();


        if ($result) {
            $res['code'] = 200;
            $res['message'] = "Address details fetched successfuly";
            $res['address'] = $result;
        } else {
            $res['code'] = 400;
            $res['message'] = "Failed to get address";
        }

        echo json_encode($res);

    }

    public function checkProductStatus()
    {

        $userID = session()->get('user_id');

        $sourceType = $this->request->getPost("source");


        if ($sourceType == 'cart') {
            $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1 AND source_type = ?";
            $cartData = $this->db->query($query, [$userID, $sourceType])->getResultArray();
        } else if ($sourceType == 'buy_now') {
            $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1 AND source_type = ?";
            $cartData = $this->db->query($query, [$userID, $sourceType])->getResultArray();
        }


        $query = "SELECT cart_id  FROM tbl_user_cart WHERE user_id = ? AND flag =1 AND source_type = ?";
        $cartCount = $this->db->query($query, [$userID, 'cart'])->getResultArray();
        if (count($cartCount) > 0) {
            $res['cart_count'] = sizeof($cartCount);

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
                d.sub_id ,d.gst
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

        $outOfStockProducts = [];

        foreach ($productDetails as $product) {
            if ((int) $product['variant_qty'] <= 0) {
                $outOfStockProducts[] = $product['prod_name'];
            }
        }

        $outofStock = count($outOfStockProducts);

        return $this->response->setJSON([
            'code' => $outofStock > 0 ? 400 : 200,
            'outofStockCount' => $outofStock,
        ]);

    }
}
