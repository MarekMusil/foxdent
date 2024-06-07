<?php

namespace App\Controllers\Pricelist;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Log\LogModel;

use App\Helpers\PaginationHelper;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;
use App\Models\Pricelist\PricelistModel;
use CodeIgniter\HTTP\Client;


class PricelistController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function detail($pricelistId)
    {
        $__pricelist = new PricelistModel;

        if ($__pricelist->existsId($pricelistId) === FALSE)
        {         
            return $this->respond(FALSE, 404, lang('Response.404'));  
        }
        
        $__pricelist->setPricelistId($pricelistId);
        $pricelist = $__pricelist->getRecord();

        $data['pricelist'] = $pricelist;

        return $this->respond($data, 200, lang('Response.200'));
    }

    public function get(): object
    {
        $module = 'pricelists';
        $__pricelist = new PricelistModel;
        $__pricelist->setPageLimit(NULL);
        $__pricelist->setAppType($this->clientAppName);
        $pagination = PaginationHelper::createPagination($this->request, $__pricelist, 'rank', 'ASC');
        $pricelists = $__pricelist->getRecord();

        $columns = [];
        $__column = new ColumnModel;
        if (isset($__column->getColumns()[$module]))
        {
            $columns = $__column->getColumns()[$module];
        }

        $buttons = [];
        $__button = new ButtonModel;

        if (isset($__button->getButtons()[$module]))
        {
            $buttons = $__button->getButtons()[$module];
        }

        $data = [
            'pagination'    => $pagination,
            'records'      => array_values($pricelists),
            'columns'       => $columns,
            'buttons'       => $buttons
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
                'id' => 'permit_empty',
                'rank' => 'permit_empty|numeric|less_than_equal_to[255]',
                'name' => 'required|max_length[100]',
                'price' => 'required',
                'note' => 'permit_empty',
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

        $__pricelist = new PricelistModel;
        $__pricelist->setData($inputData['items']); 

        if ($__pricelist->updateRecord() === FALSE)
        {
            return $this->respond(FALSE, 400, lang('Response.400'));            
            return FALSE;
        }

        return $this->respond(NULL, 200, lang('Response.200'));
    }
}