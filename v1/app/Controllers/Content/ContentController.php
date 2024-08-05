<?php

namespace App\Controllers\Content;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Log\LogModel;

use App\Helpers\PaginationHelper;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;
use App\Models\Text\TextModel;
use App\Models\Pricelist\PricelistModel;
use App\Models\Insurance\InsuranceModel;
use App\Models\System\SystemUpdateModel;
use App\Models\ContactData\ContactDataModel;
use CodeIgniter\HTTP\Client;


class ContentController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function check()
    {
        $__systemUpdate = new SystemUpdateModel;
        $systemUpdateTime = $__systemUpdate->getRecord();
        return $this->respond($systemUpdateTime, 200, lang('Response.200')); 
    }

    public function get()
    {
        if ($this->request->getGet('localization'))
        {
            $localization = $this->request->getGet('localization');
        }
        else
        {
            $localization = 'cs_CZ';
        }
        
        $module = 'texts';
        $viewMethod = '';
        $__text = new TextModel;
        $__text->setPageLimit(NULL);
        $__text->setSortBy('rank');
        $__text->setSortOrder('ASC');
        $__text->setFormat('groupByType');
        $__text->setActive(1);
        $texts = $__text->getRecord();

        $__contactData = new ContactDataModel;
        $contactData = $__contactData->getRecord();

        $__pricelist = new PricelistModel;
        $__pricelist->setPageLimit(NULL);
        $__pricelist->setSortBy('rank');
        $__pricelist->setSortOrder('ASC');
        $pricelists = $__pricelist->getRecord();

        $__insurance = new InsuranceModel;
        $insurances = $__insurance->getRecord();

        $data = [
            'services' => array_values($texts['services']),
            'technologies' => array_values($texts['technologies']),
            'others' => $texts['others'],
            'contactData' => $contactData,
            'pricelist' => array_values($pricelists),
            'insurances' => array_values($insurances),
        ];
                
        return $this->respond($data, 200, lang('Response.200')); 
    }

    public function create()
    {
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'contentName'              => 'required|min_length[4]|max_length[100]',
            'contentDegree'            => 'permit_empty|max_length[6]',
            'contentText'              => 'permit_empty|max_length[100]',
            'contentEducation'         => 'permit_empty|max_length[100]',
            'contentOfficeHours'       => 'permit_empty|max_length[255]',
            'contentType'              => 'permit_empty|numeric',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        foreach ($validationRules as $inputName => $rule)
        {
            if (!isset($inputData[$inputName]) || $inputData[$inputName] == "")
            {
                $inputData[$inputName] = NULL;
            }
        }

        $contentData = [
            'name'      => $inputData['contentName'],
            'degree'      => $inputData['contentDegree'],
            'text'      => $inputData['contentText'],
            'education'      => $inputData['contentEducation'],
            'office_hours'      => htmlspecialchars($inputData['contentOfficeHours']),
            'type'      => $inputData['contentType'],
        ];

        $__content = new ContentModel;
        $__content->setData($contentData);
        if ($__content->createRecord() === FALSE)
        {
            return $this->respond(NULL, 500, lang('Response.500'));
        }

        $responseData = [
            'content' => [
                'id' => $__content->getContentId(),
            ],
            'redirectUrl'  => '/contents/'.$__content->getContentId()
        ];
        
        return $this->respond($responseData, 201, lang('Response.201'));
    }

    public function update($contentId)
    {
        $__content = new ContentModel;
        if ($__content->existsId($contentId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'contentName'              => 'required|min_length[4]|max_length[100]',
            'contentDegree'            => 'permit_empty|max_length[6]',
            'contentText'              => 'permit_empty|max_length[100]',
            'contentEducation'         => 'permit_empty|max_length[100]',
            'contentOfficeHours'       => 'permit_empty|max_length[255]',
            'contentType'              => 'permit_empty|numeric',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        if(!isset($inputData['contentCashdeskId']))
        {
            $inputData['contentCashdeskId'] = null;
        }

        //$slug = CustomHelper::createSlug($inputData['contentName']);

        $contentData = [
            'name'      => $inputData['contentName'],
            'degree'      => $inputData['contentDegree'],
            'text'      => $inputData['contentText'],
            'education'      => $inputData['contentEducation'],
            'office_hours'      => htmlspecialchars($inputData['contentOfficeHours']),
            'type'      => $inputData['contentType'],
        ];

        $__content = new ContentModel;
        $__content->setData($contentData);
        $__content->setContentId($contentId);
        if ($__content->updateRecord() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }
        
        return $this->respond(null, 200, lang('Response.200'));
    }

    public function uploadPhoto($contentId)
    {
        $__content = new ContentModel;

        if ($__content->existsId($contentId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }
        
        $__content->setContentId($contentId);

        $uploadDirectory = '../assets/images/contents/';

        $file = $_FILES['file'];

        $destinationPath = $uploadDirectory . $contentId . '.png';
        move_uploaded_file($file['tmp_name'], $destinationPath);

        return $this->respond(null, 200, lang('Response.200'));

    }
}