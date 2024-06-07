<?php

namespace App\Models\System;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class LogRequestModel extends Model
{   
    private $request;
    private $requestId = NULL;
    protected $table = 'logs_api_request';

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
        $this->db = \Config\Database::connect();
    }

    public function create()
    {        
        $logData = [
            'api_version' => API_VERSION_NUMBER,
            'host' => $this->request->getServer('SERVER_NAME'),
            'ip_address' => $this->request->getServer('REMOTE_ADDR'),           
            'method' => strtoupper($this->request->getMethod()),
            'uri' => $this->request->getServer('REQUEST_URI'),  
            'time' => date('Y-m-d H:i:s')      
        ];
             
        $this->db->transStart();
        $this->db->table($this->table)->insert($logData);
        $this->requestId = $this->db->InsertID();
        $this->db->transComplete();
        
        return TRUE;
    }
}