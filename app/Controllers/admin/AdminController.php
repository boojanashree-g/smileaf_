<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;


class AdminController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }
    public function login()
    {
        $res['meta_title'] = "Admin Login";

        if (session()->get('islogin')) {
            return redirect()->to(base_url('admin/dashboard'));
        }
        $response = service('response');
        $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $response->setHeader('Pragma', 'no-cache');
        return view("admin/login", $res);
    }

    public function checkLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $query = "SELECT * FROM `tbl_admin` WHERE flag = 1 AND BINARY `username` = ? AND BINARY `password` = ?";
        $checkData = $this->db->query($query, [$username, $password])->getResultArray();

        if (count($checkData) == 0) {
            $response = [
                'code' => 400,
                'message' => 'Invalid Username or Password',
                'status' => 'Failure'
            ];
            return $this->response->setJSON($response);
        } else {
            $username = $checkData[0]['username'];
            $usertype = $checkData[0]['user_type'];

            $sessionData = [
                'admin_name' => $username,
                'admin_type' => $usertype,
                'admin_login' => true
            ];

            $this->session->set($sessionData);

            

            $response = [
                'code' => 200,
                'message' => 'Logged in Successfully',
                'status' => "Success",
                'username' => $username,
                'usertype' => $usertype
            ];

        }
        return $this->response->setJSON($response);
    }

    public function dashboard()
    {
        $res['meta_title'] = "Dashboard";
        return view("admin/dashboard", $res);
    }

    public function logout()
    {
        $session = $this->session = \Config\Services::session();
        $session->destroy();
        return redirect()->to('admin/');
    }




}


