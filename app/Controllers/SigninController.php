<?php

namespace App\Controllers;

use App\Models\UserModel;
use Firebase\JWT\JWT;



class SigninController extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }


    public function signinOTP()
    {
        $UserModel = new UserModel;
        $number = $this->request->getPost('number');

        $apiKey = $_ENV['SMS_API_KEY'];
        $login1 = $_ENV['LOGIN_TEMPLATE1'];
        $login2 = $_ENV['LOGIN_TEMPLATE2'];
        $templates = [$login1, $login2];
        $templateName = $templates[array_rand($templates)];

        $otp = rand(1000, 9999);
        $otp_expiry = date("Y-m-d H:i:s", strtotime("+1 minute"));

        $userQry = "SELECT * FROM tbl_users WHERE number = ? AND flag = 1;";
        $user = $this->db->query($userQry, [$number])->getRow();


        $old_session_userid = $this->session->get('user_id');

        if ($user && $user->is_verfied == 1) {
            $oldUserID = $user->user_id;
            // $response = $this->signinAPI($apiKey, $number, $otp, $templateName);
            // if ($response['Status'] == "Success") {
            if (true) {
                $updateQry = "UPDATE tbl_users SET otp = ?, otp_expiry = ? WHERE user_id = ?";
                $updateData = $this->db->query($updateQry, [$otp, $otp_expiry, $oldUserID]);


                if ($updateData) {
                    $sessionData = [
                        'user_id' => $oldUserID,
                        'old_userid' => $old_session_userid,
                        'type' => 'SMS'
                    ];
                    $this->session->set($sessionData);



                    $response['code'] = 200;
                    $response['message'] = 'OTP sent  successfully';
                } else {
                    $response['code'] = 400;
                    $response['message'] = 'OTP sent failed!';
                }
                return $this->response->setJSON($response);
            }
        }

        if ($user && $user->is_verfied == 0) {
            $oldUserID = $user->user_id;
            // $response = $this->signinAPI($apiKey, $number, $otp, $templateName);
            // if ($response['Status'] == "Success") {
            if (true) {
                $updateQry = "UPDATE tbl_users SET otp = ?, otp_expiry = ? WHERE user_id = ?";
                $updateData = $this->db->query($updateQry, [$otp, $otp_expiry, $oldUserID]);

                if ($updateData) {
                    $sessionData = [
                        'user_id' => $oldUserID,
                        'old_userid' => $old_session_userid,
                        'type' => 'SMS'
                    ];


                    $this->session->set($sessionData);


                    $response['code'] = 200;
                    $response['message'] = 'OTP successfully';
                } else {
                    $response['code'] = 400;
                    $response['message'] = 'OTP sent failed!';
                }
                return $this->response->setJSON($response);
            }
        }

        // New user (no record found)
        if (!$user) {
            // $response = $this->signinAPI($apiKey, $number, $otp, $templateName);

            // if ($response['Status'] == "Success") {
            if (true) {
                $userData = [
                    'number' => $number,
                    'otp' => $otp,
                    'otp_expiry' => $otp_expiry,
                    'is_verfied' => 0,
                ];

                $UserModel->insert($userData);
                $lastInsertID = $this->db->insertID();


                if ($lastInsertID) {
                    $sessionData = [
                        'user_id' => $lastInsertID,
                        'old_userid' => $old_session_userid,
                        'type' => 'SMS'
                    ];
                    $this->session->set($sessionData);
                    $response['code'] = 200;
                    $response['message'] = 'OTP successfully';
                } else {
                    $response['code'] = 400;
                    $response['message'] = 'User insertion failed!';
                }
            } else {
                $response['code'] = 400;
                $response['message'] = 'OTP sent failed!';
            }

            return $this->response->setJSON($response);
        }
    }



    public function verifyOTP()
    {
        $verifyOTP = $this->request->getPost('otp');
        $userID = $this->session->get('user_id');

        // Fetch user data including OTP and expiry
        $userData = $this->db->query("SELECT otp, user_id, otp_expiry FROM tbl_users WHERE flag = 1 AND user_id = ?", [$userID])->getRow();

        if (!$userData) {
            return $this->response->setJSON([
                'code' => 400,
                'status' => 'failure',
                'message' => 'User not found',
                'token' => null
            ]);
        }

        $currentTime = date("Y-m-d H:i:s");

        // Check OTP expiry
        if ($currentTime > $userData->otp_expiry) {
            return $this->response->setJSON([
                'code' => 400,
                'status' => 'failure',
                'message' => 'OTP has expired. Please request a new one.',
                'checkoutcode' => 403,
                'token' => null
            ]);
        }

        // Check if entered OTP matches
        if ($userData->otp == $verifyOTP) {
            $updateQuery = "UPDATE tbl_users SET is_verified = 1 WHERE flag = 1 AND user_id = ?";
            $this->db->query($updateQuery, [$userID]);

            $callbackURL = $this->session->get('callback_url');

            if ($callbackURL) {
                $res['c_url'] = $callbackURL;
                $this->session->remove('callback_url');
            } else {
                $res['c_url'] = "";
            }




            return $this->signinSessionSMS([
                'code' => 200,
                'user_id' => $userID,
                'message' => 'OTP verified successfully.',
                'c_url' => $res['c_url']
            ]);

        } else {
            return $this->signinSessionSMS([
                'code' => 400,
                'message' => 'Invalid OTP'
            ]);
        }
    }


    private function signinAPI($apiKey, $to, $otp, $templateName)
    {

        $client = \Config\Services::curlrequest();
        try {
            $url = 'https://2factor.in/API/V1/' . $apiKey . '/SMS/' . urlencode('+91' . $to) . '/' . urlencode($otp) . '/' . urlencode($templateName);
            log_message('debug', 'Requesting URL: ' . $url);
            $response = $client->get($url);
            $responseData = json_decode($response->getBody(), true);

            return $responseData;
        } catch (\Exception $e) {
            log_message('error', 'cURL Error: ' . $e->getCode() . ' : ' . $e->getMessage());
            return false;
        }
    }

    public function signinSessionSMS($response)
    {
        if ($response['code'] == 200) {

            $data = $this->request->getPost();

            $newUserID = $response['user_id'];
            $oldUserID = $this->session->get('old_userid');

            $getUserNumber = $this->db->query("SELECT `number` FROM `tbl_users` WHERE `flag` = 1 AND `user_id` =  ?", [$newUserID])->getRow();

            // Cart Updates
            $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag = 1";
            $resultData = $this->db->query($query, [$oldUserID])->getResultArray();

            if (count($resultData) > 0) {
                foreach ($resultData as $item) {
                    $prodID = $item['prod_id'];
                    $qty = $item['quantity'];

                    $prodPrice = $item["prod_price"];
                    $subtotal = $prodPrice * $qty;

                    $IDpresntQuery = "SELECT * FROM tbl_user_cart WHERE prod_id = ? AND user_id = ?  AND flag = 1";
                    $countID = $this->db->query($IDpresntQuery, [$prodID, $newUserID])->getNumRows();
                    if ($countID > 0) {

                        $updateQry = "UPDATE tbl_user_cart 
                                  SET quantity = ? , total_price = ? 
                                  WHERE user_id = ? AND prod_id = ? AND flag = 1";
                        $updateOld = $this->db->query($updateQry, [$qty, $subtotal, $newUserID, $prodID]);

                        $affectedRows = $this->db->affectedRows();
                        if ($updateOld && $affectedRows == 1) {
                            $dltsession = "DELETE FROM tbl_user_cart WHERE user_id = ?";
                            $this->db->query($dltsession, $oldUserID);
                        }

                        $this->db->query($updateQry, [$qty, $subtotal, $newUserID, $prodID]);
                    } else {
                        $query = "SELECT * FROM tbl_user_cart WHERE prod_id = ? AND user_id = ?  AND flag = 1";
                        $count = $this->db->query($query, [$prodID, $oldUserID])->getNumRows();

                        if ($count > 0) {

                            $updateQry = "UPDATE tbl_user_cart 
                                    SET user_id = ?, quantity = ?,total_price = ?
                                    WHERE user_id = ? AND prod_id = ? AND flag = 1";
                            $this->db->query($updateQry, [$newUserID, $qty, $subtotal, $oldUserID, $prodID]);
                        }
                    }

                }
            }
            // Cart Updates End

            $jwtSecret = $_ENV['JWT_SECRET'];

            $newToken = $this->generateJWT($newUserID, $jwtSecret);



            $sess = [
                'user_id' => $newUserID,
                'loginStatus' => "YES",
                'otp_verify' => "YES",
                'type' => 'SMS',
                'jwt' => $newToken,
                'c_url' => $response['c_url'],
                'number' => $getUserNumber->number,

            ];

            $this->session->set($sess);

            $response['code'] = 200;
            $response['message'] = 'Verified successfully';
            $response['token'] = $newToken;

            return $this->response->setJSON($response);
        } else if ($response['code'] == 400) {
            $message = $response['message'];
            $response['code'] = 400;
            $response['message'] = $message;
            return $this->response->setJSON($response);
        } else {
            $response['code'] = 500;
            $response['message'] = 'Invalid Credentials';
            return $this->response->setJSON($response);
        }
    }


    private function generateJWT($userID, $secretKey)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Token valid for 1 hour

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => [
                'user_id' => $userID
            ]
        ];
        return JWT::encode($payload, $secretKey, 'HS256');
    }


    public function resendOTP()
    {

        $userID = $this->session->get('user_id');
        $Type = $this->session->get('type');


        if ($Type == "SMS") {
            $details = $this->db->query("SELECT `number` FROM `tbl_users` WHERE `flag`= 1  AND user_id = $userID")->getRow();
            $to = $details->number;
            $otp = rand(1000, 9999);
            $otp_expiry = date("Y-m-d H:i:s", strtotime("+1 minute"));
            $apiKey = $_ENV['SMS_API_KEY'];
            // for login otp


            $login1 = $_ENV['LOGIN_TEMPLATE2'];
            $login2 = $_ENV['LOGIN_TEMPLATE1'];
            
            $templates = [$login1, $login2];
            // Randomly select one template from the array
            $templateName = $templates[array_rand($templates)];

            $response = $this->signinAPI($apiKey, $to, $otp, $templateName);
            $status = $response['Status'];

            if ($status == "Success") {
                $query = "UPDATE tbl_users SET otp = ? , otp_expiry = ? WHERE user_id = ? ";
                $update = $this->db->query($query, [$otp, $otp_expiry, $userID]);
                $affectedRow = $this->db->affectedRows();

                if ($update && $affectedRow == 1) {


                    $res['code'] = 200;
                    $res['status'] = 'Success';
                    $res['message'] = 'OTP resent successfully';

                    echo json_encode($res);
                } else {
                    $res['code'] = 400;
                    $res['status'] = 'Failure';
                    $res['msg'] = 'OTP resent failed!';
                    echo json_encode($res);
                }
            }

        }
    }


    public function logout()
    {

        $this->session->remove(['jwt', 'user_id', 'loginStatus', 'otp_verify']);
        return redirect()->to('/');
    }


}