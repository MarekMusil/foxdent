<?php

namespace App\Models\System;

use CodeIgniter\Model;
use App\Models\System\SystemUpdateModel;
use DateTime;
helper('filesystem');
helper('file');
//use App\Helpers\CustomHelper;

class SingleFileModel extends Model
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
    private $appType = NULL;
    private $employeeId = NULL;
    private $slideId = NULL;
    private $slidesId = NULL;
    private $singleFileId = NULL;
    private $singleFilesId = NULL;
    private $data = NULL;
    private $debugMode = FALSE;
    private $format = NULL;
    private $onlyCount = FALSE;
    private $pageLimit = 10;
    private $pageNumber = 1;
    private $removed = NULL;
    private $searchQuery = NULL;
    private $sortBy = 'create_time';
    private $sortOrder = 'DESC';
    private $withRemoved = FALSE;
    protected $sortByOptions = ['id', 'create_time'];
    protected $sortOrderOptions = ['ASC', 'DESC'];
    protected $table = 'single_files';

    public function getPageLimit()
    {
        return $this->pageLimit;
    }
    
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    public function getSingleFileId()
    {
        return $this->singleFileId;
    }

    public function setAppType($bool)
    {
        $this->appType = $bool;
    }

    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    public function setSlideId($slideId)
    {
        $this->slideId = $slideId;
    }

    public function setSlidesId($slidesId)
    {
        $this->slidesId = $slidesId;
    }

    public function setSingleFileId($singleFileId)
    {
        $this->singleFileId = $singleFileId;
    }

    public function setSingleFilesId($singleFilesId)
    {
        $this->singleFilesId = $singleFilesId;
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
    
    public function existsId($singleFileId, $removed = 0)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $singleFileId);
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
        $singleFiles = [];

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
            $builder->where('employee_id', $this->employeeId);
        }

        if (!is_null($this->slideId))  
        {
            $builder->where('slide_id', $this->slideId);
        }

        if (!is_null($this->slidesId))  
        {
            $builder->whereIn('slide_id', $this->slidesId);
        }

        if (!is_null($this->singleFileId))  
        {
            $builder->where('id', $this->singleFileId);
        }

        if (!is_null($this->singleFilesId))  
        {
            $builder->whereIn('id', $this->singleFilesId);
        }

        if (!is_null($this->searchQuery))
        {
            $builder->like('name', $this->searchQuery);
        }

        if ($this->accessRules === TRUE && !is_null($this->singleFilesId))
        {
            $builder->whereIn('id', $this->singleFilesId);
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
                    $singleFilee = [
                        'id' => (int)$row->id,
                        'name' => $row->name,
                    ];

                    $singleFiles[$row->id] = $singleFilee;
                }

                return $singleFiles;
            }

            if ($this->format == 'only-id')
            {               
                foreach ($q as $row)
                {
                    $singleFiles[] = $row->id;
                }

                return $singleFiles;
            }

            foreach ($q as $i => $row)
            {
                $__createTime = new DateTime($row->create_time);

                $singleFile = [
                    'id' => (int)$row->id,
                    'employee' =>['id' => (int)$row->employee_id],
                    'slide' =>['id' => (int)$row->slide_id],
                    'name' => $row->name,
                    'type' => $row->type,
                    'path' => $row->path,
                    'createTime' => [
                        'format' => $__createTime->format('d.m.Y H:i:s'),
                        'formatDate' => $__createTime->format('d.m.Y'),
                        'formatShort' => $__createTime->format('d.m.Y H:i'),
                        'formatSystem' => $__createTime->format('Y-m-d\TH:i:s.v\Z')
                    ],          
                ];

                if(!is_null($this->employeeId))
                {
                    $singleFiles[$row->employee_id] = $singleFile;
                }
                elseif(!is_null($this->slideId) || !is_null($this->slidesId))
                {
                    if(!array_key_exists($this->slide_id, $singleFiles))
                    {
                        $singleFiles[$row->slide_id] = $singleFile;
                    }
                }
                else
                {
                    $singleFiles[$row->id] = $singleFile;
                }

            }
            
            if (!is_null($this->singleFileId) && array_key_exists($this->singleFileId, $singleFiles))
            {
                return $singleFiles[$this->singleFileId];
            }
            elseif (!is_null($this->employeeId))
            {
                return $singleFiles[$this->employeeId];
            }
            elseif (!is_null($this->slideId))
            {
                return $singleFiles[$this->slideId];
            }
            
        }        

        return $singleFiles;
    }

    public function createRecord()
    {
        $this->db->transStart();

        $builder = $this->db->table($this->table);

        $this->data['create_time'] = date('Y-m-d H:i:s');

        $builder->insert($this->data);
        $this->singleFileId = $this->insertId();

        $__systemUpdate = new SystemUpdateModel;
        $__systemUpdate->updateRecord();
        
        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE;     
    }
}