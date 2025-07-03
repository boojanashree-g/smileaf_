<?php

namespace App\Controllers;


class QuickViewController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }



    public function quickViewDetails()
    {

        $prod_id = $this->request->getPost('prod_id');
        $menu_id = $this->request->getPost('menu_id');
        $submenu_id = $this->request->getPost('submenu_id');

        if (empty($prod_id)) {
            throw new \InvalidArgumentException('Product ID is required');
        }


        $prodQry = "SELECT * FROM `tbl_products` WHERE flag = 1 AND `prod_id` = ? AND menu_id = ? AND submenu_id = ?";
        $prodData = $this->db->query($prodQry, [$prod_id, $menu_id, $submenu_id])->getResultArray();


        $variantQry = "SELECT * FROM `tbl_variants` WHERE `prod_id` = ? AND flag = 1";
        $variantData = $this->db->query($variantQry, [$prod_id])->getResultArray();



        $lowestOffer = null;
        foreach ($variantData as $variant) {
            if ($lowestOffer === null || $variant['offer_price'] < $lowestOffer['offer_price']) {
                $lowestOffer = $variant;
            }
        }
        // if ($lowestOffer) {
        //     $variantData['lowest_mrp'] = $lowestOffer['mrp'];
        //     $variantData['lowest_offer_price'] = $lowestOffer['offer_price'];
        //     $lowestQty = (!empty($lowestOffer['quantity']) && $lowestOffer['quantity'] > 0) ? (int) $lowestOffer['quantity'] : 0;
        //     $variantData['lowest_quantity'] = $lowestQty;

        // } else {
        //     $variantData['lowest_mrp'] = null;
        //     $variantData['lowest_offer_price'] = null;
        //     $variantData['lowest_quantity'] = null;
        // }



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
        ];

        return view("partials/common_cart_modal", $res);


    }
}