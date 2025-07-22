<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;

use App\Models\admin\FilterTypeModel;


class FilterTypeController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }


    public function filterType()
    {
        $res['meta_title'] = "Product Types";
        return view("admin/filter_type", $res);
    }

    public function insertData()
    {

        try {

            $typeName = $this->request->getPost('type_name');


            if ($typeName) {

                $FilterTypeModel = new FilterTypeModel();

                $data = [
                    'type_name' => $typeName,
                ];

                $FilterTypeModel->insert($data);
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
        $res = $this->db->query("SELECT * FROM `tbl_filter_type` WHERE  `flag` = 1;")->getResultArray();
        echo json_encode($res);
    }


    public function updateData()
    {
        $typeName = $this->request->getPost('type_name');
        $typeID = $this->request->getPost('type_id');

        try {
            if (!empty($typeID)) {
                $updateQuery = 'UPDATE tbl_filter_type SET `type_name` = ?  WHERE `type_id` = ?';
                $updateData = $this->db->query($updateQuery, [$typeName, $typeID]);

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
            $type_id = $this->request->getPost('type_id');

            $query = 'UPDATE `tbl_filter_type` SET `flag`= 0 WHERE `type_id` = ?';
            $updateData = $this->db->query($query, [$type_id]);

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
        $type_id = $this->request->getPost('id');
        $status = $this->request->getPost('status');


        try {
            $updatequery = "UPDATE `tbl_filter_type` SET `type_status` = ?   WHERE `type_id` = ?";
            $updateStatus = $this->db->query($updatequery, [$status, $type_id]);

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