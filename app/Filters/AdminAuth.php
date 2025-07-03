<?php

namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {


        $session = session();
        $isLogin = $session->get();

        $isLogin = $session->get('admin_login');

        if (!$isLogin) {
            return redirect()->to('admin');
        }
        return true;

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }


}
