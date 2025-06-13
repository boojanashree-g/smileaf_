<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;

use App\Models\admin\FilterShapeModel;


class FilterShapeController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }


    public function filterShape()
    {
        $res['meta_title'] = "Filter Shapes";
        return view("admin/filter_shapes", $res);
    }

    public function insertData()
    {
        try {

            $shapeName = $this->request->getPost('shape_name');

            if ($shapeName) {

                $FilterShapeModel = new FilterShapeModel();

                $data = [
                    'shape_name' => $shapeName,
                ];

                $FilterShapeModel->insert($data);
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
        $res = $this->db->query("SELECT * FROM `tbl_filter_shapes` WHERE  `flag` = 1;")->getResultArray();
        echo json_encode($res);
    }


    public function updateData()
    {
        $shapeName = $this->request->getPost('shape_name');
        $shapeID = $this->request->getPost('shape_id');

        try {
            if (!empty($shapeID)) {
                $updateQuery = 'UPDATE tbl_filter_shapes SET `shape_name` = ?  WHERE `shape_id` = ?';
                $updateData = $this->db->query($updateQuery, [$shapeName, $shapeID]);

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
            $shape_id = $this->request->getPost('shape_id');

            $query = 'UPDATE `tbl_filter_shapes` SET `flag`= 0 WHERE `shape_id` = ?';
            $updateData = $this->db->query($query, [$shape_id]);

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
        $shape_id = $this->request->getPost('id');
        $status = $this->request->getPost('status');


        try {
            $updatequery = "UPDATE `tbl_filter_shapes` SET `status` = ?   WHERE `shape_id` = ?";
            $updateStatus = $this->db->query($updatequery, [$status, $shape_id]);

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