<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;

use App\Models\admin\ImageModel;
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
        $ImageModel = new ImageModel();
        $data = $request->getPost();


        try {
            $productName = $request->getPost('prod_name');
            $hasVariant = $request->getPost('has_variant');
            $variants = $request->getPost('variants');
            $data = $request->getPost();



            $url = strtolower(trim(preg_replace('/-+/', '-', preg_replace('/[^A-Za-z0-9-]+/', '-', $productName)), '-'));

            $MainImg = $request->getFile('main_image');
            $randomName = '';

            if ($MainImg && $MainImg->isValid()) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                if (in_array($MainImg->getMimeType(), $allowedTypes)) {
                    if ($MainImg->getSize() < 512000) {  // 500 KB
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
                    'best_seller' => $request->getPost('best_seller'),
                ];
                $ProductModel->insert($data);
                $lastInsertedID = $ProductModel->insertID();

                if ($lastInsertedID) {
                    $quantity = $request->getPost('quantity');
                    if ((int) $hasVariant == 0) {
                        $variantData = [
                            'prod_id' => $lastInsertedID,
                            'pack_qty' => $request->getPost('pack_qty') ?? 0,
                            'mrp' => $request->getPost('mrp'),
                            'offer_type' => $request->getPost('offer_type'),
                            'offer_details' => $request->getPost('offer_details'),
                            'offer_price' => $request->getPost('offer_price'),
                            'stock_status' => $request->getPost('stock_status'),
                            'quantity' => $quantity,
                            'weight' => $request->getPost('weight'),
                        ];

                        $VariantModel->insert($variantData);
                        $affected = $this->db->affectedRows();
                        if ($affected > 0) {
                            $updateQry = "UPDATE tbl_products SET main_quantity = ? WHERE prod_id = ?";
                            $updateData = $this->db->query($updateQry, [$quantity, $lastInsertedID]);
                        }

                    } else {
                        for ($i = 0; $i < count($variants); $i++) {
                            $totalQuantity += (int) $variants[$i]['quantity'];

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

                        $updateQry = "UPDATE tbl_products SET main_quantity = ? WHERE prod_id = ?";
                        $updateData = $this->db->query($updateQry, [$totalQuantity, $lastInsertedID]);
                    }

                    $images = $this->request->getFiles();
                    foreach ($images['images'] as $subImg) {
                        if ($subImg->isValid()) {
                            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                            if (in_array($subImg->getMimeType(), $allowedTypes)) {
                                if ($subImg->getSize() <= 512000) {  // 500 KB
                                    $randomName = $subImg->getRandomName();
                                    $subImg->move('./uploads/', $randomName);

                                    $imageData = [
                                        'prod_id' => $lastInsertedID,
                                        'image_path' => '/uploads/' . $randomName,
                                    ];

                                    $ImageModel->insert($imageData);
                                } else {
                                    return $this->response->setJSON([
                                        'code' => 400,
                                        'status' => 'error',
                                        'msg' => 'Images  must be less than 500KB.'
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

                    return $this->response->setJSON([
                        'code' => 200,
                        'status' => 'success',
                        'msg' => 'Data Inserted Successfully'
                    ]);


                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'error',
                        'msg' => 'Product not inserted.'
                    ]);
                }
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
            $variantData = $this->db->query($variantQry, [$prodID])->getResultArray();


            $imageQry = "SELECT `image_path` FROM `tbl_images` WHERE `flag` = 1 AND `prod_id` = ?";
            $imageData = $this->db->query($imageQry, [$prodID])->getResultArray();
            $imagePaths = array_column($imageData, 'image_path');


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


        echo json_encode($productDetails);
    }


    public function updateData()
    {
        $request = $this->request;
        $ProductModel = new ProductModel();
        $VariantModel = new VariantModel();
        $ImageModel = new ImageModel();

        try {
            $getData = $this->request->getPost();


            $productName = $request->getPost('prod_name');
            $productID = $request->getPost('prod_id');

            $hasVariant = $request->getPost('has_variant');
            $variants = $request->getPost('variants');

            $url = strtolower(trim(preg_replace('/-+/', '-', preg_replace('/[^A-Za-z0-9-]+/', '-', $productName)), '-'));

            $MainImg = $request->getFile('main_image');

            $randomName = '';

            if ($MainImg && $MainImg->isValid()) {
                // Get Old image
                $query = "SELECT main_image FROM tbl_products WHERE `prod_id`  = ?";
                $mainImg = $this->db->query($query, [$productID])->getRow();

                $imagePath = FCPATH . $mainImg->main_image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (in_array($MainImg->getMimeType(), $allowedTypes)) {
                    if ($MainImg->getSize() <= 512000) {  // 500 KB
                        $randomName = $MainImg->getRandomName();
                        $MainImg->move('./uploads/', $randomName);

                        $main_image = '/uploads/' . $randomName;

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
            } else {
                // Get Old image
                $query = "SELECT main_image FROM tbl_products WHERE `prod_id`  = ?";
                $mainImg = $this->db->query($query, [$productID])->getRow();

                $main_image = $mainImg->main_image;

            }


            if (!empty($productID)) {
                $data = [
                    'prod_name' => $productName,
                    'menu_id' => $request->getPost('menu_id'),
                    'submenu_id' => $request->getPost('sub_id'),
                    'url' => $url,
                    'description' => $request->getPost('description'),
                    'product_usage' => $request->getPost('product_usage'),
                    'main_image' => $main_image,
                    'has_variant' => $request->getPost('has_variant'),
                    'type_id' => $request->getPost('type_id'),
                    'shape_id' => $request->getPost('shape_id'),
                    'size_id' => $request->getPost('size_id'),
                    'best_seller' => $request->getPost('best_seller'),
                ];


                if (!empty($productID)) {
                    $ProductModel->update($productID, $data);
                    $lastInsertedID = $productID;

                    $VariantModel->where('prod_id', $productID)->delete();
                } else {
                    // Insert new product
                    $ProductModel->insert($data);
                    $lastInsertedID = $ProductModel->insertID();
                }

                $affectedRows = $this->db->affectedRows();

                if ($lastInsertedID) {

                    if ((int) $hasVariant == 0) {
                        $quantity = $request->getPost('quantity');
                        $variantData = [
                            'prod_id' => $lastInsertedID,
                            'pack_qty' => $request->getPost('pack_qty') ?? 0,
                            'mrp' => $request->getPost('mrp'),
                            'offer_type' => $request->getPost('offer_type'),
                            'offer_details' => $request->getPost('offer_details'),
                            'offer_price' => $request->getPost('offer_price'),
                            'stock_status' => $request->getPost('stock_status'),
                            'quantity' => $quantity,
                            'weight' => $request->getPost('weight'),
                        ];

                        $VariantModel->insert($variantData);


                        $affected = $this->db->affectedRows();
                        if ($affected > 0) {
                            $updateQry = "UPDATE tbl_products SET main_quantity = ? WHERE prod_id = ?";
                            $updateData = $this->db->query($updateQry, [$quantity, $lastInsertedID]);
                        }
                    } else {
                        for ($i = 0; $i < count($variants); $i++) {

                            $totalQuantity += (int) $variants[$i]['quantity'];
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
                            $affectedRows = $this->db->affectedRows();

                        }

                        $updateQry = "UPDATE tbl_products SET main_quantity = ? WHERE prod_id = ?";
                        $updateData = $this->db->query($updateQry, [$totalQuantity, $lastInsertedID]);
                    }



                    $existingImages = $this->request->getPost('existing_images');

                    // Ensure no duplicates
                    if (is_array($existingImages)) {
                        $existingImages = array_unique($existingImages);
                    } else {
                        $existingImages = [];
                    }



                    $images = $this->request->getFiles();
                    $allOldImages = $ImageModel->where('prod_id', $productID)->findAll();

                    // Delete from uploads if not in existingImages
                    foreach ($allOldImages as $img) {
                        $imgPath = $img['image_path'];
                        if (!in_array($imgPath, $existingImages)) {
                            $filePath = FCPATH . ltrim($imgPath, '/');
                            if (file_exists($filePath)) {
                                unlink($filePath);
                            }
                            $ImageModel->delete($img['image_id']);
                        }
                    }

                    if (!empty($images['images'])) {
                        foreach ($images['images'] as $subImg) {
                            if ($subImg->isValid() && !$subImg->hasMoved()) {
                                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                                $maxSize = 512000;

                                if (!in_array($subImg->getMimeType(), $allowedTypes)) {
                                    return $this->response->setJSON([
                                        'code' => 400,
                                        'status' => 'error',
                                        'msg' => 'Invalid image type. Only JPG, JPEG, PNG allowed.'
                                    ]);
                                }

                                if ($subImg->getSize() > $maxSize) {
                                    return $this->response->setJSON([
                                        'code' => 400,
                                        'status' => 'error',
                                        'msg' => 'Images must be less than 500KB.'
                                    ]);
                                }

                                $randomName = $subImg->getRandomName();
                                $subImg->move(FCPATH . 'uploads/', $randomName);

                                $ImageModel->insert([
                                    'prod_id' => $productID,
                                    'image_path' => '/uploads/' . $randomName
                                ]);
                                $affectedRows = $this->db->affectedRows();


                            }

                        }
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



                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'error',
                        'msg' => 'Product not updated.'
                    ]);
                }
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

    public function deleteData()
    {
        $ImageModel = new ImageModel;

        try {
            $prod_id = $this->request->getPost('prod_id');

            if ($prod_id) {
                $query = "SELECT main_image FROM tbl_products WHERE prod_id = ?";
                $mainImg = $this->db->query($query, [$prod_id])->getRow();

                if ($mainImg && $mainImg->main_image) {
                    $imagePath = FCPATH . $mainImg->main_image;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }


                $allOldImages = $ImageModel->where('prod_id', $prod_id)->findAll();

                foreach ($allOldImages as $img) {
                    if (!empty($img['image_path'])) {
                        $imagePath = FCPATH . $img['image_path'];
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                }

                $ImageModel->where('prod_id', $prod_id)->delete();


                $query = 'UPDATE tbl_products SET flag = 0 WHERE prod_id = ?';
                $updateData = $this->db->query($query, [$prod_id]);

                $affected_rows = $this->db->affectedRows();


                if ($affected_rows > 0) {
                    return $this->response->setJSON([
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Deleted Successfully'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'failure',
                        'message' => 'Something went wrong'
                    ]);
                }
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

    public function featuredProducts()
    {
        $res['meta_title'] = "Featured Products";
        $res['submenu'] = $this->db->query("SELECT `sub_id` , `submenu`  FROM `tbl_submenu` WHERE flag = 1")->getResultArray();

        return view("admin/featured_products", $res);
    }

    public function insertFeaturedData()
    {
        $sub_id = $this->request->getPost('sub_id');
        $prod_name = $this->request->getPost('prod_name');
        $file = $this->request->getFile('main_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);
            $imagePath = 'uploads/' . $newName;
        } else {
            return $this->response->setJSON([
                'code' => 500,
                'msg' => 'Image upload failed.',
            ]);
        }

        $data = [
            'sub_id' => $sub_id,
            'prod_name' => $prod_name,
            'image_url' => $imagePath,
            'flag' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $inserted = $this->db->table('tbl_featured_products')->insert($data);

        if ($inserted) {
            return $this->response->setJSON([
                'code' => 200,
                'msg' => 'Product added successfully.',
            ]);
        } else {
            return $this->response->setJSON([
                'code' => 500,
                'msg' => 'Database insertion failed.',
            ]);
        }
    }

    public function featuredProductDetails()
    {
        $res['meta_title'] = "Featured Products";
        $res['submenu'] = $this->db->query("SELECT `sub_id` , `submenu`  FROM `tbl_submenu` WHERE flag = 1")->getResultArray();

        return view("admin/featured_products", $res);
    }


    public function getFeaturedProductDetails()
    {
        $featuredProdData = $this->db->query("SELECT  a.* , b.submenu
        FROM
            `tbl_featured_products` AS a
        INNER JOIN tbl_submenu AS b
        ON
            a.sub_id = b.sub_id
        WHERE
             a.flag = '1'")->getResultArray();

        $featuredProductDetails = [];

        foreach ($featuredProdData as $prod) {
            $featuredProductDetails[] = [
                'prod_id' => $prod['featured_prod_id'],
                'prod_name' => $prod['prod_name'],
                'submenu_id' => $prod['sub_id'],
                'submenu' => $prod['submenu'],
                'image_url' => $prod['image_url'], // use correct key here
            ];
        }

        echo json_encode($featuredProductDetails);
    }


    public function deleteFeaturedData()
    {
        try {
            $prod_id = $this->request->getPost('prod_id');

            if ($prod_id) {
                $query = "UPDATE tbl_featured_products SET flag = '0' WHERE featured_prod_id = ?";
                $update = $this->db->query($query, [$prod_id]);
                $affected_rows = $this->db->affectedRows();
                if ($affected_rows > 0) {
                    return $this->response->setJSON([
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Deleted Successfully'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'failure',
                        'message' => 'Something went wrong'
                    ]);
                }
            }

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'status' => 'error',
                'msg' => 'Server Error: ' . $e->getMessage()
            ]);
        }
    }

    public function updateFeaturedData()
    {
        try {
            $request = $this->request;

            $productID = $request->getPost('prod_id');
            $productName = $request->getPost('prod_name');
            $subID = $request->getPost('sub_id');
            $MainImg = $request->getFile('main_image');

            if (!$productID || !$productName || !$subID) {
                return $this->response->setJSON([
                    'code' => 400,
                    'status' => 'error',
                    'msg' => 'Required fields are missing.'
                ]);
            }

            // Prepare image
            $image_url = null;

            if ($MainImg && $MainImg->isValid()) {
                // Get old image
                $query = "SELECT image_url FROM tbl_featured_products WHERE featured_prod_id = ?";
                $result = $this->db->query($query, [$productID])->getRow();

                if ($result && $result->image_url) {
                    $oldPath = FCPATH . ltrim($result->image_url, '/');
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!in_array($MainImg->getMimeType(), $allowedTypes)) {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'error',
                        'msg' => 'Only JPG, JPEG, PNG allowed.'
                    ]);
                }

                if ($MainImg->getSize() > 512000) {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'error',
                        'msg' => 'Image must be less than 500KB.'
                    ]);
                }

                $randomName = $MainImg->getRandomName();
                $MainImg->move('uploads/', $randomName);
                $image_url = '/uploads/' . $randomName;
            }

            // Prepare update data
            $updateData = [
                'prod_name' => $productName,
                'sub_id' => $subID
            ];

            if ($image_url) {
                $updateData['image_url'] = $image_url;
            }

            // Perform update
            $this->db->table('tbl_featured_products')
                ->where('featured_prod_id', $productID)
                ->update($updateData);

            return $this->response->setJSON([
                'code' => 200,
                'status' => 'success',
                'msg' => 'Featured product updated successfully.'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'status' => 'error',
                'msg' => 'Server Error: ' . $e->getMessage()
            ]);
        }
    }

}

