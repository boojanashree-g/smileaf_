<?php
namespace App\Controllers;

use Razorpay\Api\Api;
use Config\Razorpay as RazorpayConfig;

class RazorpayController extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }
    public function payment()
    {

        $previousURL = previous_url();
        $orderID = session()->get('order_id');
        $userID = session()->get('user_id');


        if (!$orderID || !$userID) {
            return redirect()->to('/')->with('error', 'Invalid session. Please try again.');
        }


        $sql = "SELECT
            a.`username`,
            a.`number`,
            a.`email`,
            b.total_amt,
            c.address
        FROM
            `tbl_users` AS a
        INNER JOIN tbl_orders AS b
        ON
            a.`user_id` = b.user_id
        INNER JOIN tbl_user_address AS c
        ON
            c.add_id = b.add_id
        WHERE
            a.`user_id` = ? AND a.`flag` = 1 AND b.`flag` = 1 AND b.order_id = ?";

        $userData = $this->db->query($sql, [$userID, $orderID])->getRow();

        if (!$userData) {

            return view('payment', ['error' => 'Order not found.']);
        }

        $key_id = $_ENV['RAZORPAY_KEY_ID'];
        $secret = $_ENV['RAZORPAY_KEY_SECRET'];

        $api = new Api($key_id, $secret);

        $amount = $userData->total_amt;
        $totalAmt = $amount * 100;


        $order = $api->order->create([
            'receipt' => 'ORD_' . $orderID . '_' . time(),
            'amount' => $totalAmt,
            'currency' => 'INR',
            'notes' => [
                'user_id' => $userID,
                'order_id' => $orderID,
                'username' => $userData->username,
                'email' => $userData->email,
                'number' => $userData->number
            ]
        ]);


        $customerData = [
            'name' => $userData->username,
            'email' => $userData->email,
            'number' => $userData->number,
            'user_id' => $userID,
            'order_id' => $orderID,
            'address' => $userData->address,

        ];

        return view("payment", ['customerdata' => $customerData, 'order' => $order, 'key_id' => $key_id, 'secret' => $secret, 'previous_url' => $previousURL]);
    }

    public function Success()
    {
        $successData = [
            'orderid' => session()->get('orderid'),
            'paymentid' => session()->get('paymentid'),
            'status' => session()->get('status'),
        ];

        // $successData = [
        //     'orderid' => 12345,
        //         //     'paymentid' => "pay_ueiru",
        //     'status' => "Success",
        // ];



        return view('success', $successData);

    }





}