<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;

use App\Models\admin\FilterSizeModel;


class FilterSizeController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }


    public function filterSize()
    {
        $res['meta_title'] = "Filter Size";
        return view("admin/filter_size", $res);
    }

    public function insertData()
    {
        try {

            $sizeName = $this->request->getPost('size_name');

            if ($sizeName) {

                $FilterSizeModel = new FilterSizeModel();

                $data = [
                    'size_name' => $sizeName,
                ];

                $FilterSizeModel->insert($data);
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
        $res = $this->db->query("SELECT * FROM `tbl_filter_size` WHERE  `flag` = 1;")->getResultArray();
        echo json_encode($res);
    }


    public function updateData()
    {
        $sizeName = $this->request->getPost('size_name');
        $sizeID = $this->request->getPost('size_id');

        try {
            if (!empty($sizeID)) {
                $updateQuery = 'UPDATE tbl_filter_size SET `size_name` = ?  WHERE `size_id` = ?';
                $updateData = $this->db->query($updateQuery, [$sizeName, $sizeID]);

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
                    'msg' => 'Invalid Data',
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
            $size_id = $this->request->getPost('size_id');

            $query = 'UPDATE `tbl_filter_size` SET `flag`= 0 WHERE `size_id` = ?';
            $updateData = $this->db->query($query, [$size_id]);

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
        $size_id = $this->request->getPost('id');
        $status = $this->request->getPost('status');


        try {
            $updatequery = "UPDATE `tbl_filter_size` SET `status` = ?   WHERE `size_id` = ?";
            $updateStatus = $this->db->query($updatequery, [$status, $size_id]);

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