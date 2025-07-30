<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\AddressModel;
use PHPMailer\PHPMailer\Exception;
use App\Libraries\PHPMailer_Lib;
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


    public function getDist()
    {
        $stateID = $this->request->getPost('state_id');

        $getData["response"] = $this->db->query("SELECT a.`state_title`, b.`dist_id`,b.`dist_name` FROM 
        tbl_state AS a INNER JOIN tbl_district AS b 
        ON a.state_id = b.state_id WHERE  a.`flag` = 1 AND b.state_id = ?;", [$stateID])->getResultArray();

        $getData["state"] = $this->db->query("SELECT * FROM `tbl_state` WHERE flag = 1")->getResultArray();
        $getData['code'] = 200;

        echo json_encode($getData);
    }

    public function insertAddress()
    {
        $data = $this->request->getPost();

        $userID = $this->session->get('user_id');
        $AddressModel = new AddressModel;

        $stateID = $this->request->getPost('state_id');
        $data = $this->request->getPost();


        $distID = $this->request->getPost('dist_id');
        $landMark = $this->request->getPost('landmark');
        $city = $this->request->getPost('city');
        $address = $this->request->getPost('address');
        $pincode = $this->request->getPost('pincode');
        $defaultAddr = $this->request->getPost('default_addr');

        $checkDefault = $defaultAddr == "true" ? 1 : 0;


        $query = "SELECT * FROM `tbl_user_address` WHERE `flag` = 1 AND `user_id` = ? AND `default_addr` = 1";
        $getAddr = $this->db->query($query, [$userID])->getResult();



        if ($defaultAddr == 'true') {
            if (count($getAddr) > 0) {
                $oldID = $getAddr[0]->add_id;

                $query = "UPDATE tbl_user_address SET default_addr = 0 WHERE add_id = ? AND user_id = ?";
                $updateAddr = $this->db->query($query, [$oldID, $userID]);
            }
        }

        $userqry = "SELECT * FROM `tbl_users` WHERE `flag` = 1 AND `user_id` = ?  AND `is_verified` = 1";
        $userData = $this->db->query($userqry, [$userID])->getResultArray();

        $data = [
            "user_id" => $userID,
            "state_id" => $stateID,
            "dist_id" => $distID,
            "landmark" => $landMark,
            "city" => $city,
            "address" => $address,
            "pincode" => $pincode,
            "default_addr" => $checkDefault
        ];

        $insertData = $AddressModel->insert($data);
        $lastInsertID = $this->db->insertID();
        $affectedRowss = $this->db->affectedRows();

        $query = "SELECT a.`state_id` , b.state_title , c.dist_name FROM `tbl_user_address`  AS a 
                    INNER JOIN tbl_state AS b  ON b.state_id = a.state_id
                    INNER JOIN tbl_district  AS c  ON c.dist_id = a.dist_id
                    WHERE a.user_id  = ? AND a.flag = 1";
        $addressDetails = $this->db->query($query, [$userID])->getResultArray();

        if ($affectedRowss === 1 && $insertData) {


            $query = "SELECT a.*, b.state_title, c.dist_name 
                    FROM tbl_user_address AS a 
                    INNER JOIN tbl_state AS b ON a.state_id = b.state_id
                    INNER JOIN tbl_district AS c ON a.dist_id = c.dist_id
                    WHERE a.user_id = ?  AND a.flag = 1;";
            $addDetails = $this->db->query($query, [$userID])->getResultArray();



            $result['code'] = 200;
            $result['message'] = 'Address added Successfully';
            $result['status'] = 'success';
            $result['address'] = $addDetails;

        } else {
            $result['code'] = 400;
            $result['status'] = 'Failed';
            $result['message'] = 'Something wrong';
        }


        echo json_encode($result);
    }

    public function getAddress()
    {
        $userID = $this->session->get("user_id");
        $query = "SELECT a.*, b.state_title, c.dist_name 
        FROM tbl_user_address AS a 
        INNER JOIN tbl_state AS b ON a.state_id = b.state_id
        INNER JOIN tbl_district AS c ON a.dist_id = c.dist_id
        WHERE a.user_id = ?  AND a.flag = 1;";
        $result = $this->db->query($query, [$userID])->getResultArray();
        echo json_encode($result);
    }

    public function updateAddress()
    {

        $AddressModel = new AddressModel;
        $data = $this->request->getPost();

        $addID = $this->request->getPost("add_id");
        $userID = session()->get('user_id');

        $state = $this->request->getPost('state_id');
        $dist = $this->request->getPost('dist_id');
        $landmark = $this->request->getPost('landmark');
        $city = $this->request->getPost('city');
        $address = $this->request->getPost('address');
        $pincode = $this->request->getPost('pincode');
        $defaultAddr = $this->request->getPost('default_addr');
        $checkDefault = $defaultAddr == "true" ? 1 : 0;
        $checkout = $this->request->getPost('checkout');

        if ($checkout === 'checkout') {
            $defaultAddr = $this->request->getPost('default_addr');
        }


        if ($checkDefault == 1) {
            $query = "SELECT * FROM `tbl_user_address` WHERE `flag` = 1 AND `user_id` = ? AND `default_addr` = 1";
            $getAddr = $this->db->query($query, [$userID])->getResult();
            if (count($getAddr) > 0) {
                $oldID = $getAddr[0]->add_id;
                $query = "UPDATE tbl_user_address SET default_addr = 0 WHERE add_id = ? AND user_id = ?";
                $updateAddr = $this->db->query($query, [$oldID, $userID]);
            }
        }

        $query = "UPDATE tbl_user_address 
                  SET state_id = ?, dist_id = ?, landmark = ?, city = ?, address = ?, pincode = ?, default_addr = ? 
                  WHERE user_id = ? AND add_id = ?";
        $updateData = $this->db->query($query, [$state, $dist, $landmark, $city, $address, $pincode, $checkDefault, $userID, $addID]);

        $affectedRows = $this->db->affectedRows();
        if ($affectedRows > 0) {

            $query = "SELECT a.*, b.state_title, c.dist_name 
                    FROM tbl_user_address AS a 
                    INNER JOIN tbl_state AS b ON a.state_id = b.state_id
                    INNER JOIN tbl_district AS c ON a.dist_id = c.dist_id
                    WHERE a.user_id = ?  AND a.flag = 1;";
            $addDetails = $this->db->query($query, [$userID])->getResultArray();


            $result['code'] = 200;
            $result['message'] = 'Data updated successfully';
            $result['status'] = 'success';
            $result['address'] = $addDetails;

        } else {
            $result['code'] = 400;
            $result['message'] = 'No data updated or something went wrong';
            $result['status'] = 'failure';

        }

        echo json_encode($result);
    }

    public function deleteAddress()
    {

        $addID = $this->request->getPost('add_id');


        $query = "UPDATE tbl_user_address SET `flag` = 0 WHERE add_id =? ";
        $dltData = $this->db->query($query, [$addID]);
        $affected_rows = $this->db->affectedRows();

        if ($affected_rows && $dltData) {
            $result['code'] = 200;
            $result['status'] = 'success';
            $result['message'] = 'Deleted Successfully';

        } else {
            $result['code'] = 400;
            $result['status'] = 'Failure';
            $result['message'] = 'Something wrong';

        }
        echo json_encode($result);
    }

    public function insertUserDetails()
    {
        $UserModel = new UserModel;
        $request = $this->request;
        $userID = $this->session->get('user_id');

        $userNum = $this->db->query("SELECT `number`  FROM `tbl_users` WHERE `flag` =  1 AND `user_id` = ?", [$userID])->getRow();
        $currentNumber = $userNum->number;

        $data = $this->request->getPost();
        $isVerify = $this->request->getPost('isverify');
        $whatsapp = $this->request->getPost('whatapp_number');

        if ($whatsapp == $currentNumber) {
            $whatsappNum = $currentNumber;
        } else {
            $whatsappNum = ($isVerify == "no") ? $whatsapp : $currentNumber;
        }

        $userData = [
            'username' => $request->getPost('username'),
            'email' => $request->getPost('email'),
            'whatsapp_number' => $whatsappNum,
        ];

        $UserModel->update($userID, $userData);

        $affectedRows = $UserModel->db->affectedRows();

        if ($affectedRows > 0) {
            return $this->response->setJSON([
                'code' => 200,
                'message' => 'Details Added successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'code' => 400,
                'message' => 'No changes were made.'
            ]);
        }
    }


    public function updateDefaultAddress()
    {
        $userID = session()->get("user_id");
        $addID = $this->request->getPost("add_id");


        $query = "SELECT * FROM `tbl_user_address` WHERE `user_id` = ? AND `default_addr` = 1 AND `flag` = 1";
        $getAddressData = $this->db->query($query, [$userID])->getResultArray();


        $affectedRows = 0;
        $affectedRows2 = 0;


        if (count($getAddressData) > 0) {
            $oldAddrID = $getAddressData[0]['add_id'];

            $updateOldqry = "UPDATE `tbl_user_address` SET `default_addr` = 0 WHERE `add_id` = ? AND `flag` = 1 AND `user_id` = ?";
            $this->db->query($updateOldqry, [$oldAddrID, $userID]);
            $affectedRows = $this->db->affectedRows();
        }

        if ($affectedRows > 0 || count($getAddressData) == 0) {
            $updateqry = "UPDATE `tbl_user_address` SET `default_addr` = 1 WHERE `add_id` = ? AND `flag` = 1 AND `user_id` = ?";
            $this->db->query($updateqry, [$addID, $userID]);
            $affectedRows2 = $this->db->affectedRows();
        }


        if ($affectedRows2 > 0) {
            return $this->response->setJSON([
                'code' => 200,
                'message' => 'Address Updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'code' => 400,
                'message' => 'Address Update failed.'
            ]);
        }
    }


    public function viewOrderDetails()
    {
        $orderID = $this->request->getPost('orderid');

        $userID = $this->session->get('user_id');
        // Get Order Summary
        $Orderquery = "SELECT * FROM `tbl_orders` WHERE `user_id` = ? AND order_id = ? AND`flag` = 1  AND  order_status <> 'initiated'";
        $orders = $this->db->query($Orderquery, [$userID, $orderID])->getResultArray();

        $orderSummaries = [];

        $orderID = $orders[0]['order_id'];
        $courierCharge = $orders[0]['courier_charge'];
        $orderSubTotal = $orders[0]['sub_total'];
        $OrderTotalAmt = $orders[0]['total_amt'];
        $orderDate = date('d-m-Y', strtotime($orders[0]['order_date']));

        $query = "SELECT * FROM `tbl_order_item` WHERE `flag` = 1 AND `order_id` = ?";
        $itemDetails = $this->db->query($query, [$orderID])->getResultArray();


        $query2 = "SELECT * FROM `tbl_return_items` WHERE `flag` = 1 AND `order_id` = ?";
        $returnedItems = $this->db->query($query2, [$orderID])->getResultArray();



        $orderSummaries = [
            'order_id' => $orderID,
            'order_no' => $orders[0]['order_no'],
            'bill_no' => $orders[0]['bill_no'],
            'bill_date' => $orders[0]['bill_date'],
            'order_status' => $orders[0]['order_status'],
            'order_date' => $orderDate,
            'payment_status' => $orders[0]['payment_status'],
            'payment_cancel_reason' => $orders[0]['payment_cancel_reason'],
            'delivery_status' => $orders[0]['delivery_status'],
            'delivery_message' => $orders[0]['delivery_message'],
            'courier_charge' => $courierCharge,
            'order_sub_total' => $orderSubTotal,
            'order_total_amt' => $OrderTotalAmt,
            'cgst' => $orders[0]['cgst'],
            'sgst' => $orders[0]['sgst'],
            'gst' => $orders[0]['gst'],
            'returned_items' => [],
            'items' => [],
            'is_returned' => $orders[0]['is_returned'],
        ];

        foreach ($itemDetails as $item) {
            $prodID = $item['prod_id'];
            $variantID = $item['variant_id'];
            $quantity = $item['quantity'];
            $prod_price = $item['prod_price'];
            $sub_total = $item['sub_total'];

            $packQtyQuery = "SELECT
                            a.`pack_qty`,
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

                $packQtyQuery = "SELECT
                            a.`pack_qty`,
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

    public function updateCancelReason()
    {
        $data = $this->request->getPost();

        $orderId = $this->request->getPost('order_id');
        $orderStatus = $this->request->getPost('order_status');
        $CancelReason = $this->request->getPost('cancel_reason');
        $otherCancelReason = $this->request->getPost('other_cancel_reason');
        $userID = session()->get('user_id');

        if ($CancelReason == 'other') {
            $CancelReason = $otherCancelReason;
        }

        $newOrderStatus = "Cancelled";
        $newDeliveryStatus = "Cancelled";
        $cancelStatus = 1;

        $deliveryConfig = new \Config\DeliveryMessages();
        $deliveryMsg = $deliveryConfig->messages[$newDeliveryStatus] ?? 'No message available';

        $updateQry = "UPDATE `tbl_orders` SET `order_status` = ? , `delivery_status` =? ,`delivery_message` =? , `cancel_reason` =? , `cancel_status` = ? 
                      WHERE order_status = ? AND `order_id` = ? AND user_id = ?";
        $updateData = $this->db->query($updateQry, [$newOrderStatus, $newDeliveryStatus, $deliveryMsg, $CancelReason, $cancelStatus, $orderStatus, $orderId, $userID]);

        $affectedRows = $this->db->affectedRows();
        if ($affectedRows == 1) {

            $res['code'] = 200;
            $res['status'] = 'success';
            $res['message'] = 'Order Cancelled Successfully';

        } else {
            $res['code'] = 400;
            $res['status'] = 'failure';
            $res['message'] = 'Order Cancelled failed';
        }
        echo json_encode($res);
    }

    public function getReturnProducts()
    {
        $orderID = $this->request->getPost('order_id');

        $userID = $this->session->get('user_id');
        // Get Order Summary
        $Orderquery = "SELECT * FROM `tbl_orders` WHERE `user_id` = ? AND order_id = ? AND`flag` = 1  AND  order_status <> 'initiated'";
        $orders = $this->db->query($Orderquery, [$userID, $orderID])->getResultArray();


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
            'payment_status' => $orders[0]['payment_status'],
            'payment_cancel_reason' => $orders[0]['payment_cancel_reason'],
            'delivery_status' => $orders[0]['delivery_status'],
            'delivery_message' => $orders[0]['delivery_message'],
            'courier_charge' => $courierCharge,
            'order_sub_total' => $orderSubTotal,
            'order_total_amt' => $OrderTotalAmt,
            'cgst' => $orders[0]['cgst'],
            'sgst' => $orders[0]['sgst'],
            'gst' => $orders[0]['gst'],
            'items' => [],
        ];

        foreach ($itemDetails as $item) {
            $prodID = $item['prod_id'];
            $variantID = $item['variant_id'];
            $quantity = $item['quantity'];
            $prod_price = $item['prod_price'];
            $sub_total = $item['sub_total'];

            $packQtyQuery = "SELECT
                            a.`pack_qty`,
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
                    'prod_id' => $prodID,
                    'variant_id' => $variantID
                ];
                $orderSummaries['items'][] = $productDetails;
            }
        }


        return $this->response->setJSON($orderSummaries);

    }

    public function submitReturnProducts()
    {


        $data = $this->request->getPost('return_items');


        $orderID = $this->request->getPost('order_id');

        $userQuery = "SELECT
                        a.`user_id`,
                        b.`username`,
                        b.`number`,
                        b.`email`
                    FROM
                        `tbl_orders` AS a
                    INNER JOIN tbl_users AS b
                    ON
                        a.user_id = b.user_id
                    WHERE
                        a.flag = 1 AND b.flag = 1 AND a.order_id = ?";
        $userDetails = $this->db->query($userQuery, [$orderID])->getRow();

        $userName = $userDetails->username;
        $number = $userDetails->number;
        $email = $userDetails->email;

        $refundData = [];
        $emailData = [];
        foreach ($data as $formData) {
            $selected = $formData['selected'] ?? null;
            $prod_id = $formData['prod_id'] ?? null;
            $variant_id = $formData['variant_id'] ?? null;
            $reason = $formData['reason'] ?? null;
            $quantity = $formData['quantity'] ?? null;
            $prod_price = $formData['prod_price'] ?? null;
            $main_image = $formData['main_image'] ?? null;
            $prod_name = $formData['prod_name'] ?? null;
            $pack_qty = $formData['pack_qty'] ?? null;
            $custom_reason = $formData['custom_reason'] ?? null;
            $subtotal = $prod_price * $quantity;



            if ($reason === 'other') {
                $reason = $custom_reason;
            }

            if ($selected == 1) {
                $variantQry = "SELECT `mrp` ,`offer_type`,`offer_details`,`offer_price` FROM `tbl_variants` WHERE `flag` = 1 AND `variant_id` = ? AND `prod_id` = ?";
                $variantData = $this->db->query($variantQry, [$variant_id, $prod_id])->getRow();
                $refundData[] = [
                    'order_id' => $orderID,
                    'prod_id' => $prod_id,
                    'variant_id' => $variant_id,
                    'quantity' => $quantity,
                    'prod_price' => $prod_price,
                    'sub_total' => $subtotal,
                    'mrp' => $variantData->mrp,
                    'offer_type' => $variantData->offer_type,
                    'offer_details' => $variantData->offer_details,
                    'offer_price' => $variantData->offer_price,
                    'reason' => $reason
                ];

                $emailData['email_products'][] = [
                    'image' => $main_image,
                    'prod_name' => $prod_name,
                    'pack_qty' => $pack_qty,
                    'reason' => $reason,
                ];
            }
        }


        if (!empty($emailData)) {
            $emailData['username'] = $userName;
            $emailData['email'] = $email;
            $emailData['number'] = $number;

            $sendEmail = $this->sendReturnEmail($emailData);

            if ($sendEmail == 1) {

                foreach ($refundData as $refund) {
                    $insertReturnData = $this->db->table('tbl_return_items')->insert($refund);
                }
                $affectedRows = $this->db->affectedRows();
                if ($affectedRows > 0) {
                    $refundProdCount = count($refundData);

                    $actualOrderItems = $this->db->query("SELECT COUNT(`item_id`) AS item_count FROM `tbl_order_item` WHERE  `flag` = 1 AND `order_id` = ?", [$orderID])->getRow();
                    $actualOrderCount = $actualOrderItems->item_count;

                    if ($refundProdCount <= $actualOrderCount) {
                        $orderStatus = 'Returned';
                        $deliveryStatus = 'Returned';
                        $deliveryMessage = 'Items have been returned. Your refund will be processed shortly.';
                        $is_returned = 1;

                        $updateOrderQry = "UPDATE tbl_orders SET `order_status` = ? ,`delivery_status` = ?, `delivery_message` =? , `is_returned` = ? WHERE `order_id` = ? AND `flag` = 1";
                        $updateData = $this->db->query($updateOrderQry, [$orderStatus, $deliveryStatus, $deliveryMessage, $is_returned, $orderID]);

                    }
                    // else if ($refundProdCount < $actualOrderCount) {
                    //     $is_returned = 1;
                    //     $updateOrderQry = "UPDATE tbl_orders SET  `is_returned` = ? WHERE `order_id` = ? AND `flag` = 1";
                    //     $updateOrder = $this->db->query($updateOrderQry, [$is_returned, $orderID]);
                    // }
                }

                $res['code'] = 200;
                $res['status'] = 'success';
                $res['message'] = 'Email send and data updated successfully!';
            } else {
                $res['code'] = 400;
                $res['status'] = 'failure';
                $res['message'] = 'Failed to send Email!';
            }
            return $this->response->setJSON($res);

        }

    }

    private function sendReturnEmail($data)
    {
        $emailProducts = $data['email_products'];
        $userName = $data['username'];
        $email = $data['email'];
        $number = $data['number'];

        helper('url');

        $to_email = "smileafproducts@gmail.com";
        $from_email = $email;



        $phpmailer_lib = new PHPMailer_Lib();
        $mail = $phpmailer_lib->load();

        $emailHtml = "";
        foreach ($emailProducts as $emailProd) {
            $prodMainImg = base_url($emailProd['image']);
            $prod_name = htmlspecialchars($emailProd['prod_name']);
            $pack_qty = htmlspecialchars($emailProd['pack_qty']);
            $reason = htmlspecialchars($emailProd['reason']);

            $emailHtml .= '
        <table style="border-collapse: collapse; width: 100%; max-width: 750px; margin-top:15px" align="center">
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 8px; border: 1px solid #ddd;">Image</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Product Name</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Pack Qty</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Reason</th>
            </tr>
            <tr>    
                <td style="padding: 8px; border: 1px solid #ddd;">
                    <a href="' . $prodMainImg . '" target="_blank">Click to view the image</a>
                </td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $prod_name . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $pack_qty . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $reason . '</td>
            </tr>
        </table>';
        }

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'smileafproducts@gmail.com';
            $mail->Password = 'pjzuemnpybiosqov';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom($to_email, 'Smileaf');
            $mail->addAddress($to_email);
            $mail->addReplyTo($from_email, $userName);
            $mail->addCC($from_email, $userName);
            $mail->Subject = 'Smileaf | Returned Items Notification';
            $mail->isHTML(true);

            $mail->Body = '
        <table align="center" border="0" cellpadding="0" cellspacing="0"
           width="750" bgcolor="white" style="border:2px solid #dad8c9;padding:15px">
        <tbody>
            <tr>
                <td align="center">
                    <table align="center" border="0" cellpadding="0"
                           cellspacing="0" class="col-550" width="750">
                        <tr>
                            <td align="center" style="background-color:  #538cc6; height: 70px;">
                                <a href="#" style="text-decoration: none;">
                                    <h2 style="color:#ffffff;">Returned Products</h2>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
      

        <table style="border-collapse: collapse; width: 100%; max-width: 750px; margin-top:15px" align="center">
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 8px; border: 1px solid #ddd;">Username</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Email</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Mobile</th>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;text-align:center">' . htmlspecialchars($userName) . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;text-align:center">' . htmlspecialchars($email) . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;text-align:center">' . htmlspecialchars($number) . '</td>
            </tr>
        </table>
        ' . $emailHtml;

            $mailsent = $mail->send();
            if ($mailsent == 1) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            log_message('error', 'Mail Error: ' . $mail->ErrorInfo);
            return false;
        }
    }


}