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
        $type = $this->request->getGet('type');

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
                'number' => $userData->number,
                'type' => $type
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

        return view("payment", ['customerdata' => $customerData, 'order' => $order, 'key_id' => $key_id, 'secret' => $secret, 'previous_url' => $previousURL, 'cancel_orderid' => $orderID]);
    }

    public function Success()
    {
        return view('success');
    }

    public function paymentfail()
    {
        return view('failed');

    }


    public function paymentcancel()
    {
        $request = service('request');
        $data = $request->getGet();

        $orderId = $request->getGet('order_id');
        $reason = $request->getGet('reason') ?? 'User cancelled payment';
        $orderStatus = "Cancelled ";
        $paymentStatus = "CANCELLED";

        $updateOrderQry = "
        UPDATE `tbl_orders` 
        SET `payment_status` = ?, 
            `payment_cancel_reason` = ?, 
            `updated_at` = NOW(),
            `order_status` = ?
        WHERE `order_id` = ?
    ";
        $updateOrder = $this->db->query($updateOrderQry, [$paymentStatus, $reason, $orderStatus, $orderId]);

        $affectedRows = $this->db->affectedRows();

        if ($affectedRows) {
            return view('cancel', ['cancel_reason' => $reason]);
        } else {
            return view('cancel', ['cancel_reason' => 'Could not update cancellation status.']);
        }
    }

    public function paymentstatus()
    {
        $data = $this->request->getPost();

        $razorpay_payment_id = $this->request->getPost('razorpay_payment_id');
        $razorpay_order_id = $this->request->getPost('razorpay_order_id');
        $razorpay_signature = $this->request->getPost('razorpay_signature');


        $secret = $_ENV['RAZORPAY_KEY_SECRET'];
        $api = new Api($_ENV['RAZORPAY_KEY_ID'], $secret);

        $data = $razorpay_order_id . "|" . $razorpay_payment_id;


        $generated_signature = hash_hmac("sha256", $data, $secret);
        // to get payment method
        $payment = $api->payment->fetch($razorpay_payment_id);

        $razerpay_paystatus = $payment->status;

        if ($razerpay_paystatus == "captured") {
            if ($generated_signature == $razorpay_signature) {
                $payment_method = $payment->method;


                $orderDetails = $this->fetchOrderDetails($razorpay_order_id, $secret);

                $userID = $orderDetails['notes']['user_id'];
                $orderID = $orderDetails['notes']['order_id'];
                $username = $orderDetails['notes']['username'];
                $type = $orderDetails['notes']['type'];

                $sess = [
                    'user_id' => $userID,
                    'username' => $username,
                    'loginStatus' => "YES",
                    'otp_verify' => "YES"
                ];
                $this->session->set($sess);


                // Delete Products from cart 
                $getCartqry = "SELECT * FROM `tbl_user_cart` WHERE `user_id` =  ? AND flag = 1 AND  source_type = ?";
                $cartData = $this->db->query($getCartqry, [$userID, $type])->getResultArray();



                foreach ($cartData as $cartItem) {
                    $prodID = $cartItem['prod_id'];
                    $cartID = $cartItem['cart_id'];
                    $dltcart = "DELETE FROM tbl_user_cart WHERE cart_id = ? AND prod_id = ?";
                    $dltRes = $this->db->query($dltcart, [$cartID, $prodID]);
                }


                $itemList = $this->db->query("SELECT * FROM `tbl_order_item` WHERE `order_id` = ? AND `flag` = 1", [$orderID])->getResultArray();
                foreach ($itemList as $items) {
                    $prodID = $items['prod_id'];
                    $variantID = $items['variant_id'];
                    $checkoutQty = $items['quantity'];

                    // Main Product Table 
                    $mainProdQry = "SELECT `main_quantity` FROM `tbl_products` WHERE `flag` = 1 AND `prod_id` = ?";
                    $mainProd = $this->db->query($mainProdQry, [$prodID])->getRow();

                    $oldMainQty = $mainProd ? $mainProd->main_quantity : 0;


                    // Variant Table 
                    $variantQry = "SELECT `quantity` FROM `tbl_variants` WHERE `flag` = 1 AND `variant_id` = ? AND `prod_id` = ?";
                    $variant = $this->db->query($variantQry, [$variantID, $prodID])->getRow();

                    $oldVariantQty = $variant ? $variant->quantity : 0;
                    $newVariantQty = $oldVariantQty - $checkoutQty;


                    $newMainQty = $oldMainQty - $checkoutQty;

                    // Prevent negative values
                    $newVariantQty = ($newVariantQty <= 0) ? 0 : $newVariantQty;
                    $newMainQty = ($newMainQty < 0) ? 0 : $newMainQty;
                    $newVariantStatus = ($newVariantQty <= 0) ? '0' : '1';


                    $this->db->query("UPDATE `tbl_variants` SET `quantity` = ?, `stock_status` =?  WHERE `variant_id` = ? AND `prod_id` = ?", [
                        $newVariantQty,
                        $newVariantStatus,
                        $variantID,
                        $prodID
                    ]);


                    $this->db->query("UPDATE `tbl_products` SET `main_quantity` = ? WHERE `prod_id` = ?", [
                        $newMainQty,
                        $prodID
                    ]);
                }

                // Updating Order Status
                $deliveryStatus = 'New';
                $deliveryConfig = new \Config\DeliveryMessages();
                $deliveryMsg = $deliveryConfig->messages[$deliveryStatus] ?? 'No message available';
                $payment_status = "COMPLETED";
                $orderstatus = "New";


                $orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,delivery_message = ?,delivery_status = ?,payment_status = ?,payment_method = ? WHERE order_id = ?";
                $updateData = $this->db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $razorpay_signature, $orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $payment_method, $orderID]);

                $OrderaffectedRows = $this->db->affectedRows();

                if ($OrderaffectedRows == 1) {
                    $successData = [
                        'orderid' => $razorpay_order_id,
                        'paymentid' => $razorpay_payment_id,
                        'status' => "Completed",
                    ];
                    session()->set($successData);

                    $result['code'] = 200;
                    $result['status'] = 'success';
                    $result['message'] = "Orders updated successfully";

                    return $this->response->setJSON($result);
                } else {
                    echo "error";
                }
            }


        } else if ($razerpay_paystatus == "pending") {

            $Orderstatus = 'Pending';
            $razorpay_signature = "NULL";

            // Updating razerpay order id ,payment id ,paymentstatus 
            $orderID = session()->get('order_id');
            $deliveryStatus = "Order Pending";
            $deliveryConfig = new \Config\DeliveryMessages();
            $deliveryMsg = $deliveryConfig->messages[$deliveryStatus] ?? 'No message available';

            $payment_status = 'PENDING';
            $orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,
						 delivery_message = ?,delivery_status = ?,payment_status = ? WHERE order_id = ?";
            $updateData = $this->db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $razorpay_signature, $Orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $orderID]);
        }

    }

    public function webhookPaymentStatus()
    {

        $payload = file_get_contents("php://input");
        $signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';
        $webhookSecret = getenv('RAZORPAY_WEBHOOK_SECRET_TEST');

        echo "<pre>";
        print_r($webhookSecret);
        die;

        // Verify signature
        $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
        if (!hash_equals($expectedSignature, $signature)) {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Invalid signature']);
        }

        $data = json_decode($payload, true);
        $event = $data['event'];
        $payment = $data['payload']['payment']['entity'];

        $razorpay_payment_id = $payment['id'];
        $razorpay_order_id = $payment['order_id'];
        $payment_status = $payment['status'];

        // Fetch order_id from notes
        $orderID = $payment['notes']['order_id'] ?? null;



        if (!$orderID) {
            return $this->fail('Order ID missing in notes');
        }

        // Status handling
        if ($payment_status === 'captured') {
            // Update order to success
            $this->db->query("UPDATE tbl_orders SET payment_status = 'COMPLETED', order_status = 'New', delivery_status = 'New', razorpay_payment_id = ?, razorpay_order_id = ?, payment_method = ? WHERE order_id = ?", [
                $razorpay_payment_id,
                $razorpay_order_id,
                $payment['method'],
                $orderID
            ]);
        } elseif ($payment_status === 'failed') {
            // Update order to failed
            $this->db->query("UPDATE tbl_orders SET payment_status = 'FAILED', order_status = 'Failed', razorpay_payment_id = ?, razorpay_order_id = ? WHERE order_id = ?", [
                $razorpay_payment_id,
                $razorpay_order_id,
                $orderID
            ]);
        }

    }

    public function fetchOrderDetails($razorpay_order_id, $secret)
    {
        $key_id = $_ENV['RAZORPAY_KEY_ID'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders/' . $razorpay_order_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $secret);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return json_decode($result, true);
    }









}