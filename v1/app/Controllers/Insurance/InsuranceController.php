<?php

namespace App\Controllers\Insurance;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Log\LogModel;

use App\Helpers\PaginationHelper;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;
use App\Models\Insurance\InsuranceModel;
use CodeIgniter\HTTP\Client;


class InsuranceController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function get(): object
    {
        $module = 'insurances';
        $__insurance = new InsuranceModel;
        $__insurance->setShowInactive(TRUE);
        $insurances = $__insurance->getRecord();

        $data = [
            'records'      => array_values($insurances),
        ];
        
        return $this->respond($data, 200, lang('Response.200')); 
    }

    public function update()
    {
        $inputData =  $this->request->getJSON(TRUE);
        $validation = \Config\Services::validation();

        if (!isset($inputData['items']))
		{
			return $this->respond('Není nastaveno pole s položkami', 422, lang('Response.422')); 
		}

        foreach ($inputData['items'] as $i => $item)
        {
            $validation->reset();
            $validationRules = [
                'id' => 'required',
                'rank' => 'permit_empty|numeric|less_than_equal_to[255]',
                'active' => 'required|in_list[1,0]',
            ];
    
            $validation->setRules($validationRules);  
    
            if (!$validation->run($item))
            {
                $errors = $validation->getErrors();
                foreach ($errors as $inputName => &$errorText)
                {
                    $allErrorData['errors']['items'][$i.'.errors.'.$inputName] = $errorText;
                }
            }
        }

        if (!empty($allErrorData['errors']))
        {
            return $this->respond($allErrorData, 422, lang('Response.422'));
        }

        $__insurance = new InsuranceModel;
        $__insurance->setData($inputData['items']); 

        if ($__insurance->updateRecord() === FALSE)
        {
            return $this->respond(FALSE, 400, lang('Response.400'));            
            return FALSE;
        }

        return $this->respond(NULL, 200, lang('Response.200'));
    }
}