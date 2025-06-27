<?php

namespace App\Controllers;
use App\Models\UserModel;


class MyaccountController extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }


    public function insertAccount()
    {
        $UserModel = new UserModel;
        $request = $this->request;
        $userID = $this->session->get('user_id');

        $userData = [
            'username' => $request->getPost('username'),
            'number' => $request->getPost('number'),
            'email' => $request->getPost('email'),
        ];

        $number = $request->getPost('number');



        $query = "SELECT COUNT(`user_id`) AS total_count FROM `tbl_users` WHERE `number` = ? AND `is_verified` = 1 AND `flag` =  1";
        $userDetails = $this->db->query($query, [$number])->getResultArray();



        // if ($userDetails[0]['total_count'] > 0) {
        //     return $this->response->setJSON([
        //         'code' => 400,
        //         'message' => 'This mobile number already registered'
        //     ]);
        // }
        $UserModel->update($userID, $userData);

        $affectedRows = $UserModel->db->affectedRows();

        if ($affectedRows > 0) {
            return $this->response->setJSON([
                'code' => 200,
                'message' => 'Account details updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'code' => 400,
                'message' => 'No changes were made.'
            ]);
        }
    }

    // Address Module  //

    public function getDist()
    {

        // $csrf = $this->request->getHeader('X-CSRF-TOKEN')->getValue();

        $db = \Config\Database::connect();
        $stateID = $this->request->getPost('state_id');

        $getData["response"] = $db->query("SELECT a.`state_title`, b.`dist_id`,b.`dist_name` FROM 
        tbl_state AS a INNER JOIN tbl_district AS b 
        ON a.state_id = b.state_id WHERE  a.`flag` = 1 AND b.state_id = $stateID;")->getResultArray();
        $getData['code'] = 200;
       
        echo "<pre>";
        print_r($getData['code'] );
        die;

        echo json_encode($getData);
    }


}