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

        if (session()->get('admin_login')) {
            return redirect()->to('admin/dashboard');
        }

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
        $res['neworder_count'] = $this->newOrderCount();
        $res['shipping_count'] = $this->shippingOrderCount();
        $res['delivered_count'] = $this->deliverOrderCount();
        $res['pending_count'] = $this->pendingOrderCount();
        $res['cancel_count'] = $this->cancelOrderCount();
        $res['refund_count'] = $this->refundOrderCount();
        $res['failed_count'] = $this->failedOrderCount();
        $res['returned_count'] = $this->returnedOrderCount();

        return view("admin/dashboard", $res);
    }

    public function logout()
    {
        $session = $this->session = \Config\Services::session();
        $session->remove(['admin_login', 'admin_type', 'admin_name']);
        return redirect()->to('admin/');
    }

    private function newOrderCount()
    {
        $orderStatus = "new";
        $resultData = $this->db->query("SELECT COUNT(`order_id`) AS neworder FROM `tbl_orders` WHERE `flag` = 1 AND `order_status` = ?", [$orderStatus])->getRow();
        $newOrderCount = $resultData->neworder;
        return $newOrderCount;
    }
    private function shippingOrderCount()
    {
        $orderStatus = "Shipped";
        $resultData = $this->db->query("SELECT COUNT(`order_id`) AS Shipped FROM `tbl_orders` WHERE `flag` = 1 AND `order_status` = ?", [$orderStatus])->getRow();
        $shippedOrderCount = $resultData->Shipped;
        return $shippedOrderCount;
    }
    private function deliverOrderCount()
    {
        $orderStatus = "Delivered";
        $resultData = $this->db->query("SELECT COUNT(`order_id`) AS Delivered FROM `tbl_orders` WHERE `flag` = 1 AND `order_status` = ?", [$orderStatus])->getRow();
        $DeliveredOrderCount = $resultData->Delivered;
        return $DeliveredOrderCount;
    }

    private function pendingOrderCount()
    {
        $orderStatus = "Pending";
        $resultData = $this->db->query("SELECT COUNT(`order_id`) AS Pending  FROM `tbl_orders` WHERE `flag` = 1 AND `order_status` = ?", [$orderStatus])->getRow();
        $PendingOrderCount = $resultData->Pending;
        return $PendingOrderCount;
    }
    private function cancelOrderCount()
    {
        $orderStatus = "Cancelled";
        $resultData = $this->db->query("SELECT COUNT(`order_id`) AS Cancelled  FROM `tbl_orders` WHERE `flag` = 1 AND `order_status` = ?", [$orderStatus])->getRow();
        $CancelledOrderCount = $resultData->Cancelled;
        return $CancelledOrderCount;
    }
    private function refundOrderCount()
    {
        $orderStatus = "Refund";
        $resultData = $this->db->query("SELECT COUNT(`order_id`) AS Refund   FROM `tbl_orders` WHERE `flag` = 1 AND `order_status` = ?", [$orderStatus])->getRow();
        $RefundOrderCount = $resultData->Refund;
        return $RefundOrderCount;
    }
    private function failedOrderCount()
    {
        $orderStatus = "Failed";
        $resultData = $this->db->query("SELECT COUNT(`order_id`) AS Failed   FROM `tbl_orders` WHERE `flag` = 1 AND `order_status` = ?", [$orderStatus])->getRow();
        $FailedOrderCount = $resultData->Failed;
        return $FailedOrderCount;
    }
    private function returnedOrderCount()
    {
        $orderStatus = "Returned";
        $resultData = $this->db->query("SELECT COUNT(`order_id`) AS Returned   FROM `tbl_orders` WHERE `flag` = 1 AND  is_returned = 1 AND `order_status` = ?", [$orderStatus])->getRow();
        $ReturnedOrderCount = $resultData->Returned;
        return $ReturnedOrderCount;
    }
}


