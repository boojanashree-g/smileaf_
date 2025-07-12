<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;


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
        return view("admin/order_details", $res);
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
            'user_details' => $userDetails
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

}