<?php

namespace App\Controllers\ImportantMessage;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Log\LogModel;

use App\Helpers\PaginationHelper;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;
use App\Models\ImportantMessage\ImportantMessageModel;
use CodeIgniter\HTTP\Client;


class ImportantMessageController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function get()
    {
        $__importantMessage = new ImportantMessageModel; 
        $importantMessage = $__importantMessage->getRecord();
        $data['importantMessage'] = $importantMessage;
        return $this->respond($data, 200, lang('Response.200'));
    }

    public function update()
    {
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'importantMessageName'          => 'permit_empty|max_length[200]',
            'importantMessageIsVisible'     => 'permit_empty|in_list[0,1]',
            'importantMessageContent'       => 'permit_empty|max_length[1000]',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        $importantMessage = [
            'name'         => $inputData['importantMessageName'],
            'is_visible'   => $inputData['importantMessageIsVisible'],
            'content'      => htmlspecialchars($inputData['importantMessageContent']),
        ];

        $__importantMessage = new ImportantMessageModel; 
        $__importantMessage->setData($importantMessage);
        if ($__importantMessage->updateRecord() === FALSE)
        {
            return $this->respond(NULL, 500, lang('Response.500'));
        }

        return $this->respond(null, 200, lang('Response.200'));
    }
}