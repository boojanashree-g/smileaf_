<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CheckLogin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $otp_verify = $session->get('otp_verify');
        $login_status = $session->get('loginStatus');

            // echo "<prE>";
            // print_r($otp_verify);
            // print_r($login_status);
            // die;


        if ($otp_verify == 'YES' && $login_status == 'YES') {
            return redirect()->to('/');
        }


    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing needed here
    }
}
