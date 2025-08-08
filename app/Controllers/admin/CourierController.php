<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\admin\CourierModel;


class CourierController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    public function courierCharge()
    {
        $res['meta_title'] = "Delivery Offers";
        return view('admin/courier_charge', $res);
    }

    public function insertData()
    {
        $courierModel = new CourierModel;
        $data = $this->request->getPost();
        $offer_amount = $this->request->getPost('offer_amount');

        // Check Old Data 
        $oldData = $this->db->query("SELECT * FROM `tbl_delivery_offer` WHERE `flag` = 1 ")->getResultArray();
        $oldID = $oldData[0]['delivery_id'];


        if (count($oldData) > 0) {
            $query = 'UPDATE `tbl_delivery_offer` SET `flag`= 0 WHERE delivery_id = ?';
            $updateData = $this->db->query($query, [$oldID]);
        }



        $res = $courierModel->insert([
            'offer_amount' => $offer_amount
        ]);
        $affectedRows = $this->db->affectedRows();

        if ($affectedRows == 1) {
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

    public function getData()
    {
        $res = $this->db->query("SELECT * FROM tbl_delivery_offer WHERE flag = 1")->getResultArray();
        echo json_encode($res);
    }

    public function updateData()
    {
        $data = $this->request->getPost();

        $offer_amount = $this->request->getPost('offer_amount');
        $delivery_id = $this->request->getPost('delivery_id');
        $updateQry = "UPDATE tbl_delivery_offer SET offer_amount = ? WHERE delivery_id = ?";
        $updateData = $this->db->query($updateQry, [$offer_amount, $delivery_id]);

        $affectedRows = $this->db->affectedRows();

        if ($affectedRows == 1) {
            return $this->response->setJSON([
                'code' => 200,
                'msg' => 'Data updated successfully',
                'status' => 'success'
            ]);

        } else {
            return $this->response->setJSON([
                'code' => 400,
                'status' => 'Failed',
                'msg' => 'Data updated failed'
            ]);
        }
    }

    public function deleteData()
    {
        $delivery_id = $this->request->getPost('delivery_id');


        $query = 'UPDATE `tbl_delivery_offer` SET `flag`= 0 WHERE `delivery_id` = ?';
        $updateData = $this->db->query($query, [$delivery_id]);

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
    }
}