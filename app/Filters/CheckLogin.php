<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CheckLogin implements FilterInterface
{
    protected $session;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    public function before(RequestInterface $request, $arguments = null)
    {

        $otp_verify = $this->session->get('otp_verify');
        $login_status = $this->session->get('loginStatus');

        if ($otp_verify == 'YES' && $login_status == 'YES') {
            return true;
        }
        else{
             return redirect()->to('/');
        }


    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing needed here
    }
}
