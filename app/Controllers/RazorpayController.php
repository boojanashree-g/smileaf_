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

        $paymentStatus = ['PENDING', 'COMPLETED', 'FAILED', 'CANCELLED'];
        // Check the orderID is already has rzporderID
        $orderQuery = "SELECT `order_id` 
                        FROM `tbl_orders` 
                        WHERE `order_id` = ?
                        AND (
                            (`razerpay_payment_id` IS NOT NULL AND `razerpay_payment_id` != '')
                            AND
                            (`razerpay_order_id` IS NOT NULL AND `razerpay_order_id` != '')
                            AND
                            (`razerpay_signature` IS NOT NULL AND `razerpay_signature` != '')
                        )";
        $checkOrder = $this->db->query($orderQuery, [$orderID])->getRow();
        $oldOrder = $checkOrder->order_id;

        if ($oldOrder != '') {
            return redirect()->to('myaccount');
        }


        if (session()->get('payment_status_' . $orderID)) {
            return redirect()->to('myaccount');
        }
        // Check the orderID is already has rzporderID




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
        session()->set('payment_attempted', true);
        session()->set('payment_status', 'success');
        session()->set('payment_redirect', 'success');

        return view('success');
    }

    public function paymentfail()
    {
        session()->set('payment_attempted', true);
        session()->set('payment_status', 'failed');
        session()->set('payment_redirect', 'payment-failed');

        return view('failed');

    }


    public function paymentcancel()
    {
        session()->set('payment_attempted', true);
        session()->set('payment_status', 'cancelled');
        session()->set('payment_redirect', 'cancel');

        $request = service('request');
        $data = $request->getGet();


        $orderId = $request->getGet('order_id');
        $reason = $request->getGet('reason') ?? 'User cancelled payment';
        $orderStatus = "Cancelled ";
        $paymentStatus = "CANCELLED";

        $deliveryStatus = "Cancel Modal";
        $deliveryConfig = new \Config\DeliveryMessages();
        $deliveryMsg = $deliveryConfig->messages[$deliveryStatus] ?? 'No message available';

        $updateOrderQry = "
        UPDATE `tbl_orders` 
        SET `payment_status` = ?, 
            `payment_cancel_reason` = ?,
             `delivery_message` = ?,
             `delivery_status` = ?, 
            `updated_at` = NOW(),
            `order_status` = ?
        WHERE `order_id` = ?
    ";
        $updateOrder = $this->db->query($updateOrderQry, [$paymentStatus, $reason, $deliveryMsg, $deliveryStatus, $orderStatus, $orderId]);

        $affectedRows = $this->db->affectedRows();

        if ($affectedRows) {
            return view('cancel', ['cancel_reason' => $reason]);
        } else {
            return view('cancel', ['cancel_reason' => 'Could not update cancellation status.']);
        }
    }

    public function webhookPaymentStatus()
    {

        $payload = file_get_contents("php://input");

        $signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';
        $webhookSecret = getenv('RAZORPAY_WEBHOOK_SECRET_TEST');


        // Verify signature
        $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
        if (!hash_equals($expectedSignature, $signature)) {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Invalid signature']);
        }

        $data = json_decode($payload, true);

        $event = $data['event'];

        $payment = $data['payload']['payment']['entity'];

        // For Filure
        $reason = $payment['error_reason'] ?? '';
        $code = $payment['error_code'] ?? '';
        $description = $payment['error_description'] ?? '';

        $razorpay_payment_id = $payment['id'];
        $razorpay_order_id = $payment['order_id'];
        $payment_status = $payment['status'];

        $orderid = $payment['notes']['order_id'] ?? null;
        $notes = $payment['notes'];

        if (!$orderid) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Order ID missing in notes']);
        }
        if ($event === 'payment.captured') {

            $payment_method = $payment['method'];

            // User Details from Notes:
            $userID = $notes['user_id'];
            $orderID = $orderid;
            $username = $notes['username'];
            $type = $notes['type'];

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

            $users = $this->db->query('SELECT `number` ,`username` FROM `tbl_users` WHERE `flag` = 1 AND `user_id` = ?', [$userID])->getRow();
            $number = $users->number;
            $username = $users->username;

            $order = $this->db->query("SELECT order_status ,order_no FROM `tbl_orders` WHERE `order_id` =  ?", [$orderID])->getRow();
            $orderNo = $order->order_no;


            if ($orderstatus == 'New') {
                $apiKey = $_ENV['SMS_API_KEY'];
                $templateName = $_ENV['ORDER_DELIVERED'];
                $response = $this->orderPlacedAPI($apiKey, $number, $username, $templateName, $orderNo);
            }


            $orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,delivery_message = ?,delivery_status = ?,payment_status = ?,payment_method = ? WHERE order_id = ?";
            $updateData = $this->db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $signature, $orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $payment_method, $orderID]);

            $OrderaffectedRows = $this->db->affectedRows();

            if ($OrderaffectedRows == 1) {
                $result['code'] = 200;
                $result['status'] = 'success';
                $result['message'] = "Orders updated successfully";
            } else {
                $result['code'] = 400;
                $result['status'] = 'failure';
                $result['message'] = "Orders updated failed";
            }
            echo json_encode($result);
        } elseif ($event === 'payment.failed') {
            $payment_status = "FAILED";
            $order_status = "Failed";

            $deliveryStatus = "Null";
            $deliveryConfig = new \Config\DeliveryMessages();
            $deliveryMsg = $deliveryConfig->messages[$deliveryStatus] ?? 'No message available';

            $updateOrderQry = "UPDATE `tbl_orders` SET  razerpay_payment_id = ? , razerpay_order_id =? , razerpay_signature = ? ,delivery_message = ?,delivery_status = ? ,`payment_status` = ? , `payment_cancel_reason` =? ,`order_status` = ? WHERE order_id = ?";
            $updateData = $this->db->query($updateOrderQry, [$razorpay_payment_id, $razorpay_order_id, $signature, $deliveryMsg, $deliveryStatus, $payment_status, $reason, $order_status, $orderid]);
            return $this->response->setStatusCode(400)->setJSON(['message' => $reason]);

        } elseif ($event === 'payment.authorized') {
            $Orderstatus = 'Pending';

            $deliveryStatus = "Order Pending";
            $deliveryConfig = new \Config\DeliveryMessages();
            $deliveryMsg = $deliveryConfig->messages[$deliveryStatus] ?? 'No message available';

            $payment_status = 'PENDING';
            $orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,
						 delivery_message = ?,delivery_status = ?,payment_status = ? WHERE order_id = ?";
            $updateData = $this->db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $signature, $Orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $orderid]);
        }
    }

    private function orderPlacedAPI($apiKey, $number, $username, $templateName, $orderNo)
    {
        $from = 'SMLEFO';

        $userName = str_replace(' ', '', ucwords(strtolower(trim($username))));

        $msg = "Hi $userName, We've received your order $orderNo. We'll notify you once it's packed and ready to ship. Thank you for shopping with us!- Smileaf";

        $peid = $_ENV['PE_ID'];
        $ctid = $_ENV['ORDERNEW_CT_ID'];

        $client = \Config\Services::curlrequest();
        $url = 'https://2factor.in/API/R1/';

        try {
            $response = $client->request('POST', $url, [
                'form_params' => [
                    'module' => 'TRANS_SMS',
                    'apikey' => $apiKey,
                    'to' => $number,
                    'from' => $from,
                    'msg' => $msg,
                    'peid' => $peid,
                    'ctid' => $ctid
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);

            $result = json_decode($response->getBody(), true);


            return $result;

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }


    public function checkPaymentStatus()
    {
        $orderId = $this->request->getGet('order_id');

        $paymentData = $this->db->query('SELECT * FROM `tbl_orders` WHERE `order_id` = ?', [$orderId])->getRow();

        if ($paymentData && $paymentData->payment_status === 'COMPLETED') {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'pending']);
        }
    }

    // Handling Payment status from Frontend
    // public function paymentstatus()
    // {
    //     $data = $this->request->getPost();

    //     $razorpay_payment_id = $this->request->getPost('razorpay_payment_id');
    //     $razorpay_order_id = $this->request->getPost('razorpay_order_id');
    //     $razorpay_signature = $this->request->getPost('razorpay_signature');


    //     $secret = $_ENV['RAZORPAY_KEY_SECRET'];
    //     $api = new Api($_ENV['RAZORPAY_KEY_ID'], $secret);

    //     $data = $razorpay_order_id . "|" . $razorpay_payment_id;


    //     $generated_signature = hash_hmac("sha256", $data, $secret);
    //     // to get payment method
    //     $payment = $api->payment->fetch($razorpay_payment_id);

    //     $razerpay_paystatus = $payment->status;

    //     if ($razerpay_paystatus == "captured") {
    //         if ($generated_signature == $razorpay_signature) {
    //             $payment_method = $payment->method;


    //             $orderDetails = $this->fetchOrderDetails($razorpay_order_id, $secret);

    //             $userID = $orderDetails['notes']['user_id'];
    //             $orderID = $orderDetails['notes']['order_id'];
    //             $username = $orderDetails['notes']['username'];
    //             $type = $orderDetails['notes']['type'];

    //             $sess = [
    //                 'user_id' => $userID,
    //                 'username' => $username,
    //                 'loginStatus' => "YES",
    //                 'otp_verify' => "YES"
    //             ];
    //             $this->session->set($sess);


    //             // Delete Products from cart 
    //             $getCartqry = "SELECT * FROM `tbl_user_cart` WHERE `user_id` =  ? AND flag = 1 AND  source_type = ?";
    //             $cartData = $this->db->query($getCartqry, [$userID, $type])->getResultArray();



    //             foreach ($cartData as $cartItem) {
    //                 $prodID = $cartItem['prod_id'];
    //                 $cartID = $cartItem['cart_id'];
    //                 $dltcart = "DELETE FROM tbl_user_cart WHERE cart_id = ? AND prod_id = ?";
    //                 $dltRes = $this->db->query($dltcart, [$cartID, $prodID]);
    //             }


    //             $itemList = $this->db->query("SELECT * FROM `tbl_order_item` WHERE `order_id` = ? AND `flag` = 1", [$orderID])->getResultArray();
    //             foreach ($itemList as $items) {
    //                 $prodID = $items['prod_id'];
    //                 $variantID = $items['variant_id'];
    //                 $checkoutQty = $items['quantity'];

    //                 // Main Product Table 
    //                 $mainProdQry = "SELECT `main_quantity` FROM `tbl_products` WHERE `flag` = 1 AND `prod_id` = ?";
    //                 $mainProd = $this->db->query($mainProdQry, [$prodID])->getRow();

    //                 $oldMainQty = $mainProd ? $mainProd->main_quantity : 0;


    //                 // Variant Table 
    //                 $variantQry = "SELECT `quantity` FROM `tbl_variants` WHERE `flag` = 1 AND `variant_id` = ? AND `prod_id` = ?";
    //                 $variant = $this->db->query($variantQry, [$variantID, $prodID])->getRow();

    //                 $oldVariantQty = $variant ? $variant->quantity : 0;
    //                 $newVariantQty = $oldVariantQty - $checkoutQty;


    //                 $newMainQty = $oldMainQty - $checkoutQty;

    //                 // Prevent negative values
    //                 $newVariantQty = ($newVariantQty <= 0) ? 0 : $newVariantQty;
    //                 $newMainQty = ($newMainQty < 0) ? 0 : $newMainQty;
    //                 $newVariantStatus = ($newVariantQty <= 0) ? '0' : '1';


    //                 $this->db->query("UPDATE `tbl_variants` SET `quantity` = ?, `stock_status` =?  WHERE `variant_id` = ? AND `prod_id` = ?", [
    //                     $newVariantQty,
    //                     $newVariantStatus,
    //                     $variantID,
    //                     $prodID
    //                 ]);


    //                 $this->db->query("UPDATE `tbl_products` SET `main_quantity` = ? WHERE `prod_id` = ?", [
    //                     $newMainQty,
    //                     $prodID
    //                 ]);
    //             }

    //             // Updating Order Status
    //             $deliveryStatus = 'New';
    //             $deliveryConfig = new \Config\DeliveryMessages();
    //             $deliveryMsg = $deliveryConfig->messages[$deliveryStatus] ?? 'No message available';
    //             $payment_status = "COMPLETED";
    //             $orderstatus = "New";


    //             $orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,delivery_message = ?,delivery_status = ?,payment_status = ?,payment_method = ? WHERE order_id = ?";
    //             $updateData = $this->db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $razorpay_signature, $orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $payment_method, $orderID]);

    //             $OrderaffectedRows = $this->db->affectedRows();

    //             if ($OrderaffectedRows == 1) {
    //                 $successData = [
    //                     'orderid' => $razorpay_order_id,
    //                     'paymentid' => $razorpay_payment_id,
    //                     'status' => "Completed",
    //                 ];
    //                 session()->set($successData);

    //                 $result['code'] = 200;
    //                 $result['status'] = 'success';
    //                 $result['message'] = "Orders updated successfully";

    //                 return $this->response->setJSON($result);
    //             } else {
    //                 echo "error";
    //             }
    //         }


    //     } else if ($razerpay_paystatus == "pending") {

    //         $Orderstatus = 'Pending';
    //         $razorpay_signature = "NULL";

    //         // Updating razerpay order id ,payment id ,paymentstatus 
    //         $orderID = session()->get('order_id');
    //         $deliveryStatus = "Order Pending";
    //         $deliveryConfig = new \Config\DeliveryMessages();
    //         $deliveryMsg = $deliveryConfig->messages[$deliveryStatus] ?? 'No message available';

    //         $payment_status = 'PENDING';
    //         $orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,
    // 					 delivery_message = ?,delivery_status = ?,payment_status = ? WHERE order_id = ?";
    //         $updateData = $this->db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $razorpay_signature, $Orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $orderID]);
    //     }

    // }
    // public function fetchOrderDetails($razorpay_order_id, $secret)
    // {
    //     $key_id = $_ENV['RAZORPAY_KEY_ID'];

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders/' . $razorpay_order_id);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    //     curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $secret);

    //     $result = curl_exec($ch);
    //     if (curl_errno($ch)) {
    //         echo 'Error:' . curl_error($ch);
    //     }
    //     curl_close($ch);

    //     return json_decode($result, true);
    // }









}