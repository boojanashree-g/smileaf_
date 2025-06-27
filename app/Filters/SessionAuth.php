<?php

namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;
class SessionAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $token = $session->get('jwt') ?? $session->get('user_id');

     
        if (!$token) {
            return redirect()->to('/signin?expired=1');
        }

        $secretToken = getenv('JWT_SECRET');
       
        if (!$secretToken) {
            return redirect()->to('/signin?expired=1');
        }

        try {

            JWT::decode($token, new Key($secretToken, 'HS256'));

            return true;
        } catch (\Exception $e) {
            return redirect()->to('/signin?expired=1');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after request
    }


}
