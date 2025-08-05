<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\admin\ProductModel;
use App\Models\admin\VariantModel;
class StockController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    public function stockDetails()
    {
        $res['meta_title'] = "Stock Details";
        $res['mainmenu'] = $this->db->query("SELECT `menu_id` , `menu_name`  FROM `tbl_mainmenu` WHERE `flag` = 1 AND `status` = 1")->getResultArray();
        $res['submenu'] = $this->db->query("SELECT `sub_id` , `submenu`  FROM `tbl_submenu` WHERE flag = 1")->getResultArray();

        // filter
        $res['filter_type'] = $this->db->query("SELECT `type_id` ,`type_name`  FROM `tbl_filter_type` WHERE `flag` =  1 AND `type_status` = 1")->getResultArray();
        $res['filter_shape'] = $this->db->query("SELECT `shape_id` , `shape_name` FROM `tbl_filter_shapes` WHERE `flag` =  1 AND `status` =  1")->getResultArray();
        $res['filter_size'] = $this->db->query("SELECT `size_id` ,`size_name`  FROM `tbl_filter_size` WHERE `status` = 1 AND `flag` =  1")->getResultArray();

        $res['status'] = $this->request->getGet('status');


        return view("admin/stock_details", $res);

    }

    public function getData()
    {
        $status = $this->request->getPost('status');
        $prodData = $this->db->query("SELECT
            a.* , b.menu_name ,c.submenu
        FROM
            `tbl_products` AS a
        INNER JOIN tbl_mainmenu AS b
        ON
            a.menu_id = b.menu_id
        INNER JOIN tbl_submenu AS c
        ON
            c.sub_id = a.`submenu_id`
        WHERE
            a.`flag` = 1 AND b.status = 1 AND b.flag = 1 AND c.status = 1 AND c.flag = 1 ORDER BY a.`prod_id` DESC;")->getResultArray();
        $productDetails = [];
        foreach ($prodData as $prod) {

            $prodID = $prod['prod_id'];
            $variantQry = "SELECT `variant_id`, `pack_qty`, `mrp`, `offer_type`, `offer_details`, `offer_price`, `stock_status`, `quantity`, `weight` FROM `tbl_variants` WHERE `flag` = 1 AND `prod_id` = ?";

            if ($status == 'outofstock') {
                $variantQry .= 'AND quantity <= 0 ';
            } elseif ($status == 'lowqty') {
                $variantQry .= 'AND quantity  <= 10 AND quantity <> 0 ';
            }

            $variantData = $this->db->query($variantQry, [$prodID])->getResultArray();

            $imageQry = "SELECT `image_path` FROM `tbl_images` WHERE `flag` = 1 AND `prod_id` = ?";
            $imageData = $this->db->query($imageQry, [$prodID])->getResultArray();
            $imagePaths = array_column($imageData, 'image_path');

            if (count($variantData) != 0) {
                $productDetails[] = [
                    'prod_id' => $prod['prod_id'],
                    'prod_name' => $prod['prod_name'],
                    'menu_id' => $prod['menu_id'],
                    'submenu_id' => $prod['submenu_id'],
                    'menu' => $prod['menu_name'],
                    'submenu' => $prod['submenu'],
                    'url' => $prod['url'],
                    'description' => $prod['description'],
                    'product_usage' => $prod['product_usage'],
                    'main_image' => $prod['main_image'],
                    'has_variant' => $prod['has_variant'],
                    'type_id' => $prod['type_id'],
                    'shape_id' => $prod['shape_id'],
                    'size_id' => $prod['size_id'],
                    'variants' => $variantData,
                    'product_images' => $imagePaths,
                    'best_seller' => $prod['best_seller'],

                ];
            }
        }

        echo json_encode($productDetails);

    }

    public function updateData()
    {

        $ProductModel = new ProductModel();
        $VariantModel = new VariantModel();
        $res = $this->request->getPost();



        $hasVariant = $this->request->getPost('has_variant');
        $prodID = $this->request->getPost('prod_id');
        $variants = $this->request->getPost('variants');


        $Products = $this->db->query('SELECT `main_quantity` , `has_variant` FROM `tbl_products` WHERE `flag` = 1 AND `prod_id` = ?', [$prodID])->getRow();
        $mainQty = $Products->main_quantity;
        $mainHasVariant = $Products->has_variant;


        if ((int) $hasVariant == 0) {

            if ($mainHasVariant == $hasVariant) {
                $oldVariants = $this->db->query("DELETE FROM  `tbl_variants`   WHERE `prod_id`  = ?", [$prodID]);
            }
            $quantity = $this->request->getPost('quantity');

            $variantData = [
                'prod_id' => $prodID,
                'pack_qty' => $this->request->getPost('pack_qty') ?? 0,
                'mrp' => $this->request->getPost('mrp'),
                'offer_type' => $this->request->getPost('offer_type'),
                'offer_details' => $this->request->getPost('offer_details'),
                'offer_price' => $this->request->getPost('offer_price'),
                'stock_status' => $this->request->getPost('stock_status'),
                'quantity' => $quantity,
                'weight' => $this->request->getPost('weight'),
            ];


            $VariantModel->insert($variantData);

            $affected = $this->db->affectedRows();

            if ($affected > 0) {
                $updateQry = "UPDATE tbl_products SET main_quantity = ? WHERE prod_id = ?";
                $updateData = $this->db->query($updateQry, [$quantity, $prodID]);
                $affectedRows = $this->db->affectedRows();
            }

        } else {
            $totalQuantity = 0;

            for ($i = 0; $i < count($variants); $i++) {
                $variant_id = $variants[$i]['variant_id'] ?? null;

                $qty = (int) $variants[$i]['quantity'];
                $totalQuantity += $qty;

                $variantData = [
                    'prod_id' => $prodID,
                    'pack_qty' => $variants[$i]['pack_qty'],
                    'mrp' => $variants[$i]['mrp'],
                    'offer_type' => $variants[$i]['offer_type'],
                    'offer_details' => $variants[$i]['offer_details'],
                    'offer_price' => $variants[$i]['offer_price'],
                    'stock_status' => $variants[$i]['stock_status'],
                    'quantity' => $qty,
                    'weight' => $variants[$i]['weight'],
                ];


                if ($variant_id) {

                    $VariantModel->update($variant_id, $variantData);
                } else {
                    $VariantModel->insert($variantData);
                }

                $affectedRows = $this->db->affectedRows();

            }

            $VariantTotal = $this->db->query("SELECT SUM(quantity) AS total_qty FROM tbl_variants WHERE `prod_id` = ?", [$prodID])->getRow();
            $mainQtyy = $VariantTotal->total_qty;

            $updateQry = "UPDATE tbl_products SET main_quantity = ? WHERE prod_id = ?";
            $updateData = $this->db->query($updateQry, [$mainQtyy, $prodID]);
        }
        if ($affectedRows > 0) {
            return $this->response->setJSON([
                'code' => 200,
                'status' => 'success',
                'msg' => 'Data Updated Successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'code' => 400,
                'status' => 'error',
                'msg' => 'Product not updated.'
            ]);
        }


    }



}