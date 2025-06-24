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
        $templateName = $_ENV['SIGNUP_TEMPLATE'];
        $otp = rand(1000, 9999);
        $otp_expiry = date("Y-m-d H:i:s", strtotime("+1 minute"));

        $userQry = "SELECT * FROM tbl_users WHERE number = ? AND flag = 1;";
        $user = $this->db->query($userQry, [$number])->getRow();


        if ($user && $user->is_verfied == 1) {
            $oldUserID = $user->user_id;

            $response = $this->signinAPI($apiKey, $number, $otp, $templateName);

            if ($response['Status'] == "Success") {
                $updateQry = "UPDATE tbl_users SET otp = ?  , otp_expiry = ? WHERE user_id = ?";
                $updateData = $this->db->query($updateQry, [$otp, $otp_expiry, $oldUserID]);

                return $this->signinSessionSMS([
                    'code' => 200,
                    'user_id' => $oldUserID,
                    'message' => 'OTP sent. Please verify.'
                ]);
            } else {
                return $this->signinSessionSMS([
                    'code' => 400,
                    'message' => 'Failed to send OTP'
                ]);
            }
        }

        if ($user && $user->is_verfied == 0) {
            $oldUserID = $user->user_id;

            $response = $this->signinAPI($apiKey, $number, $otp, $templateName);

            if ($response['Status'] == "Success") {
                $updateQry = "UPDATE tbl_users SET otp = ?  , otp_expiry = ? WHERE user_id = ?";
                $updateData = $this->db->query($updateQry, [$otp, $otp_expiry, $oldUserID]);

                return $this->signinSessionSMS([
                    'code' => 200,
                    'user_id' => $oldUserID,
                    'message' => 'OTP sent. Please verify.'
                ]);
            } else {
                return $this->signinSessionSMS([
                    'code' => 400,
                    'message' => 'Failed to send OTP'
                ]);
            }
        }

        //New user
        $response = $this->signinAPI($apiKey, $number, $otp, $templateName);
        if ($response['Status'] == "Success") {

            $userData = [
                'number' => $number,
                'otp' => $otp,
                'otp_expiry' => $otp_expiry,
                'is_verfied' => 0,
            ];

            $UserModel->insert($userData);
            $lastInsertID = $this->db->insertID();

            return $this->signinSessionSMS([
                'code' => 200,
                'user_id' => $lastInsertID,
                'message' => 'OTP sent. Please verify.'
            ]);
        } else {
            return $this->signinSessionSMS([
                'code' => 400,
                'message' => 'Failed to send OTP'
            ]);
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
                'message' => 'User not found'
            ]);
        }

        $currentTime = date("Y-m-d H:i:s");

        // Check OTP expiry
        if ($currentTime > $userData->otp_expiry) {
            return $this->response->setJSON([
                'code' => 400,
                'status' => 'failure',
                'message' => 'OTP has expired. Please request a new one.'
            ]);
        }

        // Check if entered OTP matches
        if ($userData->otp == $verifyOTP) {
            $updateQuery = "UPDATE tbl_users SET is_verified = 1 WHERE flag = 1 AND user_id = ?";
            $this->db->query($updateQuery, [$userID]);

            $this->session->set([
                'otp_verify' => "YES",
                'user_id' => $userID,
                'loginStatus' => "YES"
            ]);

            $callbackURL = $this->session->get('callback_url');
            if ($callbackURL) {
                $this->session->remove('callback_url');
                $res['c_url'] = $callbackURL;
            } else {
                $res['c_url'] = "";
            }



            return $this->response->setJSON([
                'code' => 200,
                'status' => 'Success',
                'message' => 'OTP Verified Successfully',
                'c_url' => $res['c_url']
            ]);
        } else {
            return $this->response->setJSON([
                'code' => 400,
                'status' => 'failure',
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

            $db = \Config\Database::connect();
            $this->session = \Config\Services::session();

            $data = $this->request->getPost();
            $oldUserID = session()->get('user_id');

            $newUserID = $response['user_id'];

            // Check cart table if any of the products stored in session?
            // $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag = 1";
            // $resultData = $db->query($query, [$oldUserID])->getResultArray();

            // if (count($resultData) > 0) {
            //     foreach ($resultData as $item) {
            //         $prodID = $item['prod_id'];
            //         $tblName = $item['table_name'];
            //         $query = "SELECT * FROM tbl_user_cart WHERE prod_id = ? AND user_id = ? AND table_name = ? AND flag = 1";
            //         $count = $db->query($query, [$prodID, $oldUserID, $tblName])->getNumRows();

            //         if ($count > 0) {
            //             $qty = $item['quantity'];
            //             $updateQry = "UPDATE tbl_user_cart 
            //                       SET user_id = ?, quantity = quantity + ? 
            //                       WHERE user_id = ? AND prod_id = ? AND table_name = ? AND flag = 1";
            //             $db->query($updateQry, [$newUserID, $qty, $oldUserID, $prodID, $tblName]);
            //         }
            //     }
            // }

            $jwtSecret = $_ENV['JWT_SECRET'];

            $newToken = $this->generateJWT($newUserID, $jwtSecret);

            $sess = [
                'user_id' => $newUserID,
                'loginStatus' => "YES",
                'otp_verify' => "NO",
                'type' => 'SMS',
                'jwt' => $newToken
            ];
            $this->session->set($sess);

            $response['code'] = 200;
            $response['message'] = 'Verified successfully';
            $response['token'] = $newToken;

            return $this->response->setJSON($response);
        } else {
            $response['code'] = 400;
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

            $templateName = $_ENV['SIGNUP_TEMPLATE'];

            $response = $this->signinAPI($apiKey, $to, $otp, $templateName);
            $status = $response['Status'];

            if ($status == "Success") {
                $query = "UPDATE tbl_users SET otp = ? , otp_expiry = ? WHERE user_id = ? ";
                $update = $this->db->query($query, [$otp, $otp_expiry, $userID]);
                $affectedRow = $this->db->affectedRows();

                if ($update && $affectedRow == 1) {

                    $this->session->set([
                        'otp_verify' => "YES",
                        'user_id' => $userID,
                        'loginStatus' => "YES"
                    ]);


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

        $this->session->destroy();
        return redirect()->to('/');
    }


}