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
        $pack_qty = $this->request->getPost('pack_qty');
        $prod_id = $this->request->getPost('prod_id');
        $quantity = $this->request->getPost('quantity');
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
                "message" => "Product variant not found!",
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
            "SELECT * FROM tbl_user_cart WHERE prod_id = ? AND user_id = ? AND pack_qty = ? AND flag = 1",
            [$prod_id, $user_id, $pack_qty]
        )->getResultArray();

        if (count($cart_data) > 0) {
            $cart_id = $cart_data[0]['cart_id'];

            $update = $this->db->query(
                "UPDATE tbl_user_cart SET quantity = ?, prod_price = ?, total_price = ?, pack_qty = ? 
            WHERE user_id = ? AND prod_id = ? AND pack_qty = ? AND flag = 1 AND cart_id = ?",
                [$quantity, $proPrice, $totalPrice, $pack_qty, $user_id, $prod_id, $pack_qty, $cart_id]
            );

            $result = [
                "status" => $update && $this->db->affectedRows() ? "success" : "fail",
                "code" => $update && $this->db->affectedRows() ? 200 : 400,
                "message" => $update && $this->db->affectedRows() ? "Product quantity updated in cart" : "Product already in cart!",
            ];
        } else {
            $newCartData = [
                'user_id' => $user_id,
                'prod_id' => $prod_id,
                'quantity' => $quantity,
                'prod_price' => $proPrice,
                'total_price' => $totalPrice,
                'pack_qty' => $pack_qty
            ];

            $insert = $CartModel->insert($newCartData);

            $result = [
                "status" => $insert && $this->db->affectedRows() ? "success" : "fail",
                "code" => $insert && $this->db->affectedRows() ? 200 : 400,
                "message" => $insert && $this->db->affectedRows() ? "Product added to cart" : "Product add failed!",

            ];
        }

        return $this->response->setJSON($result);
    }


    


}