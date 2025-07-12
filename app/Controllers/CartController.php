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
        $qty = $this->request->getPost('quantity');
        $total_price = $this->request->getPost('total_price');
        $formated = number_format((float) $total_price, 2, '.', '');
        $cartID = $this->request->getPost('cart_id');


        $query = "UPDATE tbl_user_cart SET quantity =?, total_price = ? 
                  WHERE cart_id = ?  AND flag = 1 ";
        $updateData = $this->db->query($query, [$qty, $formated, $cartID]);

        $affectedRow = $this->db->affectedRows();

        if ($updateData && $affectedRow == 1) {
            $res['code'] = 200;
            $res['status'] = "success";
            echo json_encode($res);
        } else {
            $res['code'] = 400;
            $res['status'] = "Failure";
            echo json_encode($res);
        }
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