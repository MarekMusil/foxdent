<?php

namespace App\Controllers\Page;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Log\LogModel;

use App\Helpers\PaginationHelper;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;
use App\Models\Page\PageModel;
use App\Models\ContactData\ContactDataModel;
use CodeIgniter\HTTP\Client;


class PageController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function detail($pageTranslationId)
    {
        $__page = new PageModel;

        if ($__page->existsPageTranslationId($pageTranslationId) === FALSE)
        {         
            return $this->respond(FALSE, 404, lang('Response.404'));  
        }
        
        $__page->setPageTranslationId($pageTranslationId);
        $__page->setLocalization(NULL);
        $page = $__page->getRecord();

        $data['page'] = $page;

        return $this->respond($data, 200, lang('Response.200'));
    }

    public function get(): object
    {
        $module = 'pages';
        $__page = new PageModel;
        $__page->setPageLimit(NULL);
        $__page->setAppType($this->clientAppName);

        if ($this->request->getGet('localization'))
        {
            $__page->setLocalization($this->request->getGet('localization'));
        }

        $pagination = PaginationHelper::createPagination($this->request, $__page, 'pages_translations.id', 'ASC');
        $pages = $__page->getRecord();

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
            'records'      => array_values($pages),
            'columns'       => $columns,
            'buttons'       => $buttons
        ];
        
        return $this->respond($data, 200, lang('Response.200')); 
    }

    public function getPagesStructure()
    {
        $module = 'pages';
        $__page = new PageModel;
        $__page->setPageLimit(NULL);
        $__page->setFormat('only-pages');
        $__page->setAppType($this->clientAppName);
        $__page->setSortBy('rank');
        $__page->setSortOrder('ASC');
        $pages = $__page->getRecord();

        $data = [
            'records'      => array_values($pages),
        ];
        
        return $this->respond($data, 200, lang('Response.200')); 
    }

    public function create()
    {
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'pagePageId'            => 'required',
            'pageName'              => 'required|max_length[100]',
            'pageTitle'             => 'required|max_length[100]',
            'pageMetaTitle'         => 'permit_empty|max_length[200]',
            'pageMetaDescription'   => 'permit_empty|max_length[200]',
            'pageMetaKeywords'      => 'permit_empty|max_length[200]',
            'pageLocalization'      => 'required',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        $__page = new PageModel;

        if ($__page->existsTransaltionForPage($inputData['pagePageId'], $inputData['pageLocalization']) == TRUE)
        {
            
            $data['errors']['pageLocalization']='Daná lokalizace pro stránku již existuje';
            return $this->respond($data, 422, lang('Response.422'));
        }

        $pageTranslationData = [
            'page_id'   => strip_tags($inputData['pagePageId']),
            'name'      => strip_tags($inputData['pageName']),
            'title'      => strip_tags($inputData['pageTitle']),
            'meta_title'      => strip_tags($inputData['pageMetaTitle']),
            'meta_description'      => strip_tags($inputData['pageMetaDescription']),
            'meta_keywords'      => strip_tags($inputData['pageMetaKeywords']),
            'localization'      => strip_tags($inputData['pageLocalization']),
        ];


        $__page = new PageModel;
        $__page->setData($pageTranslationData);
        if ($__page->createRecord() === FALSE)
        {
            return $this->respond(NULL, 500, lang('Response.500'));
        }

        $responseData = [
            'page' => [
                'id' => $__page->getPageId(),
            ],
            'redirectUrl'  => '/pages/'.$__page->getPageId()
        ];
        
        return $this->respond($responseData, 201, lang('Response.201'));
    }

    public function update($pageTranslationId)
    {
        $__page = new PageModel;
        if ($__page->existsPageTranslationId($pageTranslationId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'pagePageId'            => 'required',
            'pageName'              => 'required|max_length[100]',
            'pageTitle'             => 'required|max_length[100]',
            'pageMetaTitle'         => 'permit_empty|max_length[200]',
            'pageMetaDescription'   => 'permit_empty|max_length[200]',
            'pageMetaKeywords'      => 'permit_empty|max_length[200]',
            'pageRank'              => 'permit_empty|numeric|less_than_equal_to[255]',
            'pageLocalization'      => 'required',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        $pageTranslationData = [
            'page_id'   => strip_tags($inputData['pagePageId']),
            'name'      => strip_tags($inputData['pageName']),
            'title'      => strip_tags($inputData['pageTitle']),
            'meta_title'      => strip_tags($inputData['pageMetaTitle']),
            'meta_description'      => strip_tags($inputData['pageMetaDescription']),
            'meta_keywords'      => strip_tags($inputData['pageMetaKeywords']),
            'localization'      => strip_tags($inputData['pageLocalization']),
        ];

        $pageData = [
            'name' => $inputData['pageName'],
            'rank' => $inputData['pageRank'],
        ];

        $__page = new PageModel;
        $__page->setData($pageTranslationData);
        $__page->setPageTranslationId($pageTranslationId);
        if ($__page->updateRecord() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }

        $__page->setData($pageData);
        $__page->setPageId($inputData['pagePageId']);
        if ($__page->updatePageRecord() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }
        
        return $this->respond(null, 200, lang('Response.200'));
    }

    public function uploadPhoto($pageId)
    {
        $__page = new PageModel;

        if ($__page->existsId($pageId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }
        
        $__page->setPageId($pageId);

        $uploadDirectory = '../assets/images/pages/';

        $file = $_FILES['file'];

        $destinationPath = $uploadDirectory . $pageId . '.png';
        move_uploaded_file($file['tmp_name'], $destinationPath);

        return $this->respond(null, 200, lang('Response.200'));

    }

    public function updatePagesStructure()
    {
        $inputData =  $this->request->getJSON(TRUE);
        $validation = \Config\Services::validation();

        if (!isset($inputData['items']))
		{
            return $this->respond(null, 422, 'Není zadné pole s hodnotami');
		}

        foreach ($inputData['items'] as $i => $item)
        {
            $validation->reset();
            $validationRules = [
                'id' => 'permit_empty',
                'rank' => 'required|numeric|less_than_equal_to[255]',
                'name' => 'required|max_length[50]',
                'active' => 'required|in_list[0,1]',
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

        $__page = new PageModel;
        $__page->setData($inputData['items']); 

        if ($__page->updatePageStructureRecord() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }

        return $this->respond(null, 201, lang('Response.201'));
    }
}