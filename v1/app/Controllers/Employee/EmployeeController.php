<?php

namespace App\Controllers\Employee;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Log\LogModel;
use CodeIgniter\Files\File;

use App\Helpers\PaginationHelper;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;
use App\Models\Employee\EmployeeModel;
use CodeIgniter\HTTP\Client;
use App\Helpers\CustomHelper;
use App\Models\System\SingleFileModel;

class EmployeeController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function detail($employeeId)
    {
        $__employee = new EmployeeModel;

        if ($__employee->existsId($employeeId) === FALSE)
        {         
            return $this->respond(FALSE, 404, lang('Response.404'));  
        }
        
        $__employee->setEmployeeId($employeeId);
        $employee = $__employee->getRecord();

        $data['employee'] = $employee;

        return $this->respond($data, 200, lang('Response.200'));
    }

    public function get(): object
    {
        $module = 'employees';
        $__employee = new EmployeeModel;

        if ($this->request->getGet('employeeType'))
        {
            $__employee->setEmployeeType($this->request->getGet('employeeType'));
        }

        if ($this->request->getGet('active') == 1 || $this->request->getGet('active') == 0)
        {
            $__employee->setActive($this->request->getGet('active'));
        }

        $pagination = PaginationHelper::createPagination($this->request, $__employee, 'rank', 'ASC');
        $employees = $__employee->getRecord();

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
            'records'      => array_values($employees),
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
            'employeeName'              => 'required|min_length[4]|max_length[100]',
            'employeeRank'              => 'permit_empty|numeric|less_than_equal_to[255]',
            'employeeDegree'            => 'permit_empty|max_length[6]',
            'employeeText'              => 'permit_empty|max_length[100]',
            'employeeEducation'         => 'permit_empty|max_length[100]',
            'employeeOfficeHours'       => 'permit_empty|max_length[255]',
            'employeeType'              => 'permit_empty|in_list[1,2,3]',
            'employeeActive'            => 'required|in_list[0,1]',
            'employeePhotoTransaction'  => 'permit_empty|exact_length[100]',
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

        $employeeData = [
            'name'      => $inputData['employeeName'],
            'rank'      => $inputData['employeeRank'] ?? 1,
            'degree'      => $inputData['employeeDegree'] ?? '',
            'text'      => $inputData['employeeText'] ?? '',
            'education'      => $inputData['employeeEducation'] ?? '',
            'office_hours'      => htmlspecialchars($inputData['employeeOfficeHours']),
            'type'      => $inputData['employeeType'],
            'active'      => $inputData['employeeActive'],
        ];

        $__employee = new EmployeeModel;
        $__employee->setData($employeeData);
        if ($__employee->createRecord() === FALSE)
        {
            return $this->respond(NULL, 500, lang('Response.500'));
        }

        if (isset($inputData['employeePhotoTransaction']))
        {
            $this->assignPhoto($inputData['employeePhotoTransaction'], $__employee->getEmployeeId());
        }

        $responseData = [
            'employee' => [
                'id' => $__employee->getEmployeeId(),
            ],
            'redirectUrl'  => '/employees/'.$__employee->getEmployeeId()
        ];
        
        return $this->respond($responseData, 201, lang('Response.201'));
    }

    public function update($employeeId)
    {
        $__employee = new EmployeeModel;
        if ($__employee->existsId($employeeId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'employeeName'              => 'required|min_length[4]|max_length[100]',
            'employeeRank'              => 'permit_empty|numeric|less_than_equal_to[255]',
            'employeeDegree'            => 'permit_empty|max_length[6]',
            'employeeText'              => 'permit_empty|max_length[100]',
            'employeeEducation'         => 'permit_empty|max_length[100]',
            'employeeOfficeHours'       => 'permit_empty|max_length[255]',
            'employeeType'              => 'permit_empty|in_list[1,2,3]',
            'employeeActive'            => 'required|in_list[0,1]',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        //$slug = CustomHelper::createSlug($inputData['employeeName']);

        $employeeData = [
            'name'      => $inputData['employeeName'],
            'rank'      => $inputData['employeeRank'] ?? 1,
            'degree'      => $inputData['employeeDegree'] ?? '',
            'text'      => $inputData['employeeText'],
            'education'      => $inputData['employeeEducation'],
            'office_hours'      => htmlspecialchars($inputData['employeeOfficeHours']),
            'type'      => $inputData['employeeType'],
            'active'      => $inputData['employeeActive'],
        ];

        $__employee = new EmployeeModel;
        $__employee->setData($employeeData);
        $__employee->setEmployeeId($employeeId);
        if ($__employee->updateRecord() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }
        
        return $this->respond(null, 200, lang('Response.200'));
    }

    public function uploadPhoto($employeeId = NULL)
    {
        $transaction = NULL;
        if(!is_null($employeeId))
        {
            $__employee = new EmployeeModel;

            if ($__employee->existsId($employeeId) === FALSE)
            {
                return $this->respond(null, 404, lang('Response.404'));
            }

            $token = CustomHelper::generateToken('alnum', 6);
            $uploadDirectory = '../assets/images/employees/';
            $name = 'employee' . $employeeId . '-' . $token;
        }
        else
        {
            $token = CustomHelper::generateToken('alnum', 6);
            $transaction = CustomHelper::generateToken('alnum', 100);
            $uploadDirectory = '../temp/';
            $name = 'newEmployee-'.$token;
        }
        
        $file = $_FILES['file'];
        $fileType = '.jpg';

        $singleFileData = [
            'employee_id'   => $employeeId,
            'name'          => $name,
            'type'          => $fileType,
            'path'          => $uploadDirectory,
            'transaction'   => $transaction,
        ];

        $singleFile = new SingleFileModel;
        $singleFile->setData($singleFileData);
        
        if($singleFile->createRecord() === TRUE)
        {
            $destinationPath = $uploadDirectory . $name . $fileType;
            move_uploaded_file($file['tmp_name'], $destinationPath);
        }

        $data['newPhotoImgUrl'] = base_url() . $destinationPath;
        $data['employeePhotoTransaction'] = $transaction;

        return $this->respond($data, 200, lang('Response.200'));

    }

    public function assignPhoto($transaction, $employeeId)
    {
        $newFolder = '../assets/images/employees/';
        $__singleFile = new SingleFileModel;
        $__singleFile->setTransaction($transaction);
        $singleFile = $__singleFile->getRecord();
        $singleFile = array_shift($singleFile);

        $token = CustomHelper::generateToken('alnum', 6);
        $newName = 'employee' . $employeeId . '-' . $token;

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
            'employee_id'   => $employeeId,
            'name'          => $newName,
            'path'          => $newFolder
        ];

        $__singleFile->setSingleFileId($singleFile['id']);
        $__singleFile->setData($newFileData);
        $__singleFile->updateRecord();

        return $this->respond(null, 200, lang('Response.200'));
    }
}