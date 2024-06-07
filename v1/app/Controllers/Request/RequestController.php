<?php
namespace App\Controllers\Request;
use CodeIgniter\Controller;
use App\Controllers\BaseController;

class RequestController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function __destruct()
    {
        exit;
    }

    public function index()
    {
        return $this->respond(null, 200, lang('Response.200'));
    }
}