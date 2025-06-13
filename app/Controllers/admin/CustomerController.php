<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;

use App\Models\admin\BannerModel;


class CustomerController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }


    public function customerDetails()
    {
        $res['meta_title'] = "Customer Details";
        return view("admin/customer_details", $res);
    }

    public function insertData()
    {

        try {
            $bannerImg = $this->request->getFile('banner_image');

            if ($bannerImg && $bannerImg->isValid()) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                if (in_array($bannerImg->getMimeType(), $allowedTypes)) {
                    $randomName = $bannerImg->getRandomName();
                    $bannerImg->move('./uploads/', $randomName);

                    $data = [
                        'banner_image' => '/uploads/' . $randomName,
                        'banner_title' => $this->request->getPost('banner_title'),
                        'banner_desc1' => $this->request->getPost('banner_desc1'),
                        'banner_desc2' => $this->request->getPost('banner_desc2'),
                        'banner_link' => $this->request->getPost('banner_link'),
                    ];

                    $bannerModel = new BannerModel();
                    $bannerModel->insert($data);

                    if ($this->db->affectedRows() == 1) {
                        return $this->response->setJSON([
                            'code' => 200,
                            'msg' => 'Data Inserted Successfully',
                            'status' => 'success'
                        ]);
                    }
                } else {
                    // Return error if file type is not allowed
                    return $this->response->setJSON([
                        'code' => 400,
                        'msg' => 'Invalid file type. Only PNG, JPG, and JPEG are allowed.',
                        'status' => 'error'
                    ]);
                }
            }


            return $this->response->setJSON([
                'code' => 400,
                'status' => 'Failed',
                'msg' => 'Invalid file or insertion failed'
            ]);

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
        $res = $this->db->query("SELECT * FROM tbl_banner WHERE flag = 1")->getResultArray();
        echo json_encode($res);
    }

    public function deleteData()
    {

        try {
            $banner_id = $this->request->getPost('banner_id');

            if ($banner_id) {
                $query = "SELECT banner_image FROM tbl_banner WHERE `banner_id`  = ?";
                $bannerImg = $this->db->query($query, [$banner_id])->getRow();

                $imagePath = FCPATH . $bannerImg->banner_image;

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }


            $query = 'UPDATE `tbl_banner` SET `flag`= 0 WHERE `banner_id` = ?';
            $updateData = $this->db->query($query, [$banner_id]);

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

    public function updateData()
    {
        try {
            $bannerModel = new BannerModel();
            $bannerID = $this->request->getPost('banner_id');
            $bannerImg = $this->request->getFile('banner_image');
            $data = $this->request->getPost();

            if ($bannerImg && $bannerImg->isValid() && !$bannerImg->hasMoved()) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                if (in_array($bannerImg->getMimeType(), $allowedTypes)) {
                    $query = "SELECT banner_image FROM tbl_banner WHERE banner_id = ?";
                    $oldImg = $this->db->query($query, [$bannerID])->getRow();

                    if ($oldImg && !empty($oldImg->banner_image)) {
                        $imagePath = FCPATH . $oldImg->banner_image;

                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }

                    $randomName = $bannerImg->getRandomName();
                    $bannerImg->move(FCPATH . 'uploads/', $randomName);
                    $data['banner_image'] = 'uploads/' . $randomName;

                } else {
                    return $this->response->setJSON([
                        'code' => 400,
                        'msg' => 'Invalid image type. Allowed types: JPEG, PNG.',
                        'status' => 'failure'
                    ]);
                }
            }

            $bannerModel->update($bannerID, $data);
            $affectedRows = $this->db->affectedRows();

            if ($affectedRows >= 0) {
                return $this->response->setJSON([
                    'code' => 200,
                    'msg' => 'Data updated successfully',
                    'status' => 'success'
                ]);
            } else {
                return $this->response->setJSON([
                    'code' => 400,
                    'msg' => 'No changes were made.',
                    'status' => 'failure'
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


}