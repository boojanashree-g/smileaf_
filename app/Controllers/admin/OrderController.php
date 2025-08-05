<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class OrderController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    public function orderDetails()
    {
        $orderStatus = $this->request->getGet('status');
        $res['order_status'] = $orderStatus;
        $res['order_status_enum'] = $this->getOrderStatusEnumValues();

        return view("admin/order_details", $res);
    }

    private function getOrderStatusEnumValues()
    {
        $query = $this->db->query("SHOW COLUMNS FROM tbl_orders LIKE 'order_status'");
        $row = $query->getRow();
        preg_match("/^enum\(\'(.*)\'\)$/", $row->Type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;

    }

    public function getData()
    {
        $status = $this->request->getPost('status');

        $orderqry = "SELECT
                a.*,
                b.username,
                b.number,
                b.email,
                DATE_FORMAT(a.order_date, '%d-%m-%Y') AS orderdate
            FROM
                tbl_orders AS a
            INNER JOIN tbl_users AS b ON a.user_id = b.user_id
            WHERE
                a.flag = 1 AND b.flag = 1 AND a.order_status <> 'initiated'";

        $params = [];

        if (!empty($status)) {
            $orderqry .= " AND a.order_status = ?";
            $params[] = $status;
        }

        $orderDetails = $this->db->query($orderqry, $params)->getResultArray();


        echo json_encode($orderDetails);
    }

    public function getOrderView()
    {
        $orderID = $this->request->getPost();

        // Get Order Summary
        $Orderquery = "SELECT * FROM `tbl_orders` WHERE order_id = ? AND `flag` = 1 AND order_status <> 'initiated' ORDER BY order_id DESC";

        $orders = $this->db->query($Orderquery, [$orderID])->getResultArray();

        foreach ($orders as $orderDetails) {
            $userID = $orderDetails['user_id'];
            $addID = $orderDetails['add_id'];

            $userQuery = "SELECT
                            a.`username`,
                            a.`number`,
                            a.`email`,
                            b.landmark,
                            b.city,
                            b.address,
                            b.pincode,
                            c.state_title,
                            d.dist_name
                        FROM
                            `tbl_users` AS a
                        INNER JOIN tbl_user_address AS b
                        ON
                            a.user_id = b.user_id
                        INNER JOIN tbl_state AS c
                        ON
                            c.state_id = b.state_id
                        INNER JOIN tbl_district AS d
                        ON
                            d.dist_id = b.dist_id
                        WHERE
                            a.user_id = ? AND b.add_id = ?";
            $userDetails = $this->db->query($userQuery, [$userID, $addID])->getRowArray();
        }


        $orderSummaries = [];

        $orderID = $orders[0]['order_id'];
        $courierCharge = $orders[0]['courier_charge'];
        $orderSubTotal = $orders[0]['sub_total'];
        $OrderTotalAmt = $orders[0]['total_amt'];
        $orderDate = date('d-m-Y', strtotime($orders[0]['order_date']));

        $query = "SELECT * FROM `tbl_order_item` WHERE `flag` = 1 AND `order_id` = ?";
        $itemDetails = $this->db->query($query, [$orderID])->getResultArray();

        $isReturned = $orders[0]['is_returned'];

        if ($isReturned == 1) {
            $query2 = "SELECT * FROM `tbl_return_items` WHERE `flag` = 1 AND `order_id` = ?";
            $returnedItems = $this->db->query($query2, [$orderID])->getResultArray();
        } else {
            $returnedItems = [];
        }

        $orderSummaries = [
            'order_id' => $orderID,
            'order_no' => $orders[0]['order_no'],
            'bill_no' => $orders[0]['bill_no'],
            'bill_date' => $orders[0]['bill_date'],
            'order_status' => $orders[0]['order_status'],
            'order_date' => $orderDate,
            'razerpay_order_id' => $orders[0]['razerpay_order_id'],
            'razerpay_payment_id' => $orders[0]['razerpay_payment_id'],
            'payment_status' => $orders[0]['payment_status'],
            'payment_cancel_reason' => $orders[0]['payment_cancel_reason'],
            'delivery_status' => $orders[0]['delivery_status'],
            'delivery_message' => $orders[0]['delivery_message'],
            'payment_method' => $orders[0]['payment_method'],
            'courier_charge' => $courierCharge,
            'order_sub_total' => $orderSubTotal,
            'order_total_amt' => $OrderTotalAmt,
            'cgst' => $orders[0]['cgst'],
            'sgst' => $orders[0]['sgst'],
            'gst' => $orders[0]['gst'],
            'items' => [],
            'user_details' => $userDetails,
            'returned_items' => [],
            'is_returned' => $orders[0]['is_returned'],
            'cancel_status' => $orders[0]['cancel_status'],
            'cancel_reason' => $orders[0]['cancel_reason'],
            'discount_amt' => $orders[0]['discount_amt'],
            'is_discount' => $orders[0]['is_discount'],
        ];



        foreach ($itemDetails as $item) {
            $prodID = $item['prod_id'];
            $variantID = $item['variant_id'];
            $quantity = $item['quantity'];
            $prod_price = $item['prod_price'];
            $sub_total = $item['sub_total'];

            $packQtyQuery = "SELECT
                            a.`pack_qty`,
                            a.offer_type,a.offer_details,a.offer_price,
                            b.prod_name,
                            b.main_image
                        FROM
                            `tbl_variants` AS a
                        INNER JOIN tbl_products AS b
                            ON a.prod_id = b.prod_id
                        WHERE
                            b.`flag` = 1 AND a.flag = 1 AND a.variant_id = ? AND a.prod_id = ?";
            $packData = $this->db->query($packQtyQuery, [$variantID, $prodID])->getRow();

            if ($packData) {
                $productDetails = [
                    'prod_name' => $packData->prod_name,
                    'main_image' => $packData->main_image,
                    'pack_qty' => $packData->pack_qty,
                    'quantity' => $quantity,
                    'prod_price' => $prod_price,
                    'sub_total' => $sub_total,
                    'offer_type' => $packData->offer_type,
                    'offer_details' => $packData->offer_details,
                    'offer_price' => $packData->offer_price,
                ];
                $orderSummaries['items'][] = $productDetails;
            }
        }



        if (count($returnedItems) > 0) {
            foreach ($returnedItems as $item) {
                $prodID = $item['prod_id'];
                $variantID = $item['variant_id'];
                $quantity = $item['quantity'];
                $prod_price = $item['prod_price'];
                $sub_total = $item['sub_total'];
                $reason = $item['reason'];

                $packQtyQuery = "SELECT
                            a.`pack_qty`,
                            a.offer_type,a.offer_details,a.offer_price,
                            b.prod_name,
                            b.main_image
                        FROM
                            `tbl_variants` AS a
                        INNER JOIN tbl_products AS b
                            ON a.prod_id = b.prod_id
                        WHERE
                            b.`flag` = 1 AND a.flag = 1 AND a.variant_id = ? AND a.prod_id = ?";
                $packData = $this->db->query($packQtyQuery, [$variantID, $prodID])->getRow();

                if ($packData) {
                    $productDetails = [
                        'prod_name' => $packData->prod_name,
                        'main_image' => $packData->main_image,
                        'pack_qty' => $packData->pack_qty,
                        'quantity' => $quantity,
                        'prod_price' => $prod_price,
                        'sub_total' => $sub_total,
                        'offer_type' => $packData->offer_type,
                        'offer_details' => $packData->offer_details,
                        'offer_price' => $packData->offer_price,
                        'reason' => $reason
                    ];
                    $orderSummaries['returned_items'][] = $productDetails;
                }
            }
        }

        krsort($orderSummaries);


        if ($orderSummaries) {
            $res['summary'] = $orderSummaries;
            $res['code'] = 200;
            $res['status'] = 'success';

        } else {
            $res['code'] = 400;
            $res['status'] = 'failure';
        }

        return $this->response->setJSON($res);
    }


    public function updateTrackingDetails()
    {
        $data = $this->request->getPost();

        $courier_partner = $this->request->getPost("courier_partner");
        $tracking_link = $this->request->getPost("tracking_link");
        $tracking_id = $this->request->getPost("tracking_id");
        $bill_no = $this->request->getPost("bill_no");
        $bill_date = $this->request->getPost("bill_date");
        $delivery_date = $this->request->getPost("delivery_date");
        $orderID = $this->request->getPost("orderID");

        $updateQry = "UPDATE  `tbl_orders` SET courier_partner = ? , tracking_link  = ?,tracking_id = ?,bill_no = ? ,bill_date = ? ,delivery_date = ?  
                       WHERE `flag` = 1 AND `order_id` = ?";
        $updateTracking = $this->db->query($updateQry, [$courier_partner, $tracking_link, $tracking_id, $bill_no, $bill_date, $delivery_date, $orderID]);

        $affectedRows = $this->db->affectedRows();

        if ($affectedRows > 0) {
            $res['code'] = 200;
            $res['status'] = 'success';
            $res['message'] = 'Tracking Details Updated Successfully';

        } else {
            $res['code'] = 400;
            $res['status'] = 'success';
            $res['message'] = 'Updated Failed';
        }
        return $this->response->setJSON($res);

    }


    public function getTrackingDetails()
    {
        $order_id = $this->request->getPost("order_id");

        $getTrackingDetails = $this->db->query("SELECT courier_partner ,tracking_link ,tracking_id ,bill_no ,bill_date , delivery_date  FROM `tbl_orders` 
                              WHERE flag = 1 AND `order_id` = ?", [$order_id])->getRowArray();

        return $this->response->setJSON($getTrackingDetails);
    }


    public function deleteData()
    {

        try {
            $orderID = $this->request->getPost('order_id');


            $query = 'UPDATE `tbl_orders` SET `flag`= 0 WHERE `order_id` = ?';
            $updateData = $this->db->query($query, [$orderID]);

            $affected_rows = $this->db->affectedRows();

            if ($affected_rows && $updateData) {
                $result['code'] = 200;
                $result['status'] = 'success';
                $result['message'] = 'Deleted Successfully';
            } else {
                $result['code'] = 400;
                $result['status'] = 'Failure';
                $result['message'] = 'Something wrong';

            }
            echo json_encode($result);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'status' => 'error',
                'msg' => 'Server Error: ' . $e->getMessage()
            ]);

        }
    }

    public function updateOrderStatus()
    {
        $data = $this->request->getPost();

        $orderID = $this->request->getPost('order_id');
        $newStatus = trim($this->request->getPost('status'));
        $cancelReason = $this->request->getPost('reason');
        $cancelStatus = 0;
        if (!empty($cancelReason)) {
            $cancelStatus = 1;
        }

        $orderDetail = $this->db->query('SELECT `user_id`   FROM `tbl_orders` WHERE `flag` = 1 AND `order_id` = ?', [$orderID])->getRow();
        $userID = $orderDetail->user_id;


        $users = $this->db->query('SELECT `number` ,`username` FROM `tbl_users` WHERE `flag` = 1 AND `user_id` = ?', [$userID])->getRow();
        $number = $users->number;
        $username = $users->username;

        $order = $this->db->query("SELECT order_status ,order_no ,`tracking_link` ,`tracking_id`  FROM `tbl_orders` WHERE `order_id` =  ?", [$orderID])->getRow();
        $orderNo = $order->order_no;
        $trackingLink = $order->tracking_link;
        $trackingId = $order->tracking_id;

        if (!$order) {
            return $this->response->setJSON(['code' => 400, 'status' => false, 'message' => 'Order not found']);
        }

        $currentStatus = trim($order->order_status);



        $validStatusFlow = [
            'New' => ['Readytoship', 'Cancelled'],
            'Readytoship' => ['Shipped', 'Cancelled'],
            'Shipped' => ['Delivered', 'Cancelled'],
            'Delivered' => [],
            'Cancelled' => ['Refund'],
            'Refund' => [],
        ];


        if (!isset($validStatusFlow[$currentStatus])) {
            return $this->response->setJSON(['code' => 400, 'status' => false, 'message' => 'Invalid current status']);
        }


        if (!in_array($newStatus, $validStatusFlow[$currentStatus])) {
            return $this->response->setJSON([
                'code' => 400,
                'status' => false,
                'message' => "Invalid status change: $currentStatus → $newStatus"
            ]);
        }

        // Initialize fields
        $shipped_date = null;
        $delivered_date = null;
        $delivery_status = null;
        $delivery_message = null;
        $currentDate = date("Y-m-d H:i:s");

        switch ($newStatus) {
            case 'Readytoship':
                $ready_to_ship_date = $currentDate;
                $delivery_status = 'Readytoship';
                $delivery_message = 'Order packed and ready to ship!';
                break;

            case 'Shipped':
                $shipped_date = $currentDate;
                $delivery_status = 'Shipped';
                $delivery_message = 'Your order has been shipped and is on its way.';
                break;

            case 'Delivered':
                $delivered_date = $currentDate;
                $delivery_status = 'Delivered';
                $delivery_message = 'Your order has been delivered.';
                break;

            case 'Cancelled':
                $delivery_status = 'Cancelled';
                $delivery_message = 'Your order has been cancelled.';
                break;

            case 'Refund':
                $delivery_status = 'Refund Created';
                $delivery_message = 'The refund has been created and will be processed shortly.';
                break;
        }


        if ($delivery_status == 'Shipped') {
            $apiKey = $_ENV['SMS_API_KEY'];
            $templateName = $_ENV['ORDER_SHIPPED'];


            $getTrackingDetails = $this->db->query("SELECT `courier_partner` ,`tracking_link`,`tracking_id` FROM `tbl_orders` WHERE `order_id` = ? AND `user_id` = ?", [$orderID, $userID])->getRow();
            $courierPartner = $getTrackingDetails->courier_partner;
            $trackingLink = $getTrackingDetails->tracking_link;
            $trackingId = $getTrackingDetails->tracking_id;

            if ($courierPartner != "" && $trackingLink != "" && $trackingId != "") {
                $response = $this->shippedAPI($apiKey, $number, $username, $templateName, $orderNo, $trackingId, $trackingLink);

                echo "<pre>";
                print_R($response);
                die;
            } else {

                return $this->response->setJSON([
                    'code' => 400,
                    'status' => false,
                    'message' => "Please Enter Tracking ID, Tracking Link & Courier Partner"
                ]);
            }



        } else if ($delivery_status == 'Delivered') {
            $apiKey = $_ENV['SMS_API_KEY'];
            $templateName = $_ENV['ORDER_DELIVERED'];
            $response = $this->deliveredAPI($apiKey, $number, $username, $templateName, $orderNo);

        }

        $updateOrderQry = "
           UPDATE tbl_orders 
            SET 
                `order_status` = ?, 
                `ready_to_ship_date` = IF(ready_to_ship_date = '0000-00-00 00:00:00' AND ? != '', ?, ready_to_ship_date),
                `shipped_date` = IF(shipped_date = '0000-00-00 00:00:00' AND ? != '', ?, shipped_date),
                `delivery_date` = IF(delivery_date = '0000-00-00 00:00:00' AND ? != '', ?, delivery_date),
                `delivery_status` = ?, 
                `delivery_message` = ?,
                `cancel_reason` = ?,
                `cancel_status` = ?
            WHERE 
                `flag` = 1 AND `order_id` = ?
        ";

        $this->db->query($updateOrderQry, [
            $newStatus,
            $ready_to_ship_date,
            $ready_to_ship_date,
            $shipped_date,
            $shipped_date,
            $delivered_date,
            $delivered_date,
            $delivery_status,
            $delivery_message,
            $cancelReason,
            $cancelStatus,
            $orderID
        ]);


        $affectedRows = $this->db->affectedRows();
        if ($affectedRows) {
            $result['code'] = 200;
            $result['status'] = 'success';
            $result['message'] = 'Status Updated Successfully';
        } else {
            $result['code'] = 400;
            $result['status'] = 'Failure';
            $result['message'] = 'Something wrong';

        }

        return $this->response->setJSON($result);
    }

    private function shippedAPI($apiKey, $number, $username, $templateName, $orderNo, $trackingId, $trackingLink)
    {
        $from = 'SMLEFO';


        $userName = str_replace(' ', '', ucwords(strtolower(trim($username))));

        $VAR1 = $trackingId;
        $VAR2 = $trackingLink;
        $VAR3 = $trackingId;
        $msg = "Dear customer, your order has been shipped. Tracking ID: $VAR1. Track your shipment here: $VAR2$VAR3. - Smileaf";

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
                    'peid' => '1101541910000087087',
                    'ctid' => '1107175396465873081',
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);
            return json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
    private function deliveredAPI($apiKey, $number, $username, $templateName, $orderNo)
    {
        $from = 'SMLEFO';

        $userName = str_replace(' ', '', ucwords(strtolower(trim($username))));

        $msg = "Hi $username, Your order $orderNo has been delivered. We hope you enjoy your purchase!- Smileaf";

        $peid = $_ENV['PE_ID'];
        $ctid = $_ENV['CT_ID'];

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
                    'ctid' => '1107175396473342596'
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);

            $result = json_decode($response->getBody(), true);


            return $result;

        } catch (\Exception $e) {
            // Log or handle the error
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }


    public function pdfView()
    {
        $encodedorderID = $this->request->getGet('orderID');
        $orderID = base64_decode($encodedorderID);


        // Get Order Summary
        $Orderquery = "SELECT * FROM `tbl_orders` WHERE order_id = ? AND `flag` = 1 AND order_status <> 'initiated' ORDER BY order_id DESC";

        $orders = $this->db->query($Orderquery, [$orderID])->getResultArray();

        foreach ($orders as $orderDetails) {
            $userID = $orderDetails['user_id'];
            $addID = $orderDetails['add_id'];

            $userQuery = "SELECT
                            a.`username`,
                            a.`number`,
                            a.`email`,
                            b.landmark,
                            b.city,
                            b.address,
                            b.pincode,
                            c.state_title,
                            d.dist_name
                        FROM
                            `tbl_users` AS a
                        INNER JOIN tbl_user_address AS b
                        ON
                            a.user_id = b.user_id
                        INNER JOIN tbl_state AS c
                        ON
                            c.state_id = b.state_id
                        INNER JOIN tbl_district AS d
                        ON
                            d.dist_id = b.dist_id
                        WHERE
                            a.user_id = ? AND b.add_id = ?";
            $userDetails = $this->db->query($userQuery, [$userID, $addID])->getRowArray();
        }


        $orderSummaries = [];

        $orderID = $orders[0]['order_id'];
        $courierCharge = $orders[0]['courier_charge'];
        $orderSubTotal = $orders[0]['sub_total'];
        $OrderTotalAmt = $orders[0]['total_amt'];
        $orderDate = date('d-m-Y', strtotime($orders[0]['order_date']));

        $query = "SELECT * FROM `tbl_order_item` WHERE `flag` = 1 AND `order_id` = ?";
        $itemDetails = $this->db->query($query, [$orderID])->getResultArray();




        $orderSummaries = [
            'order_id' => $orderID,
            'order_no' => $orders[0]['order_no'],
            'bill_no' => $orders[0]['bill_no'],
            'bill_date' => $orders[0]['bill_date'],
            'order_status' => $orders[0]['order_status'],
            'order_date' => $orderDate,
            'razerpay_order_id' => $orders[0]['razerpay_order_id'],
            'razerpay_payment_id' => $orders[0]['razerpay_payment_id'],
            'payment_status' => $orders[0]['payment_status'],
            'payment_cancel_reason' => $orders[0]['payment_cancel_reason'],
            'delivery_status' => $orders[0]['delivery_status'],
            'delivery_message' => $orders[0]['delivery_message'],
            'payment_method' => $orders[0]['payment_method'],
            'courier_charge' => $courierCharge,
            'order_sub_total' => $orderSubTotal,
            'order_total_amt' => $OrderTotalAmt,
            'cgst' => $orders[0]['cgst'],
            'sgst' => $orders[0]['sgst'],
            'gst' => $orders[0]['gst'],
            'items' => [],
            'user_details' => $userDetails,
            'discount_amt' => $orders[0]['discount_amt'],
            'is_discount' => $orders[0]['is_discount'],

        ];



        foreach ($itemDetails as $item) {
            $prodID = $item['prod_id'];
            $variantID = $item['variant_id'];
            $quantity = $item['quantity'];
            $prod_price = $item['prod_price'];
            $sub_total = $item['sub_total'];

            $packQtyQuery = "SELECT
                            a.`pack_qty`,
                            a.offer_type,a.offer_details,a.offer_price,
                            b.prod_name,
                            b.main_image
                        FROM
                            `tbl_variants` AS a
                        INNER JOIN tbl_products AS b
                            ON a.prod_id = b.prod_id
                        WHERE
                            b.`flag` = 1 AND a.flag = 1 AND a.variant_id = ? AND a.prod_id = ?";
            $packData = $this->db->query($packQtyQuery, [$variantID, $prodID])->getRow();

            if ($packData) {
                $productDetails = [
                    'prod_name' => $packData->prod_name,
                    'main_image' => $packData->main_image,
                    'pack_qty' => $packData->pack_qty,
                    'quantity' => $quantity,
                    'prod_price' => $prod_price,
                    'sub_total' => $sub_total,
                    'offer_type' => $packData->offer_type,
                    'offer_details' => $packData->offer_details,
                    'offer_price' => $packData->offer_price,
                ];
                $orderSummaries['items'][] = $productDetails;
            }
        }


        krsort($orderSummaries);



        ob_start();

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('admin/orderPDF', $orderSummaries);
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        ob_clean();

        header("Cache-Control: max-age=1");
        header("Pragma: public");
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=order_$orderID.pdf");
        header("Content-Description: OrderList Data");
        header("Content-Transfer-Encoding: binary");

        echo $dompdf->output();
        exit;

    }


}