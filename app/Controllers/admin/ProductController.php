<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;

use App\Models\admin\SubcatModel;
use App\Models\admin\ProductModel;
use App\Models\admin\VariantModel;


class ProductController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }


    public function ProductDetails()
    {
        $res['meta_title'] = "Product Details";
        $res['mainmenu'] = $this->db->query("SELECT `menu_id` , `menu_name`  FROM `tbl_mainmenu` WHERE `flag` = 1 AND `status` = 1")->getResultArray();
        $res['submenu'] = $this->db->query("SELECT `sub_id` , `submenu`  FROM `tbl_submenu` WHERE flag = 1")->getResultArray();

        // filter
        $res['filter_type'] = $this->db->query("SELECT `type_id` ,`type_name`  FROM `tbl_filter_type` WHERE `flag` =  1 AND `type_status` = 1")->getResultArray();
        $res['filter_shape'] = $this->db->query("SELECT `shape_id` , `shape_name` FROM `tbl_filter_shapes` WHERE `flag` =  1 AND `status` =  1")->getResultArray();
        $res['filter_size'] = $this->db->query("SELECT `size_id` ,`size_name`  FROM `tbl_filter_size` WHERE `status` = 1 AND `flag` =  1")->getResultArray();


        return view("admin/product_details", $res);
    }

    public function getSubmenu()
    {
        $menuID = $this->request->getPost('menu_id');
        $getSubmenu = $this->db->query("SELECT `sub_id` , `submenu`  FROM `tbl_submenu` WHERE  flag = 1 AND `menu_id` =  $menuID AND `status` = 1;")->getResultArray();
        return $this->response->setJSON($getSubmenu);

    }

    public function insertData()
    {
        $request = $this->request;
        $ProductModel = new ProductModel();
        $VariantModel = new VariantModel();

        $data = $this->request->getPost();
        try {
            $productName = $request->getPost('prod_name');
            $hasVariant = $request->getPost('has_variant');
            $variants = $request->getPost('variants');


            $url = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $productName), '-'));

            $MainImg = $request->getFile('main_image');
            $randomName = '';

            if ($MainImg && $MainImg->isValid()) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                if (in_array($MainImg->getMimeType(), $allowedTypes)) {
                    if ($MainImg->getSize() <= 512000) {  // 500 KB
                        $randomName = $MainImg->getRandomName();
                        $MainImg->move('./uploads/', $randomName);
                    } else {
                        return $this->response->setJSON([
                            'code' => 400,
                            'status' => 'error',
                            'msg' => 'Main image must be less than 500KB.'
                        ]);
                    }
                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'error',
                        'msg' => 'Invalid image type. Only JPG, JPEG, PNG allowed.'
                    ]);
                }
            }


            if (!empty($productName)) {
                $data = [
                    'prod_name' => $productName,
                    'menu_id' => $request->getPost('menu_id'),
                    'submenu_id' => $request->getPost('sub_id'),
                    'url' => $url,
                    'description' => $request->getPost('description'),
                    'product_usage' => $request->getPost('product_usage'),
                    'main_image' => '/uploads/' . $randomName,
                    'has_variant' => $request->getPost('has_variant'),
                    'type_id' => $request->getPost('type_id'),
                    'shape_id' => $request->getPost('shape_id'),
                    'size_id' => $request->getPost('size_id'),
                ];
                $ProductModel->insert($data);
                $lastInsertedID = $ProductModel->insertID();

                if ($lastInsertedID) {

                    if ($hasVariant == 0) {
                        $variantData = [
                            'prod_id' => $lastInsertedID,
                            'pack_qty' => $request->getPost('pack_qty'),
                            'mrp' => $request->getPost('mrp'),
                            'offer_type' => $request->getPost('offer_type'),
                            'offer_details' => $request->getPost('offer_details'),
                            'offer_price' => $request->getPost('offer_price'),
                            'stock_status' => $request->getPost('stock_status'),
                            'quantity' => $request->getPost('quantity'),
                            'weight' => $request->getPost('weight'),
                        ];

                        $VariantModel->insert($variantData);
                    } else {
                        for ($i = 0; $i < count($variants); $i++) {
                            $variantData = [
                                'prod_id' => $lastInsertedID,
                                'pack_qty' => $variants[$i]['pack_qty'],
                                'mrp' => $variants[$i]['mrp'],
                                'offer_type' => $variants[$i]['offer_type'],
                                'offer_details' => $variants[$i]['offer_details'],
                                'offer_price' => $variants[$i]['offer_price'],
                                'stock_status' => $variants[$i]['stock_status'],
                                'quantity' => $variants[$i]['quantity'],
                                'weight' => $variants[$i]['weight'],
                            ];
                            $VariantModel->insert($variantData);
                        }
                    }

                    $images = $this->request->getFiles();
                    foreach ($images['images'] as $subImg) {
                        if ($subImg->isValid()) {
                            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                            if (in_array($subImg->getMimeType(), $allowedTypes)) {
                                if ($subImg->getSize() <= 512000) {  // 500 KB
                                    $randomName = $subImg->getRandomName();
                                    $subImg->move('./uploads/', $randomName);


                                } else {
                                    return $this->response->setJSON([
                                        'code' => 400,
                                        'status' => 'error',
                                        'msg' => 'Main image must be less than 500KB.'
                                    ]);
                                }
                            } else {
                                return $this->response->setJSON([
                                    'code' => 400,
                                    'status' => 'error',
                                    'msg' => 'Invalid image type. Only JPG, JPEG, PNG allowed.'
                                ]);
                            }
                        }
                    }


                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'error',
                        'msg' => 'Product not inserted.'
                    ]);
                }





                return $this->response->setJSON([
                    'code' => 200,
                    'status' => 'success',
                    'msg' => 'Product inserted successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'code' => 400,
                    'status' => 'error',
                    'msg' => 'Product name is required.'
                ]);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'status' => 'error',
                'msg' => 'Server Error: ' . $e->getMessage()
            ]);
        }
    }



    public function getData()
    {
        $res = $this->db->query("SELECT
            a.menu_id,
            a.menu_name,
            b.submenu,
            c.*
        FROM
            tbl_mainmenu AS a
        INNER JOIN tbl_submenu AS b
        ON
            a.menu_id = b.menu_id
        INNER JOIN tbl_sub_category AS c
        ON
            c.submenu_id = b.sub_id
        WHERE
            b.flag = 1 AND a.flag = 1 AND c.flag = 1;")->getResultArray();

        echo json_encode($res);
    }


    public function updateData()
    {
        $catName = $this->request->getPost('cat_name');
        $submenuID = $this->request->getPost('submenu_id');
        $catID = $this->request->getPost('cat_id');
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $catName), '-'));

        $data = [
            'submenu_id' => $submenuID,
            'cat_name' => $catName,
            'slug' => $slug,
            'status' => 1,
        ];

        $SubcatModel = new SubcatModel();

        try {
            $updated = $SubcatModel->update($catID, $data);

            if ($updated) {
                return $this->response->setJSON([
                    'code' => 200,
                    'msg' => 'Data Updated Successfully',
                    'status' => 'success'
                ]);
            } else {
                return $this->response->setJSON([
                    'code' => 400,
                    'status' => 'Failed',
                    'msg' => 'Data Update failed or no changes made'
                ]);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'status' => 'error',
                'msg' => 'Server Error: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteData()
    {

        try {
            $cat_id = $this->request->getPost('cat_id');


            $query = 'UPDATE `tbl_sub_category` SET `flag`= 0 WHERE `cat_id` = ?';
            $updateData = $this->db->query($query, [$cat_id]);

            $affected_rows = $this->db->affectedRows();

            if ($affected_rows) {
                $result['code'] = 200;
                $result['status'] = 'success';
                $result['message'] = 'Deleted Successfully';
                echo json_encode($result);
            } else {
                $result['code'] = 400;
                $result['status'] = 'Failure';
                $result['message'] = 'Something wrong';
                echo json_encode($result);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'status' => 'error',
                'msg' => 'Server Error: ' . $e->getMessage()
            ]);

        }

    }


    public function updateStatus()
    {
        $subcat_id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        try {
            $updatequery = "UPDATE `tbl_sub_category` SET `status` = ?   WHERE `cat_id` = ?";
            $updateStatus = $this->db->query($updatequery, [$status, $subcat_id]);

            if ($this->db->affectedRows()) {
                $result['code'] = 200;
                $result['status'] = 'success';
                $result['msg'] = 'Status Updated Successfully';
                echo json_encode($result);
            } else {
                $result['code'] = 400;
                $result['status'] = 'Failure';
                $result['msg'] = 'Status Updated Failed';
                echo json_encode($result);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'status' => 'error',
                'msg' => 'Server Error: ' . $e->getMessage()
            ]);

        }


    }


}