<?php

namespace App\Controllers\Rating;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Log\LogModel;

use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;
use App\Models\Rating\RatingModel;
use CodeIgniter\HTTP\Client;


class RatingController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function detail($ratingId)
    {
        $__rating = new RatingModel;

        if ($__rating->existsId($ratingId) === FALSE)
        {         
            return $this->respond(FALSE, 404, lang('Response.404'));  
        }
        
        $__rating->setRatingId($ratingId);
        $rating = $__rating->getRecord();

        $data['rating'] = $rating;

        return $this->respond($data, 200, lang('Response.200'));
    }

    public function get(): object
    {
        $module = 'ratings';
        $__rating = new RatingModel;
        $__rating->setPageLimit(NULL);
        $__rating->setSortBy('rank');
        $__rating->setSortOrder('ASC');
        $ratings = $__rating->getRecord();

        $data = [
            'records'      => array_values($ratings),
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
                'text' => 'required|max_length[255]',
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

        $__rating = new RatingModel;
        $__rating->setData($inputData['items']); 

        if ($__rating->updateRecord() === FALSE)
        {
            return $this->respond(FALSE, 400, lang('Response.400'));            
            return FALSE;
        }

        return $this->respond(NULL, 200, lang('Response.200'));
    }
}