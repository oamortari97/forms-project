<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use App\Controllers\ApiController;

class ApiAuth implements FilterInterface
{
    private $apiController;

    public function __construct()
    {
        $this->apiController = new ApiController;
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        return $this->apiController->checkToken();
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
