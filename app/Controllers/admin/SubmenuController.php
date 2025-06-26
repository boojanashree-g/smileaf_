<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;

use App\Models\admin\SubmenuModel;


class SubmenuController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }


    public function subMenu()
    {
        $res['meta_title'] = "Sub Menu";
        $res['menu'] = $this->db->query("SELECT `menu_id` , `menu_name`  FROM `tbl_mainmenu` WHERE flag = 1")->getResultArray();
        return view("admin/sub_menu", $res);
    }

    public function insertData()
    {
        try {
            $menu = $this->request->getPost('menu_id');
            $subMenu = $this->request->getPost('submenu');
            $gst = $this->request->getPost('gst');
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $subMenu), '-'));

            if (!$subMenu) {
                return $this->response->setJSON([
                    'code' => 400,
                    'status' => 'error',
                    'msg' => 'Submenu is required.'
                ]);
            }

            $SubmenuModel = new SubmenuModel();
            $SubmenuImg = $this->request->getFile('image_url');

            if ($SubmenuImg && $SubmenuImg->isValid()) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                if (in_array($SubmenuImg->getMimeType(), $allowedTypes)) {
                    if ($SubmenuImg->getSize() <= 2097152) {
                        $randomName = $SubmenuImg->getRandomName();
                        $SubmenuImg->move('./uploads/', $randomName);

                        $data = [
                            'image_url' => '/uploads/' . $randomName,
                            'menu_id' => $menu,
                            'submenu' => $subMenu,
                            'slug' => $slug,
                            'gst' => $gst,
                        ];

                        $SubmenuModel->insert($data);

                        if ($SubmenuModel->db->affectedRows() == 1) {
                            return $this->response->setJSON([
                                'code' => 200,
                                'msg' => 'Data Inserted Successfully',
                                'status' => 'success'
                            ]);
                        } else {
                            return $this->response->setJSON([
                                'code' => 400,
                                'status' => 'error',
                                'msg' => 'Data insertion failed'
                            ]);
                        }
                    } else {
                        return $this->response->setJSON([
                            'code' => 400,
                            'status' => 'error',
                            'msg' => 'Image must be less than 2MB'
                        ]);
                    }
                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'error',
                        'msg' => 'Only JPG, JPEG, and PNG files are allowed.'
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'code' => 400,
                    'status' => 'error',
                    'msg' => 'Image is not uploaded or is invalid.'
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
            a.menu_name,
            b.*
        FROM
            tbl_mainmenu AS a
        INNER JOIN tbl_submenu AS b
        ON
            a.menu_id = b.menu_id
        WHERE
            b.flag = 1 AND a.flag = 1")->getResultArray();


        echo json_encode($res);
    }


    public function updateData()
    {
        $submenu = $this->request->getPost('submenu');
        $menuID = $this->request->getPost('menu_id');
        $subID = $this->request->getPost('sub_id');
        $gst = $this->request->getPost('gst');
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $submenu), '-'));

        $SubmenuModel = new SubmenuModel();
        $SubmenuImg = $this->request->getFile('image_url');

        try {
            $data = [
                'submenu' => $submenu,
                'menu_id' => $menuID,
                'slug' => $slug,
                'gst' => $gst,
                'status' => 1
            ];

            if ($SubmenuImg && $SubmenuImg->isValid() && !$SubmenuImg->hasMoved()) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                if (in_array($SubmenuImg->getMimeType(), $allowedTypes)) {
                    if ($SubmenuImg->getSize() <= 2097152) {

                        $query = "SELECT image_url FROM tbl_submenu WHERE sub_id = ?";
                        $oldImg = $this->db->query($query, [$subID])->getRow();
                        if ($oldImg && !empty($oldImg->image_url)) {
                            $imagePath = FCPATH . ltrim($oldImg->image_url, '/');
                            if (file_exists($imagePath)) {
                                unlink($imagePath);
                            }
                        }

                        // Save new image
                        $randomName = $SubmenuImg->getRandomName();
                        $SubmenuImg->move('./uploads/', $randomName);
                        $data['image_url'] = '/uploads/' . $randomName;
                    } else {
                        return $this->response->setJSON([
                            'code' => 400,
                            'status' => 'error',
                            'msg' => 'Image must be less than 2MB.'
                        ]);
                    }
                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'status' => 'error',
                        'msg' => 'Only JPG, JPEG, and PNG files are allowed.'
                    ]);
                }
            }

            // Update database
            $SubmenuModel->update($subID, $data);
            if ($SubmenuModel->db->affectedRows() >= 0) {
                return $this->response->setJSON([
                    'code' => 200,
                    'msg' => 'Data Updated Successfully',
                    'status' => 'success'
                ]);
            } else {
                return $this->response->setJSON([
                    'code' => 400,
                    'status' => 'error',
                    'msg' => 'Data update failed.'
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
            $sub_id = $this->request->getPost('sub_id');

            if ($sub_id) {
                $query = "SELECT image_url FROM tbl_submenu WHERE `sub_id`  = ?";
                $SubemnuImg = $this->db->query($query, [$sub_id])->getRow();

                $imagePath = FCPATH . $SubemnuImg->image_url;

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $query = 'UPDATE `tbl_submenu` SET `flag`= 0 WHERE `sub_id` = ?';
            $updateData = $this->db->query($query, [$sub_id]);

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
        $submenu_id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        try {
            $updatequery = "UPDATE `tbl_submenu` SET `status` = ?   WHERE `sub_id` = ?";
            $updateStatus = $this->db->query($updatequery, [$status, $submenu_id]);

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