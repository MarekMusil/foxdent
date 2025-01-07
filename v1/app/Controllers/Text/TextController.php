<?php

namespace App\Controllers\Text;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Log\LogModel;

use App\Helpers\PaginationHelper;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;
use App\Models\Text\TextModel;
use App\Models\ContactData\ContactDataModel;
use CodeIgniter\HTTP\Client;
use App\Helpers\CustomHelper;
use App\Models\System\SingleFileModel;

class TextController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function detail($textTranslationId)
    {
        $__text = new TextModel;

        if ($__text->existsTextTranslationId($textTranslationId) === FALSE)
        {         
            return $this->respond(FALSE, 404, lang('Response.404'));  
        }
        
        $__text->setTextTranslationId($textTranslationId);
        $__text->setLocalization(NULL);
        $text = $__text->getRecord();

        $data['text'] = $text;

        return $this->respond($data, 200, lang('Response.200'));
    }

    public function get(): object
    {
        $module = 'texts';
        $__text = new TextModel;
        $__text->setPageLimit(NULL);
        $__text->setAppType($this->clientAppName);

        if ($this->request->getGet('textType'))
        {
            $__text->setTextType($this->request->getGet('textType'));
        }

        if ($this->request->getGet('localization'))
        {
            $__text->setLocalization($this->request->getGet('localization'));
        }

        $pagination = PaginationHelper::createPagination($this->request, $__text, 'texts_translations.id', 'ASC');
        $texts = $__text->getRecord();

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
            'records'      => array_values($texts),
            'columns'       => $columns,
            'buttons'       => $buttons
        ];
        
        return $this->respond($data, 200, lang('Response.200')); 
    }

    public function getServices(): object
    {
        return $this->getByType(1);
    }

    public function getTechnologies(): object
    {
        return $this->getByType(2);
    }

    public function getByType($typeId)
    {
        $module = 'texts';
        $__text = new TextModel;
        $__text->setPageLimit(NULL);
        $__text->setTextType($typeId);
        $__text->setFormat('only-texts');
        $__text->setAppType($this->clientAppName);
        $__text->setSortBy('rank');
        $__text->setSortOrder('ASC');
        $__text->setAppType($this->clientAppName);
        $texts = $__text->getRecord();

        $data = [
            'records'      => array_values($texts),
        ];
        
        return $this->respond($data, 200, lang('Response.200')); 
    }

    public function create()
    {
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'textRank'              => 'permit_empty|numeric|less_than_equal_to[255]',
            'textTextId'            => 'required',
            'textTitle'             => 'required|max_length[100]',
            'textSubtitle'          => 'permit_empty|max_length[255]',
            'textContent'           => 'permit_empty',
            'textLocalization'      => 'required',
            'textMetaTitle'         => 'permit_empty|max_length[100]',
            'textMetaDescription'   => 'permit_empty|max_length[100]',
            'textMetaKeywords'      => 'permit_empty|max_length[100]',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        $__text = new TextModel;
        if ($__text->isValidTypeForText($inputData['textTextId'], $inputData['textType']) == FALSE)
        {
            $data['errors']['textTextId']='Neexistující text ke zvolenému typu';
            return $this->respond($data, 422, lang('Response.422'));
        }

        if ($__text->existsTransaltionForText($inputData['textTextId'], $inputData['textLocalization']) == TRUE)
        {
            
            $data['errors']['textTitle']='Daná lokalizace pro daný text již existuje';
            return $this->respond($data, 422, lang('Response.422'));
        }

        $textTranslationData = [
            'text_id'           => strip_tags($inputData['textTextId']),
            'title'             => strip_tags($inputData['textTitle']),
            'subtitle'          => strip_tags($inputData['textSubtitle']),
            'localization'      => strip_tags($inputData['textLocalization']),
            'content'           => htmlspecialchars($inputData['textContent']),
            'meta_title'        => strip_tags($inputData['textMetaTitle']),
            'meta_description'  => strip_tags($inputData['textMetaDescription']),
            'meta_keywords'     => strip_tags($inputData['textMetaKeywords']),
        ];

        $__text = new TextModel;
        $__text->setData($textTranslationData);
        if ($__text->createRecord() === FALSE)
        {
            return $this->respond(NULL, 500, lang('Response.500'));
        }

        $responseData = [
            'text' => [
                'id' => $__text->getTextId(),
            ],
            'redirectUrl'  => '/texts/'.$__text->getTextId()
        ];
        
        return $this->respond($responseData, 201, lang('Response.201'));
    }

    public function update($textTranslationId)
    {
        $__text = new TextModel;
        if ($__text->existsTextTranslationId($textTranslationId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'textRank'              => 'permit_empty|numeric|less_than_equal_to[255]',
            'textTitle'             => 'required|max_length[100]',
            'textSubtitle'          => 'permit_empty|max_length[255]',
            'textContent'           => 'permit_empty',
            'textLocalization'      => 'required',
            'textMetaTitle'         => 'permit_empty|max_length[100]',
            'textMetaDescription'   => 'permit_empty|max_length[100]',
            'textMetaKeywords'      => 'permit_empty|max_length[100]',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        isset($inputData['textMetaTitle']) ? strip_tags($inputData['textMetaTitle']) : $inputData['textMetaTitle'] = '';
        isset($inputData['textMetaDescription']) ? strip_tags($inputData['textMetaDescription']) : $inputData['textMetaDescription'] ='';
        isset($inputData['textMetaKeywords']) ? strip_tags($inputData['textMetaKeywords']) : $inputData['textMetaKeywords'] = '';


        $textTranslationData = [
            'text_id'           => strip_tags($inputData['textTextId']),
            'title'             => strip_tags($inputData['textTitle']),
            'subtitle'          => strip_tags($inputData['textSubtitle']),
            'localization'      => strip_tags($inputData['textLocalization']),
            'content'           => htmlspecialchars($inputData['textContent']),
            'meta_title'        => $inputData['textMetaTitle'],
            'meta_description'  => $inputData['textMetaDescription'],
            'meta_keywords'     => $inputData['textMetaKeywords'],
        ];

        $textData = [
            'rank' => $inputData['textRank'],

        ];

        $__text = new TextModel;
        $__text->setData($textTranslationData);
        $__text->setTextTranslationId($textTranslationId);
        if ($__text->updateRecord() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }

        $__text->setData($textData);
        $__text->setTextId($inputData['textTextId']);
        if ($__text->updateTextRecord() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }
        
        return $this->respond(null, 200, lang('Response.200'));
    }

    public function uploadPhoto($textId)
    {
        $__text = new TextModel;

        if ($__text->existsId($textId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }
        
        $__text->setTextId($textId);

        $uploadDirectory = '../assets/images/texts/';

        $file = $_FILES['file'];

        $destinationPath = $uploadDirectory . $textId . '.png';
        move_uploaded_file($file['tmp_name'], $destinationPath);

        return $this->respond(null, 200, lang('Response.200'));

    }

    public function updateServices()
    {
        $result = $this->updateByType(1);

        if ($result === TRUE)
        {
            return $this->respond(NULL, 200, lang('Response.200'));
        }
        elseif(is_array($result))
        {
            return $this->respond($result, 422, lang('Response.422'));
        }
        elseif($result == 'itemsError')
        {
            return $this->respond('Není zadané pole s položkami', 422, lang('Response.422'));
        }
        else
        {
            return $this->respond(FALSE, 400, lang('Response.400'));            
        }
    }

    public function updateTechnologies()
    {
        $result = $this->updateByType(2);

        if ($result === TRUE)
        {
            return $this->respond(NULL, 200, lang('Response.200'));
        }
        elseif(is_array($result))
        {
            return $this->respond($result, 422, lang('Response.422'));
        }
        elseif($result == 'itemsError')
        {
            return $this->respond('Není zadané pole s položkami', 422, lang('Response.422'));
        }
        else
        {
            return $this->respond(FALSE, 400, lang('Response.400'));            
        }
    }

    private function updateByType($typeId)
    {
        $inputData =  $this->request->getJSON(TRUE);
        $validation = \Config\Services::validation();

        if (!isset($inputData['items']))
		{
			return 'itemsError'; 
		}

        foreach ($inputData['items'] as $i => $item)
        {
            $validation->reset();
            $validationRules = [
                'id' => 'permit_empty',
                'rank' => 'permit_empty|numeric|less_than_equal_to[255]',
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
            return $allErrorData;
        }

        $__text = new TextModel;
        $__text->setData($inputData['items']); 

        if ($__text->updateTextRecordByType($typeId) === FALSE)
        {
            return FALSE;
        }

        return TRUE;
    }

    public function uploadTechnologyPhoto($textTranslationId = NULL)
    {
        $technologyId = NULL;
        $transaction = NULL;

        if(!is_null($textTranslationId))
        {
            $__text = new TextModel;

            if ($__text->existsTextTranslationId($textTranslationId, 0) === FALSE)
            {
                return $this->respond(null, 404, lang('Response.404'));
            }

            if ($__text->isTextTransaltionIdTechnology($textTranslationId, 0) === FALSE)
            {         
                return $this->respond(FALSE, 400, lang('Response.400'));  
            }

            $__text->setTextTranslationId($textTranslationId);
            $technology = $__text->getRecord();
            $technologySlug = CustomHelper::createSlug($technology['name']);

            $token = CustomHelper::generateToken('alnum', 4);
            $uploadDirectory = 'assets/images/technologies/';
            $name = $technologySlug . '-' . $token;

            $technologyId = $technology['textId'];
        }
        else
        {
            $token = CustomHelper::generateToken('alnum', 4);
            $transaction = CustomHelper::generateToken('alnum', 100);
            $uploadDirectory = 'temp/';
            $name = 'new-unknown-'.$token;
        }
        
        $file = $_FILES['file'];
        $fileType = '.jpg';

        $singleFileData = [
            'text_technology_id'    => $technologyId,
            'name'                  => $name,
            'type'                  => $fileType,
            'path'                  => $uploadDirectory,
            'transaction'           => $transaction,
        ];

        $singleFile = new SingleFileModel;
        $singleFile->setData($singleFileData);
        
        if($singleFile->createRecord() === TRUE)
        {
            $destinationPath = '../' . $uploadDirectory . $name . $fileType;
            move_uploaded_file($file['tmp_name'], $destinationPath);
        }

        $data['newPhotoImgUrl'] = base_url() . $destinationPath;
        $data['technologyPhotoTransaction'] = $transaction;

        return $this->respond($data, 200, lang('Response.200'));

    }
}