<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use App\Controllers\UserController;

class AdminAuth implements FilterInterface
{
    private $userController;

    public function __construct()
    {
        $this->userController = new UserController;
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$this->userController->isLoggedIn() || !$this->userController->isAdmin()) {
            return redirect()->to('/login');
        };
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
