<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use App\Controllers\UserController;

class UserAuth implements FilterInterface
{
    private $userController;

    public function __construct()
    {
        $this->userController = new UserController;
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        if(!$this->userController->isLoggedIn()) {
            return redirect()->to('/login');
        };
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
