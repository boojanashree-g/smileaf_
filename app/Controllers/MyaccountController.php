<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\AddressModel;

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
            $result['code'] = 200;
            $result['message'] = 'Address added Successfully';
            $result['status'] = 'success';
            $result['address'] = [
                'add_id' => $lastInsertID,
                'address' => $address,
                "landmark" => $landMark,
                "city" => $city,
                "pincode" => $pincode,
                "default_addr" => $checkDefault,
                "state_id" => $stateID,
                "dist_id" => $distID,
                "username" => $userData[0]['username'],
                "number" => $userData[0]['number'],
                "email" => $userData[0]['email'],
                "state_title" => $addressDetails[0]['state_title'],
                "dist_name" => $addressDetails[0]['dist_name'],

            ];

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
        WHERE a.user_id = $userID AND a.flag = 1;";
        $result = $this->db->query($query, [$userID])->getResultArray();
        echo json_encode($result);
    }

    public function updateAddress()
    {

        $AddressModel = new AddressModel;

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
            $result['code'] = 200;
            $result['message'] = 'Data updated successfully';
            $result['status'] = 'success';

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

        $userData = [
            'username' => $request->getPost('username'),
            'email' => $request->getPost('email'),
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

            'items' => []
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

}