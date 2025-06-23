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

        $data = $this->request->getPost();


        $apiKey = $_ENV['SMS_API_KEY'];
        $templateName = $_ENV['SIGNUP_TEMPLATE'];
        $otp = rand(1000, 9999);
        $otp_expiry = date("Y-m-d H:i:s", strtotime("+1 minute"));

        $userQry = "SELECT * FROM tbl_users WHERE number = ? AND flag = 1;";
        $user = $this->db->query($userQry, [$number])->getRow();

        $emailQry = "SELECT * FROM tbl_users WHERE email = ? AND flag = 1;";
        $emailExists = $this->db->query($emailQry, [$email])->getRow();


        if ($user && $user->is_verfied == 1) {
            return json_encode([
                'code' => 400,
                'message' => 'The mobile number has already been registered'
            ]);
        }

        if ($emailExists && $emailExists->is_verfied == 1) {
            return json_encode([
                'code' => 400,
                'message' => 'The Email has already been registered'
            ]);
        }

        //  If user exists but not verified 
        if ($user && $user->is_verfied == 0) {
            $userID = $this->session->get('user_id');
            print_r($otp);
            $response = $this->signupAPI($apiKey, $number, $otp, $templateName);
            if ($response['Status'] == "Success") {

                $updateQry = "UPDATE tbl_users SET otp = ?  , otp_expiry = ? WHERE user_id = ?";
                $updateData = $this->db->query($updateQry, [$otp, $otp_expiry, $userID]);

                return $this->signupSessionSMS([
                    'code' => 200,
                    'user_id' => $userID,
                    'username' => $user->username,
                    'message' => 'OTP re-sent. Please verify.'
                ]);
            } else {
                return $this->signupSessionSMS([
                    'code' => 400,
                    'message' => 'Failed to send OTP'
                ]);
            }
        }

        //New user
        $response = $this->signupAPI($apiKey, $number, $otp, $templateName);
        if ($response['Status'] == "Success") {

            $userData = [
                'username' => $username,
                'number' => $number,
                'email' => $email,
                'password' => $passwordHash,
                'otp' => $otp,
                'otp_expiry' => $otp_expiry,
                'is_verfied' => 0,
                'flag' => 1
            ];

            $UserModel->insert($userData);
            $lastInsertID = $this->db->insertID();

            return $this->signupSessionSMS([
                'code' => 200,
                'user_id' => $lastInsertID,
                'username' => $username,
                'message' => 'OTP sent. Please verify.'
            ]);
        } else {
            return $this->signupSessionSMS([
                'code' => 400,
                'message' => 'Failed to send OTP'
            ]);
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

    public function checkSignOTP()
    {

        $OTP = $this->request->getPost('otp');
        $userID = $this->session->get('user_id');
        $data = $this->session->get();

        echo "<pre>";
        print_r($OTP);
        die;

    }

}