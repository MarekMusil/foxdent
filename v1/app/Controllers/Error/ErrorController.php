<?php

namespace App\Controllers\Error;
use CodeIgniter\Controller;
use App\Controllers\BaseController;

class ErrorController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        //echo 'TEst - Error MODEL - construct()';
    }
    
    public function __destruct()
    {
       exit;
    }
    
    public function index405(): object
    {
        //echo '||Test - Error MODEL - index405()';exit;
        $data = NULL;
        return $this->respond($data, 405 , lang('Response.405'));
    }
}
