<?php

namespace App\Controllers\Slide;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Log\LogModel;
use CodeIgniter\Files\File;

use App\Helpers\PaginationHelper;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;
use App\Models\Slide\SlideModel;
use CodeIgniter\HTTP\Client;
use App\Helpers\CustomHelper;
use App\Models\System\SingleFileModel;

class SlideController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function detail($slideId)
    {
        $__slide = new SlideModel;

        if ($__slide->existsId($slideId) === FALSE)
        {         
            return $this->respond(FALSE, 404, lang('Response.404'));  
        }
        
        $__slide->setSlideId($slideId);
        $slide = $__slide->getRecord();

        $data['slide'] = $slide;

        return $this->respond($data, 200, lang('Response.200'));
    }

    public function get(): object
    {
        $module = 'slides';
        $__slide = new SlideModel;

        if ($this->request->getGet('active') == 1 || $this->request->getGet('active') == 0)
        {
            $__slide->setActive($this->request->getGet('active'));
        }

        $pagination = PaginationHelper::createPagination($this->request, $__slide, 'rank', 'ASC');
        $slides = $__slide->getRecord();

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
            'records'      => array_values($slides),
            'columns'       => $columns,
            'buttons'       => $buttons
        ];
        
        return $this->respond($data, 200, lang('Response.200')); 
    }

    public function create()
    {
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'slideRank'     => 'permit_empty|numeric|less_than_equal_to[255]',
            'slideTitle'    => 'required|max_length[100]',
            'slideButton1'  => 'permit_empty|max_length[50]',
            'slideButton2'  => 'permit_empty|max_length[50]',
            'slideText'     => 'permit_empty|',
            'slideActive'   => 'required|in_list[0,1]',
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

        $slideData = [
            'rank'      => $inputData['slideRank'],
            'title'      => $inputData['slideTitle'],
            'button_1'      => $inputData['slideButton1'],
            'button_2'      => $inputData['slideButton2'],
            'text'      => $inputData['slideText'],
            'active'      => $inputData['slideActive'],
        ];

        $__slide = new SlideModel;
        $__slide->setData($slideData);
        if ($__slide->createRecord() === FALSE)
        {
            return $this->respond(NULL, 500, lang('Response.500'));
        }

        if (isset($inputData['slidePhotoTransaction']))
        {
            $this->assignPhoto($inputData['slidePhotoTransaction'], $__slide->getSlideId());
        }

        $responseData = [
            'slide' => [
                'id' => $__slide->getSlideId(),
            ],
            'redirectUrl'  => '/slides/'.$__slide->getSlideId()
        ];
        
        return $this->respond($responseData, 201, lang('Response.201'));
    }

    public function update($slideId)
    {
        $__slide = new SlideModel;
        if ($__slide->existsId($slideId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'slideRank'     => 'permit_empty|numeric|less_than_equal_to[255]',
            'slideTitle'    => 'required|max_length[100]',
            'slideButton1'  => 'permit_empty|max_length[50]',
            'slideButton2'  => 'permit_empty|max_length[50]',
            'slideText'     => 'permit_empty|',
            'slideActive'   => 'required|in_list[0,1]',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        $slideData = [
            'rank'      => $inputData['slideRank'],
            'title'      => $inputData['slideTitle'],
            'button_1'      => $inputData['slideButton1'],
            'button_2'      => $inputData['slideButton2'],
            'text'      => $inputData['slideText'],
            'active'      => $inputData['slideActive'],
        ];

        $__slide = new SlideModel;
        $__slide->setData($slideData);
        $__slide->setSlideId($slideId);
        if ($__slide->updateRecord() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }
        
        return $this->respond(null, 200, lang('Response.200'));
    }

    public function uploadPhoto($slideId = NULL)
    {
        $transaction = NULL;
        
        if(!is_null($slideId))
        {
            $__slide = new SlideModel;

            if ($__slide->existsId($slideId) === FALSE)
            {
                return $this->respond(null, 404, lang('Response.404'));
            }

            $token = CustomHelper::generateToken('alnum', 6);
            $uploadDirectory = '../assets/images/slides/';
            $name = 'slide' . $slideId . '-' . $token;
        }
        else
        {
            $token = CustomHelper::generateToken('alnum', 6);
            $transaction = CustomHelper::generateToken('alnum', 100);
            $uploadDirectory = '../temp/';
            $name = 'newSlide-'.$token;
        }

        $file = $_FILES['file'];
        $fileType = '.jpg';

        $singleFileData = [
            'slide_id'  => $slideId,
            'name'      => $name,
            'type'      => $fileType,
            'path'      => $uploadDirectory,
            'transaction' => $transaction
        ];

        $singleFile = new SingleFileModel;
        $singleFile->setData($singleFileData);
        
        if($singleFile->createRecord() === TRUE)
        {
            $destinationPath = $uploadDirectory . $name . $fileType;
            move_uploaded_file($file['tmp_name'], $destinationPath);
        }

        $data['newPhotoImgUrl'] = base_url() . $destinationPath;
        $data['slidePhotoTransaction'] = $transaction;

        return $this->respond($data, 200, lang('Response.200'));
    }

    public function assignPhoto($transaction, $slideId)
    {
        $newFolder = '../assets/images/slides/';
        $__singleFile = new SingleFileModel;
        $__singleFile->setTransaction($transaction);
        $singleFile = $__singleFile->getRecord();
        $singleFile = array_shift($singleFile);

        $token = CustomHelper::generateToken('alnum', 6);
        $newName = 'slide' . $slideId . '-' . $token;

        $filePath = FCPATH . $singleFile['path'] . $singleFile['name'] . $singleFile['type'];
        $newFilePath = FCPATH . $newFolder . $newName . $singleFile['type'];

        if (file_exists($filePath) && is_file($filePath))
        {
            $file = new File($filePath);
            $file->move(FCPATH . $newFolder, $newName.$singleFile['type']);
        }
        else
        {
            echo "neexistující soubor";exit;
        }

        $newFileData = [
            'slide_id'      => $slideId,
            'name'          => $newName,
            'path'          => $newFolder
        ];

        $__singleFile->setSingleFileId($singleFile['id']);
        $__singleFile->setData($newFileData);
        $__singleFile->updateRecord();

        return $this->respond(null, 200, lang('Response.200'));
    }
}