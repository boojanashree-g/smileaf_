<?php

namespace App\Controllers;

use App\Models\OrderModal;
use App\Models\OrderItemModal;

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
            $cartQuery = "SELECT * FROM `tbl_user_cart` WHERE `user_id` = ? AND `flag` =1 ";
            $cartData = $this->db->query($cartQuery, [$userID])->getResultArray();
        }

        if (empty($cartData)) {
            return json_encode(['code' => 400, 'status' => false, 'message' => 'Cart is empty!']);
        }

        //if 0
        $price_count = 0;
        $OrderPrice = 0;

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


                if (!$mainProductData) {
                    return json_encode(['code' => 400, 'status' => false, 'message' => 'Invalid product in cart.']);
                }

                $mainVariantQuery = "SELECT * FROM `tbl_variants` WHERE `prod_id` = ? AND  pack_qty = ? AND `flag` = 1";
                $mainVariantData = $this->db->query($mainVariantQuery, [$prodID, $cartPackqty])->getRow();


                if (!$mainVariantData) {
                    return json_encode(['code' => 400, 'status' => false, 'message' => 'Invalid Product Variants in cart.']);
                }

                $mainQuantity = $mainVariantData->quantity;
                $mainPackQty = $mainVariantData->pack_qty;
                $mainPrice = $mainVariantData->offer_price;

                $finalPrice = ($cartPrice == $mainPrice) ? $cartPrice : $mainPrice;


                if ($cartQuantity <= $mainQuantity && $cartPrice == $mainPrice && $cartPrice != 0 && $originalPrice != 0) {
                    $OrderPrice += $cartTotal;

                } else if ($mainPrice == 0 && $cartPrice == 0 || $mainPrice == 0) {
                    $price_count += 1;
                    $OrderPrice += $mainPrice * $cartQuantity;
                } else {
                    $OrderPrice += $mainPrice * $cartQuantity;
                }
            }
        }


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
                'order_date' => date('d-m-Y'),
                'courier_charge' => $totalShipping,
                'courier_type' => $courierType,
            ];




            $insertOrder = $OrderModal->insert($orderData);

            $OrderID = $this->db->insertID();
            $sess = [
                'order_id' => $OrderID,
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
                }


            }

        }


    }

}
