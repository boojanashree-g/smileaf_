<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;

use App\Models\admin\SubcatModel;


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
        $res['mainmenu'] = $this->db->query("SELECT `menu_id` , `menu_name`  FROM `tbl_mainmenu` WHERE `flag` = 1")->getResultArray();
        $res['submenu'] = $this->db->query("SELECT `sub_id` , `submenu`  FROM `tbl_submenu` WHERE flag = 1")->getResultArray();
        return view("admin/product_details", $res);
    }

    public function getSubmenu()
    {
        $menuID = $this->request->getPost('menu_id');
        $query = $this->db->query("SELECT `sub_id` , `submenu`  FROM `tbl_submenu` WHERE  flag = 1")->getResultArray();

    }

    public function insertData()
    {
        try {
            $submenu_id = $this->request->getPost('submenu_id');
            $category = $this->request->getPost('cat_name');
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category), '-'));

            if ($category) {
                $SubcatModel = new SubcatModel();

                $data = [
                    'submenu_id' => $submenu_id,
                    'cat_name' => $category,
                    'slug' => $slug,
                ];

                $SubcatModel->insert($data);
                if ($this->db->affectedRows() == 1) {
                    return $this->response->setJSON([
                        'code' => 200,
                        'msg' => 'Data Inserted Successfully',
                        'status' => 'success'
                    ]);

                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'Failed',
                        'msg' => 'Data Inserted failed'
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