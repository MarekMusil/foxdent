<?php

namespace App\Models\User;

use CodeIgniter\Model;
use App\Models\System\SystemUpdateModel;
use App\Models\System\CRMAppModuleModel;
use DateTime;

class UserBranchModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function __destruct()
    {
        
    }

    private $data = NULL;
    private $debugMode = FALSE;
    private $format = NULL;
    private $onlyCount = FALSE;
    private $pageLimit = NULL;
    private $pageNumber = 1;
    private $roleId = NULL;
    private $sortBy = 'id';
    protected $sortByOptions = ['id'];
    private $sortOrder = 'ASC';
    protected $sortOrderOptions = ['ASC', 'DESC'];
    protected $table = 'user_branches';
    protected $tblBranches = 'branches';
    private $userId = NULL;
    private $usersIds = NULL;
    private $removed = NULL;
    private $withRemoved = FALSE;

    public function getPageLimit()
    {
        return $this->pageLimit;
    }

    public function getPageNumber()
    {
        return $this->pageNumber;
    }    

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setUsersIds($usersIds)
    {
        $this->usersIds = $usersIds;
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

    public function existsId($userRoleId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $userRoleId);
        $builder->where('removed', 0);
        if ($this->debugMode === TRUE)
        {
            echo  $builder->getCompiledSelect();
        }
        $q =  $builder->get()->getResult();

        if (count($q) > 0)
        {
            return TRUE;
        }
        
        return FALSE;        
    }    

    public function getRecord()
    {
        $builder = $this->db->table($this->table);

        $userBranchs = [];

        if ($this->onlyCount === FALSE)
        {
            $builder->select(
                $this->table.'.id,'.
                $this->table.'.branch_id,'.
                $this->table.'.user_id,'.
                $this->tblBranches.'.name,'
            );
        }
        else
        {
            $builder->select('COUNT(id) AS count');
        }

        $builder->join($this->tblBranches, $this->tblBranches . '.id = ' . $this->table . '.branch_id');

        if (!is_null($this->roleId))  
        {
            $builder->where($this->table . '.id', $this->roleId);
        }        

        if (!is_null($this->userId))  
        {
            $builder->where($this->table . '.user_id', $this->userId);
        } 

        if (!is_null($this->usersIds))  
        {
            $builder->whereIn($this->table . '.user_id', $this->usersIds);
        } 

        if (!is_null($this->removed))
        {
            $builder->where($this->table . '.removed', $this->removed);
        }
        else
        {
            if ($this->withRemoved === FALSE)
            {
                $builder->where($this->table . '.removed', 0);
            }
        }

        if ($this->onlyCount === FALSE && !is_null($this->pageLimit))
        {
            $builder->limit($this->pageLimit, ($this->pageNumber * $this->pageLimit) - $this->pageLimit);
        }
        
        $builder->orderBy($this->table . '.' .$this->sortBy, $this->sortOrder);

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        $q = $builder->get()->getResult();

        if ($this->onlyCount === TRUE)
        {
            return $q[0]->count;
        }

        if ($this->format === 'select-option')
        {
            foreach ($q as $row)
            {
                $userBranch = [
                    'id' => (int)$row->id,
                    'name' => $row->name,
                ];
                
                $userBranchs[$row->id] = $userBranch;
            }
            
            return $userBranchs;
        }

        foreach ($q as $row)
        {
            $userBranchId = (int)$row->branch_id;

            $userBranchs[$row->user_id][] = $userBranchId;
        }
        return $userBranchs;
    }

    public function createRecord()
    {  
        $builder = $this->db->table($this->table);

        $this->db->transStart();

        $builder->insertBatch($this->data);
        $this->itemId = $this->insertId();

        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE;     
    }

    public function updateRecord()
    {
        $this->pageLimit = NULL;
        $today = date('Y-m-d H:i:s');

        $tableUserBranches = ($this->getRecord());

        if (!empty($tableUserBranches))
        {
            $tableUserBranches = $tableUserBranches[$this->userId];
        }

        //print_r($tableUserBranches);exit;

        $userBranchesData = [];
        $userBranchesIds = $tableUserBranches;
        $userBranchesIdsToRemove = $tableUserBranches;

        foreach ($this->data as $currentUserBranchId)
        {

            if (!in_array($currentUserBranchId, $userBranchesIds))
            {
                $userBranchData = [
                    'branch_id'   => $currentUserBranchId,
                    'user_id' => $this->userId,
                ];
                $userBranchesData[] = $userBranchData; 
            }
            else
            {
                $key = array_search($currentUserBranchId, $userBranchesIdsToRemove);
    
                if ($key !== false)
                {
                    unset($userBranchesIdsToRemove[$key]);
                }
            } 
        }

        if (!empty($userBranchesIdsToRemove))
        {
            $builderRemove = $this->db->table($this->table);
            $builderRemove->whereIn('branch_id', $userBranchesIdsToRemove);
            $builderRemove->where('user_id', $this->userId);
            $builderRemove->where('removed', 0);
            $builderRemove->update(['removed' => 1]);
        }

        if (!empty($userBranchesData))
        {
            $builderAdd = $this->db->table($this->table);
            $builderAdd->insertBatch($userBranchesData);
        }  
    }
}