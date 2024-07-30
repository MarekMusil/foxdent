<?php

namespace App\Controllers\Employee;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Log\LogModel;

use App\Helpers\PaginationHelper;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;
use App\Models\Employee\EmployeeModel;
use CodeIgniter\HTTP\Client;


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
            'employeeType'              => 'permit_empty|numeric',
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
            'rank'      => $inputData['employeeRank'],
            'degree'      => $inputData['employeeDegree'],
            'text'      => $inputData['employeeText'],
            'education'      => $inputData['employeeEducation'],
            'office_hours'      => htmlspecialchars($inputData['employeeOfficeHours']),
            'type'      => $inputData['employeeType'],
        ];

        $__employee = new EmployeeModel;
        $__employee->setData($employeeData);
        if ($__employee->createRecord() === FALSE)
        {
            return $this->respond(NULL, 500, lang('Response.500'));
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
            'employeeType'              => 'permit_empty|numeric',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        if(!isset($inputData['employeeCashdeskId']))
        {
            $inputData['employeeCashdeskId'] = null;
        }

        //$slug = CustomHelper::createSlug($inputData['employeeName']);

        $employeeData = [
            'name'      => $inputData['employeeName'],
            'rank'      => $inputData['employeeRank'],
            'degree'      => $inputData['employeeDegree'],
            'text'      => $inputData['employeeText'],
            'education'      => $inputData['employeeEducation'],
            'office_hours'      => htmlspecialchars($inputData['employeeOfficeHours']),
            'type'      => $inputData['employeeType'],
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

    public function uploadPhoto($employeeId)
    {
        $__employee = new EmployeeModel;

        if ($__employee->existsId($employeeId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }
        
        $__employee->setEmployeeId($employeeId);

        $uploadDirectory = '../assets/images/employees/';

        $file = $_FILES['file'];

        $destinationPath = $uploadDirectory . 'employee'.$employeeId . '.jpg';
        move_uploaded_file($file['tmp_name'], $destinationPath);

        return $this->respond(null, 200, lang('Response.200'));

    }
}