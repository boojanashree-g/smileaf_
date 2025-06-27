<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;

use App\Models\UserModel;


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
        $res['users'] = $this->db->query("SELECT * FROM `tbl_users` WHERE flag = 1")->getResultArray();
        return view("admin/customer_details", $res);
    }

    private function decode($encodedId){
        return base64_decode($encodedId); 
    }

    public function insertData()
    {
        $UserModel = new \App\Models\UserModel();
        $request = $this->request;

        $userID = $this->decode($this->session->get('user_id'));
        $username = $request->getPost('customer_name');
        $number   = $request->getPost('customer_mobile');
        $email    = $request->getPost('customer_email');

        $existing = $this->db->query(
            "SELECT user_id FROM tbl_users WHERE number = ? AND flag = 1 LIMIT 1",
            [$number]
        )->getRowArray();

        $userData = [
            'username'    => $username,
            'number'      => $number,
            'email'       => $email,
            'is_verified' => 1,
            'flag'        => 1,
        ];

        if ($existing) {
            $UserModel->update($existing['user_id'], $userData);

            return $this->response->setJSON([
                'code'    => 200,
                'message' => 'User with same number found. Updated successfully.',
            ]);
        } else {
            if ($UserModel->insert($userData)) {
                return $this->response->setJSON([
                    'code'    => 201,
                    'message' => 'New user created successfully.',
                ]);
            } else {
                return $this->response->setJSON([
                    'code'    => 500,
                    'message' => 'Insert failed.',
                    'errors'  => $UserModel->errors(),
                ]);
            }
        }
    }

    public function getData()
    {
        $res['users'] = $this->db->query("SELECT * FROM `tbl_users` WHERE flag = 1")->getResultArray();
        echo json_encode($res);
    }

  public function deleteData()
{
    try {
        $request = $this->request;

        // Get user_id from POST data
        $user_id = $request->getPost('user_id');

        if (empty($user_id)) {
            return $this->response->setJSON([
                'code' => 400,
                'status' => 'failure',
                'message' => 'User ID is required.'
            ]);
        }

        // Update flag only if not already deleted
        $query = 'UPDATE `tbl_users` SET `flag` = 0 WHERE `user_id` = ? AND `flag` != 0';
        $updateData = $this->db->query($query, [$user_id]);

        $affected_rows = $this->db->affectedRows();

        if ($affected_rows > 0) {
            return $this->response->setJSON([
                'code'    => 200,
                'status'  => 'success',
                'message' => 'Deleted successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'code'    => 400,
                'status'  => 'failure',
                'message' => 'User already deleted or not found.'
            ]);
        }
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'code'    => 500,
            'status'  => 'error',
            'message' => 'Server Error: ' . $e->getMessage()
        ]);
    }
}


   public function updateData()
{
    $UserModel = new \App\Models\UserModel();
    $request = $this->request;

    $user_id = $request->getPost('user_id');
    $username = $request->getPost('customer_name');
    $number   = $request->getPost('customer_mobile');
    $email    = $request->getPost('customer_email');
    $isVerified = $request->getPost('is_verified') == '1' ? 1 : 0;


    // Check if user exists and is not soft-deleted
    $existing = $this->db->query(
        "SELECT user_id FROM tbl_users WHERE user_id = ? AND flag = 1 LIMIT 1",
        [$user_id]
    )->getRowArray();

    if (!$existing) {
        return $this->response->setJSON([
            'code'    => 404,
            'message' => 'User not found or already deleted.',
        ]);
    }

    $userData = [
        'username' => $username,
        'number'   => $number,
        'email'    => $email,
        'is_verified' => $isVerified,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($UserModel->update($user_id, $userData)) {
        return $this->response->setJSON([
            'code'    => 200,
            'message' => 'User updated successfully.',
        ]);
    } else {
        return $this->response->setJSON([
            'code'    => 500,
            'message' => 'Update failed.',
            'errors'  => $UserModel->errors(),
        ]);
    }
}


}