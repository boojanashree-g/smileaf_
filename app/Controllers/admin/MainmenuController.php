<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;

use App\Models\admin\MainmenuModel;


class MainmenuController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }


    public function mainMenu()
    {
        $res['meta_title'] = "Main Menu";
        return view("admin/main_menu", $res);
    }

    public function insertData()
    {

        try {

            $menu = $this->request->getPost('menu_name');
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $menu), '-'));


            if ($menu) {

                $MainmenuModel = new MainmenuModel();

                $data = [
                    'menu_name' => $menu,
                    'slug' => $slug,
                ];

                $MainmenuModel->insert($data);
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
        $res = $this->db->query("SELECT * FROM tbl_mainmenu WHERE flag = 1")->getResultArray();
        echo json_encode($res);
    }


    public function updateData()
    {

        $menu = $this->request->getPost('menu_name');
        $menuID = $this->request->getPost('menu_id');
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $menu), '-'));

        try {
            if (!empty($menuID)) {
                $updateQuery = 'UPDATE tbl_mainmenu SET `menu_name` = ? ,`slug` = ?  WHERE `menu_id` = ?';
                $updateData = $this->db->query($updateQuery, [$menu, $slug, $menuID]);

                if ($this->db->affectedRows() == 1) {
                    return $this->response->setJSON([
                        'code' => 200,
                        'msg' => 'Data Updated Successfully',
                        'status' => 'success'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'Failed',
                        'msg' => 'Data Update failed'
                    ]);
                }

            } else {
                return $this->response->setJSON([
                    'code' => 400,
                    'msg' => 'Invalid Menu',
                    'status' => 'Failed'
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
            $menu_id = $this->request->getPost('menu_id');


            $query = 'UPDATE `tbl_mainmenu` SET `flag`= 0 WHERE `menu_id` = ?';
            $updateData = $this->db->query($query, [$menu_id]);

            $affected_rows = $this->db->affectedRows();

            if ($affected_rows && $updateData) {
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
        $menu_id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        try {
            $updatequery = "UPDATE `tbl_mainmenu` SET `status` = ?   WHERE `menu_id` = ?";
            $updateStatus = $this->db->query($updatequery, [$status, $menu_id]);

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