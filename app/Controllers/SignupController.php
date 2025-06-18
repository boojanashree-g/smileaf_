<?php

namespace App\Controllers;



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

        $username = $this->request->getPost('username');
        $number = $this->request->getPost('number');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');


        $apiKey = $_ENV['SMS_API_KEY'];
        $templateName = $_ENV['SIGNUP_TEMPLATE'];
        $otp = rand(1000, 9999);


        $query = "SELECT COUNT('user_id') AS  count FROM `tbl_users` WHERE `number` = ? AND `flag` = 1";
        $number_count = $this->db->query($query, [$number])->getRow();

        $query1 = "SELECT COUNT('user_id') AS count FROM `tbl_users` WHERE `email` = ? AND `flag` = 1";
        $email_count = $this->db->query($query1, [$email])->getRow();

        if ($number_count->count != 0) {
            $response['code'] = 400;
            $response['msg'] = 'The mobile number has already been registered';
            return json_encode($response);
        } else if ($email_count->count != 0) {
            $response['code'] = 400;
            $response['msg'] = 'The Email has already been registered';
            return json_encode($response);
        } else {
            $response = $this->signupAPI($apiKey, $number, $otp, $templateName);
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


}