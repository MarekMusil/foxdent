<?php

namespace App\Models\Employee;

use CodeIgniter\Model;
use App\Models\System\SystemUpdateModel;
use App\Models\System\SingleFileModel;
use DateTime;
helper('filesystem');
helper('file');
//use App\Helpers\CustomHelper;

class EmployeeModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function __destruct()
    {
        
    }

    private $accessRules = FALSE;
    private $active = NULL;
    private $appType = NULL;
    private $employeeId = NULL;
    private $employeesId = NULL;
    private $employeeType = NULL;
    private $data = NULL;
    private $debugMode = FALSE;
    private $format = NULL;
    private $onlyCount = FALSE;
    private $pageLimit = 10;
    private $pageNumber = 1;
    private $removed = NULL;
    private $searchQuery = NULL;
    private $sortBy = 'id';
    private $sortOrder = 'ASC';
    private $withRemoved = FALSE;
    protected $sortByOptions = ['id', 'rank'];
    protected $sortOrderOptions = ['ASC', 'DESC'];
    protected $table = 'employees';

    public function getPageLimit()
    {
        return $this->pageLimit;
    }
    
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    public function setActive($bool)
    {
        $this->active = $bool;
    }

    public function setAppType($bool)
    {
        $this->appType = $bool;
    }

    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    public function setEmployeesId($employeesId)
    {
        $this->employeesId = $employeesId;
    }

    public function setEmployeeType($employeeType)
    {
        $this->employeeType = $employeeType;
    }
    
    public function setData($data)
    {
        $this->data = $data;
    }
    
    public function setDebugMode($bool)
    {
        $this->debugMode = $bool;
    }
    
    public function setFormat($format)
    {
        $this->format = $format;
    }
    
    public function setOnlyCount($bool)
    {
        $this->onlyCount = $bool;
    }
    
    public function setPageLimit($pageLimit)
    {
        $this->pageLimit = $pageLimit;
    }
    
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;
    }
    
    public function setRemoved($bool)
    {
        $this->removed = $bool;
    }
    
    public function setSearchQuery($searchQuery)
    {
        $this->searchQuery = $searchQuery;
    }
    
    public function setSortBy($by)
    {
        if (in_array($by, $this->sortByOptions))
        {
            $this->sortBy = $by;
        }
    }
    
    public function setSortOrder($order)
    {
        if (in_array($order, $this->sortOrderOptions))
        {
            $this->sortOrder = $order;
        }
    }
    
    public function setWithRemoved($bool)
    {
        $this->withRemoved = $bool;
    }
    
    public function existsId($employeeId, $removed = 0)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $employeeId);
        $builder->where('removed', $removed);
        $q = $builder->get()->getResult();

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        
        if (count($q) == 1)
        {
            return TRUE;
        }
        
        return FALSE;        
    }

    public function getRecord()
    {
        $builder = $this->db->table($this->table);
        $employees = [];

        if ($this->onlyCount === FALSE)
        {
            $builder->select('*');            
        }
        else
        {
            $builder->select('COUNT(id) AS count');
        }        

        if (!is_null($this->employeeId))  
        {
            $builder->where('id', $this->employeeId);
        }

        if (!is_null($this->employeesId))  
        {
            $builder->whereIn('id', $this->employeesId);
        }

        if (!is_null($this->employeeType))  
        {
            $builder->where('type', $this->employeeType);
        }

        if (!is_null($this->searchQuery))
        {
            $builder->like('name', $this->searchQuery);
        }

        if (!is_null($this->active))
        {
            $builder->where('active', $this->active);
        }

        if ($this->accessRules === TRUE && !is_null($this->employeesId))
        {
            $builder->whereIn('id', $this->employeesId);
        }

        if (!is_null($this->removed))
        {
            $builder->where('removed', $this->removed);
        }
        else
        {
            if ($this->withRemoved === FALSE)
            {
                $builder->where('removed', 0);
            }
        }

        if ($this->onlyCount === FALSE && !is_null($this->pageLimit))
        {
            $builder->limit($this->pageLimit, ($this->pageNumber * $this->pageLimit) - $this->pageLimit);
        }

        $builder->orderBy($this->sortBy, $this->sortOrder);    

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }

        $q = $builder->get()->getResult();

        if ($this->onlyCount === TRUE)
        {
            return $q[0]->count;
        }

        if (count($q) > 0)
        {
            if ($this->format === 'select-option')
            {
                foreach ($q as $row)
                {
                    $employeee = [
                        'id' => (int)$row->id,
                        'name' => $row->name,
                        'shortname' => $row->shortname,
                    ];

                    $employees[$row->id] = $employeee;
                }

                return $employees;
            }

            if ($this->format == 'only-id')
            {               
                foreach ($q as $row)
                {
                    $employees[] = $row->id;
                }

                return $employees;
            }

            foreach ($q as $i => $row)
            {
                $__createTime = new DateTime($row->create_time);
                $__updateTime = new DateTime($row->update_time);

                $type['id'] = (int)$row->type;

                if ($row->type == 1)
                {
                    $type['name'] = 'Stomatologie';
                }
                elseif($row->type == 2)
                {
                    $type['name'] = 'Dentální hygiena';
                }
                elseif($row->type == 3)
                {
                    $type['name'] = 'Zubní instrumentářky';
                }

                $employee = [
                    'id' => (int)$row->id,
                    'name' => $row->name,
                    'rank' => (int)$row->rank,
                    'photoImgUrl' => base_url() . '../assets/images/employees/empty_image.jpg',
                    'degree' => $row->degree,
                    'text' => $row->text,
                    'education' => $row->education,
                    'officeHours' => ($row->office_hours) != NULL ? htmlspecialchars_decode($row->office_hours): "",
                    'type' => $type,
                    'active' => [
                        'value' => (int)$row->active,
                        'name' => (int)$row->active == 1 ? 'Ano' : 'Ne',
                    ],
                    'updateTime' => [
                        'format' => $__updateTime->format('d.m.Y H:i:s'),
                        'formatDate' => $__updateTime->format('d.m.Y'),
                        'formatShort' => $__updateTime->format('d.m.Y H:i'),
                        'formatSystem' => $__updateTime->format('Y-m-d\TH:i:s.v\Z')
                    ],
                    'createTime' => [
                        'format' => $__createTime->format('d.m.Y H:i:s'),
                        'formatDate' => $__createTime->format('d.m.Y'),
                        'formatShort' => $__createTime->format('d.m.Y H:i'),
                        'formatSystem' => $__createTime->format('Y-m-d\TH:i:s.v\Z')
                    ],          
                ];

                $employees[$row->id] = $employee;
            }

            if (!is_null($this->employeeId) && array_key_exists($this->employeeId, $employees))
            {
                $__singleFile = new SingleFileModel;
                $__singleFile->setEmployeeId($this->employeeId);
                $__singleFile->setPageLimit(1);
                $singleFileData = $__singleFile->getRecord();

                if(!empty($singleFileData))
                {
                    $employees[$this->employeeId]['photoImgUrl'] = base_url() . $singleFileData['path'] . $singleFileData['name'] . $singleFileData['type'];
                }

                return $employees[$this->employeeId];
            }
        }        

        return $employees;
    }

    public function createRecord()
    {
        $this->db->transStart();

        $builder = $this->db->table($this->table);

        if (!is_null($this->data))
        {
            $employees[]=$this->data;

            foreach ($employees as $i => $row)
            {
                $builder->insert($row);
                $this->employeeId = $this->insertId();
            }
        }

        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();
        
        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE;     
    }

    public function updateRecord()
    {
        $this->db->transStart();

        $builder = $this->db->table($this->table);

        if (!is_null($this->employeeId))
        {
            $builder->where('id', $this->employeeId);

            if (!is_null($this->data))
            {
                $builder->update($this->data);
            }
        }
        else
        {
            if (!is_null($this->data))
            {
                $builder->updateBatch($this->data, 'id');
            }
        }

        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();

        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE;   
    }

    public function getCacheData($type)
    {
        helper('filesystem');
        $employees = [];
        $loademployees = FALSE;

        if ($type === 'select-option')
        {
            $fileemployees = CACHE_PATH . 'employees.json';

            if (file_exists($fileemployees) === TRUE)
            {
                $fileemployeesDate = filemtime($fileemployees);
                if (time() - $fileemployeesDate <= CACHE_MAX_TIME)
                {
                    $dataJson = get_filenames($fileemployees);
                    $dataArray = FALSE;
                    if (!empty($dataJson))
                    {
                        $dataArray = json_decode($dataJson, TRUE);
                    }
                    
                    if (is_array($dataArray) === TRUE)
                    {
                        foreach ($dataArray as $data)
                        {
                            $employee = [
                                'id' => $data['id'],
                                'name' => $data['name'],
                                'company_name' => $data['company_name'],
                            ];
                            $employees[$data['id']] = $employee;
                        }
                        $loademployees = TRUE;
                    }
                }
            }
        }
        else if ($type === 'data')
        {
            $fileemployees = CACHE_PATH . 'employees_data.json';

            if (file_exists($fileemployees) === TRUE)
            {
                $fileemployeesDate = filemtime($fileemployees);
                if (time() - $fileemployeesDate <= CACHE_MAX_TIME)
                {
                    $dataJson = get_filenames($fileemployees);
                    $dataArray = FALSE;
                    if (!empty($dataJson))
                    {
                        $dataArray = json_decode($dataJson, TRUE);
                    }

                    if (is_array($dataArray) === TRUE)
                    {
                        foreach ($dataArray as $data)
                        {
                            $employees[$data['id']] = $data;
                        }
                        
                        $loademployees = TRUE;
                    }
                }

            }
        }

        if ($loademployees === FALSE)
        {
            $__employee = new EmployeeModel;
            $__employee->setFormat($type);
            $__employee->setPageLimit(NULL);
            $employees = $__employee->getRecord();

            $data_employees = json_encode(array_values($employees), JSON_UNESCAPED_UNICODE);
            write_file($fileemployees, $data_employees);
        }

        return $employees;
    }
}