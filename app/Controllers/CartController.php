<?php

namespace App\Controllers;

use App\Models\CartModel;


class CartController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }


    public function insertCart()
    {
        $CartModel = new CartModel();
        $data = $this->request->getPost();

        $pack_qty = $this->request->getPost('pack_qty');
        $prod_id = $this->request->getPost('prod_id');
        $quantity = $this->request->getPost('quantity');
        $source_type = $this->request->getPost('source_type');

        $user_id = $this->session->get('user_id');


        // Get product variant details
        $variant = $this->db->query(
            "SELECT offer_price, quantity, pack_qty FROM tbl_variants WHERE prod_id = ? AND pack_qty = ? AND flag = 1",
            [$prod_id, $pack_qty]
        )->getRow();

        if (!$variant) {
            return $this->response->setJSON([
                "status" => "fail",
                "code" => 404,
                "message" => "Please select a pack size.",
            ]);
        }

        if ($quantity > $variant->quantity) {
            return $this->response->setJSON([
                "status" => "fail",
                "code" => 400,
                "message" => "Requested quantity exceeds available stock!",
            ]);
        }

        $proPrice = number_format((float) $variant->offer_price, 2, '.', '');
        $subTotal = $proPrice * $quantity;
        $totalPrice = number_format((float) $subTotal, 2, '.', '');

        // Check if already in cart
        $cart_data = $this->db->query(
            "SELECT * FROM tbl_user_cart WHERE prod_id = ? AND user_id = ? AND pack_qty = ? AND flag = 1 AND source_type = ? ",
            [$prod_id, $user_id, $pack_qty, $source_type]
        )->getResultArray();

        $oldCartCount = count($cart_data);
        if ($oldCartCount >= 1) {
            return $this->response->setJSON([
                "status" => "fail",
                "code" => 400,
                "message" => "Product with pack $pack_qty already in cart!",
            ]);
        }

        if (!empty($cart_data)) {
            $cart_id = $cart_data[0]['cart_id'];

            $update = $this->db->query(
                "UPDATE tbl_user_cart SET quantity = ?, prod_price = ?, total_price = ?, pack_qty = ? ,source_type = ?
            WHERE user_id = ? AND prod_id = ? AND pack_qty = ? AND flag = 1 AND cart_id = ?",
                [$quantity, $proPrice, $totalPrice, $pack_qty, $source_type, $user_id, $prod_id, $pack_qty, $cart_id]
            );

            // Cart count
            $cartCount = $this->getCartCount($user_id, $source_type);

            $result = [
                "status" => $update ? "success" : "fail",
                "code" => $update ? 200 : 400,
                "message" => $update ? "Product quantity updated in cart" : "Product already in cart!",
                "cart_count" => $cartCount
            ];

            return $this->response->setJSON($result);
        } else {

            $newCartData = [
                'user_id' => $user_id,
                'prod_id' => $prod_id,
                'quantity' => $quantity,
                'prod_price' => $proPrice,
                'total_price' => $totalPrice,
                'pack_qty' => $pack_qty,
                'source_type' => $source_type
            ];

            $insert = $CartModel->insert($newCartData);

            // Cart count
            $cartCount = $this->getCartCount($user_id, $source_type);


            $result = [
                "status" => $insert ? "success" : "fail",
                "code" => $insert ? 200 : 400,
                "message" => $insert ? "Product added to cart" : "Product add failed!",
                "cart_count" => $cartCount
            ];
            return $this->response->setJSON($result);
        }
    }


    public function insertBuynow()
    {
        $CartModel = new CartModel();
        $data = $this->request->getPost();

        $pack_qty = $this->request->getPost('pack_qty');
        $prod_id = $this->request->getPost('prod_id');
        $quantity = $this->request->getPost('quantity');
        $source_type = $this->request->getPost('source_type');

        $user_id = $this->session->get('user_id');

        // Get product variant details
        $variant = $this->db->query(
            "SELECT offer_price, quantity, pack_qty FROM tbl_variants WHERE prod_id = ? AND pack_qty = ? AND flag = 1",
            [$prod_id, $pack_qty]
        )->getRow();


        $proPrice = number_format((float) $variant->offer_price, 2, '.', '');
        $subTotal = $proPrice * $quantity;
        $totalPrice = number_format((float) $subTotal, 2, '.', '');

        // Check userid already has product in cart 
        $cart_data = $this->db->query(
            "SELECT * FROM tbl_user_cart WHERE  user_id = ? AND flag = 1 AND source_type = ? ",
            [$user_id, $source_type]
        )->getResultArray();

        if (count($cart_data) > 0) {
            foreach ($cart_data as $cart) {
                $cartID = $cart['cart_id'];
                $deleteQry = "DELETE FROM `tbl_user_cart` WHERE `cart_id` = ? AND `source_type` = ? AND flag = 1";
                $deleteData = $this->db->query($deleteQry, [$cartID, $source_type]);
            }
        }

        $newCartData = [
            'user_id' => $user_id,
            'prod_id' => $prod_id,
            'quantity' => $quantity,
            'prod_price' => $proPrice,
            'total_price' => $totalPrice,
            'pack_qty' => $pack_qty,
            'source_type' => $source_type
        ];

        $insert = $CartModel->insert($newCartData);

        $result = [
            "status" => $insert ? "success" : "fail",
            "code" => $insert ? 200 : 400,
            "message" => $insert ? "Product added to cart" : "Product add failed!",

        ];
        return $this->response->setJSON($result);
    }

    private function getCartCount($user_id, $source_type)
    {
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1 AND source_type = ?";
        $usercount = $this->db->query($query, [$user_id, $source_type])->getResultArray();


        if ($usercount > 0) {
            $cartCount = sizeof($usercount);

        } else {
            $cartCount = 0;
        }

        return $cartCount;
    }

    public function updateCart()
    {
        $qty = (int) $this->request->getPost('quantity');
        $cartID = $this->request->getPost('cart_id');
        $userID = session()->get("user_id");

        $getCart = $this->db->query("SELECT * FROM tbl_user_cart WHERE cart_id = ?", [$cartID])->getRowArray();
        if (!$getCart) {
            return json_encode([
                'code' => 404,
                'status' => 'Cart item not found',
            ]);
        }

        $prodID = $getCart['prod_id'];
        $packQty = $getCart['pack_qty'];

        // Get product price and GST (if GST is stored)
        $getPrice = $this->db->query(
            "SELECT offer_price FROM tbl_variants WHERE prod_id = ? AND pack_qty = ?",
            [$prodID, $packQty]
        )->getRowArray();


        if (!$getPrice) {
            return json_encode([
                'code' => 404,
                'status' => 'Product not found',
            ]);
        }

        $getMenu = $this->db->query("SELECT `menu_id` , `submenu_id` FROM tbl_products WHERE `prod_id` = ? AND flag =1", [$prodID])->getRowArray();
        $menuID = $getMenu['menu_id'];
        $submenuID = $getMenu['submenu_id'];

        $getGst = $this->db->query("SELECT `gst` FROM `tbl_submenu`  WHERE `sub_id` = ?  AND  `menu_id` = ? AND flag =1", [$submenuID, $menuID])->getRowArray();

        $price = (float) $getPrice['offer_price'];
        $gstPercent = (float) $getGst['gst'] ?? 0;

        // Calculate item subtotal
        $subTotal = $qty * $price;
        $formattedSubTotal = number_format($subTotal, 2, '.', '');

        // Update cart with new quantity and price
        $query = "UPDATE tbl_user_cart SET quantity = ?, total_price = ? WHERE cart_id = ? AND flag = 1";
        $updateData = $this->db->query($query, [$qty, $formattedSubTotal, $cartID]);

        if (!$updateData) {
            return json_encode([
                'code' => 400,
                'status' => 'Failure'
            ]);
        }

        // Recalculate grand total for the user
        $cartItems = $this->db->query(
            "SELECT total_price, prod_id, pack_qty FROM tbl_user_cart WHERE user_id = ? AND flag = 1",
            [$userID]
        )->getResultArray();

        $grandTotal = 0;
        $totalGstValue = 0;

        foreach ($cartItems as $item) {
            $itemTotal = (float) $item['total_price'];
            $grandTotal += $itemTotal;


            $getMenu = $this->db->query("SELECT `menu_id` , `submenu_id` FROM tbl_products WHERE `prod_id` = ? AND flag =1", [$item['prod_id']])->getRowArray();
            $menuID = $getMenu['menu_id'];
            $submenuID = $getMenu['submenu_id'];

            $getGst = $this->db->query("SELECT `gst` FROM `tbl_submenu`  WHERE `sub_id` = ?  AND  `menu_id` = ? AND flag =1", [$submenuID, $menuID])->getRowArray();


            $itemGstPercent = (float) $getGst['gst'] ?? 0;

            if ($itemGstPercent > 0) {
                $itemGstValue = ($itemTotal * $itemGstPercent) / (100 + $itemGstPercent);
                $itemGstValue = round($itemGstValue);
                $totalGstValue += $itemGstValue;
            }
        }

        $subTotalWithoutGst = $grandTotal - $totalGstValue;
        $finalTotal = $grandTotal;


        $shippingCharge = 100;
        $courierOfferLimit = 500;
        $showCourierMessage = '';
        if ($grandTotal < $courierOfferLimit) {
            $finalTotal += $shippingCharge;
            $remaining = $courierOfferLimit - $grandTotal;
            $showCourierMessage = "🛒 You're just ₹" . number_format($remaining, 2) . " away from <strong>Free Shipping</strong>! Add more to your cart now!!";
        }


        $cgst = $sgst = round($totalGstValue / 2, 2);


        $res = [
            'code' => 200,
            'status' => 'success',
            'sub_total' => number_format($formattedSubTotal, 2, '.', ''),
            'total' => number_format($grandTotal, 2, '.', ''),
            'final_total' => number_format($finalTotal, 2, '.', ''),
            'sub_total_without_gst' => number_format($subTotalWithoutGst, 2, '.', ''),
            'gst' => number_format($totalGstValue, 2, '.', ''),
            'cgst' => number_format($cgst, 2, '.', ''),
            'sgst' => number_format($sgst, 2, '.', ''),
            'free_shipping_msg' => $showCourierMessage,
            'remaining' => $remaining ?? 0,
        ];


        return json_encode($res);
    }

    public function getIntialCart()
    {
        $userID = session()->get("user_id");


        $cartItems = $this->db->query(
            "SELECT total_price, prod_id, pack_qty FROM tbl_user_cart WHERE user_id = ? AND flag = 1",
            [$userID]
        )->getResultArray();

        $grandTotal = 0;
        $totalGstValue = 0;

        foreach ($cartItems as $item) {
            $itemTotal = (float) $item['total_price'];
            $grandTotal += $itemTotal;

            // Fetch GST % for each item
            $getMenu = $this->db->query("SELECT `menu_id` , `submenu_id` FROM tbl_products WHERE `prod_id` = ? AND flag =1", [$item['prod_id']])->getRowArray();
            $menuID = $getMenu['menu_id'];
            $submenuID = $getMenu['submenu_id'];

            $getGst = $this->db->query("SELECT `gst` FROM `tbl_submenu`  WHERE `sub_id` = ?  AND  `menu_id` = ? AND flag =1", [$submenuID, $menuID])->getRowArray();


            $itemGstPercent = (float) $getGst['gst'] ?? 0;

            if ($itemGstPercent > 0) {
                $itemGstValue = ($itemTotal * $itemGstPercent) / (100 + $itemGstPercent);
                $itemGstValue = round($itemGstValue);
                $totalGstValue += $itemGstValue;
            }
        }

        $subTotalWithoutGst = $grandTotal - $totalGstValue;
        $finalTotal = $grandTotal;

        // Add shipping charge if applicable
        $shippingCharge = 100;
        $courierOfferLimit = 500;
        $showCourierMessage = '';
        if ($grandTotal < $courierOfferLimit) {
            $finalTotal += $shippingCharge;
            $remaining = $courierOfferLimit - $grandTotal;
            $showCourierMessage = "🛒 You're just ₹" . number_format($remaining, 2) . " away from <strong>Free Shipping</strong>! Add more to your cart now!!";
        }


        $cgst = $sgst = round($totalGstValue / 2, 2);

        $res = [
            'code' => 200,
            'status' => 'success',
            'total' => number_format($grandTotal, 2, '.', ''),
            'final_total' => number_format($finalTotal, 2, '.', ''),
            'sub_total_without_gst' => number_format($subTotalWithoutGst, 2, '.', ''),
            'gst' => number_format($totalGstValue, 2, '.', ''),
            'cgst' => number_format($cgst, 2, '.', ''),
            'sgst' => number_format($sgst, 2, '.', ''),
            'free_shipping_msg' => $showCourierMessage,
            'remaining' => $remaining ?? 0,
        ];

        echo json_encode($res);
    }



    public function deleteCart()
    {
        $cartID = $this->request->getPost('cart_id');
        $query = "UPDATE tbl_user_cart SET `flag` = 0 WHERE `cart_id` = ?";
        $dltData = $this->db->query($query, $cartID);

        $affectedRows = $this->db->affectedRows();

        if ($dltData && $affectedRows) {
            $result['code'] = 200;
            $result['message'] = 'Product Deleted Successfully!!';
            $result['status'] = 'success';
        } else {
            $result['code'] = 400;
            $result['message'] = 'Failed to delete Product';
            $result['status'] = 'failure';
        }
        echo json_encode($result);
    }





}