<?php

namespace App\Controllers;

use App\Models\UserModel;
use Firebase\JWT\JWT;



class SignupController extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    public function signupOTP()
    {

        $UserModel = new UserModel;
        $username = $this->request->getPost('username');
        $number = $this->request->getPost('number');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $apiKey = $_ENV['SMS_API_KEY'];
        $templateName = $_ENV['SIGNUP_TEMPLATE'];
        $otp = rand(1000, 9999);


        $query = "SELECT COUNT('user_id') AS  count FROM `tbl_users` WHERE `number` = ? AND `flag` = 1";
        $number_count = $this->db->query($query, [$number])->getRow();

        $query1 = "SELECT COUNT('user_id') AS count FROM `tbl_users` WHERE `email` = ? AND `flag` = 1";
        $email_count = $this->db->query($query1, [$email])->getRow();

        if ($number_count->count != 0) {
            $response['code'] = 400;
            $response['message'] = 'The mobile number has already been registered';
            return json_encode($response);
        } else if ($email_count->count != 0) {
            $response['code'] = 400;
            $response['message'] = 'The Email has already been registered';
            return json_encode($response);
        } else {
            $response = $this->signupAPI($apiKey, $number, $otp, $templateName);
            $status = $response['Status'];

            $otp_expiry = date("Y-m-d H:i:s", strtotime("+1 minute"));

            if ($status == "Success") {
                $userData = [
                    'username' => $username,
                    'number' => $number,
                    'email' => $email,
                    'password' => $passwordHash,
                    'otp' => $otp,
                    'otp_expiry' => $otp_expiry,
                    'is_verfied' => 0

                ];

                $UserModel->insert($userData);
                $affectedRows = $this->db->affectedRows();
                $lastInsertID = $this->db->insertID();

                if ($affectedRows == 1) {

                    $response['code'] = 200;
                    $response['user_id'] = $lastInsertID;
                    $response['username'] = $username;
                    return $this->signupSessionSMS($response);

                } else {
                    $response['code'] = 400;

                    return $this->signupSessionSMS($response);
                }

            } else {
                $response['code'] = 400;

                return $this->signupSessionSMS($response);
            }
        }
    }


    private function signupAPI($apiKey, $to, $otp, $templateName)
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


    public function signupSessionSMS($response)
    {

        if ($response['code'] == 200) {

            $db = \Config\Database::connect();
            $this->session = \Config\Services::session();

            $data = $this->request->getPost();
            $oldUserID = session()->get('user_id');


            $newUserID = $response['user_id'];
            $username = $response['username'];


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
                'username' => $username,
                'user_id' => $newUserID,
                'loginStatus' => "YES",
                'otp_verify' => "NO",
                'type' => 'SMS',
                'jwt' => $newToken
            ];
            $this->session->set($sess);

            $response['code'] = 200;
            $response['message'] = 'Signup successfully';
            $response['token'] = $newToken;

            return json_encode($response);
        } else {
            $response['code'] = 400;
            $response['message'] = 'Invalid Credentials';
            return json_encode($response);
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

    public function checkSignOTP()
    {

        $OTP = $this->request->getPost('otp');
        $userID = $this->session->get('user_id');
        $data = $this->session->get();

        echo "<pre>";
        print_r($data);
        die;

    }

}