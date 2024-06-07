<?php

namespace App\Models\User;

use CodeIgniter\Model;
use App\Models\System\SystemUpdateModel;
use App\Models\System\CRMAppModuleModel;
use DateTime;

class UserRoleModel extends Model
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
    protected $table = 'user_roles';

    public function getPageLimit()
    {
        return $this->pageLimit;
    }

    public function getPageNumber()
    {
        return $this->pageNumber;
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

    public function authorizeToken($roleId, $roleToken)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $roleId);
        $builder->where('token', $roleToken);
        $builder->where('removed', 0);
        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }        
        $q = $builder->get()->getResult();

        if (count($q) == 1)
        {
            return TRUE;
        }

        return FALSE;        
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

        $userRoles = [];

        if ($this->onlyCount === FALSE)
        {
            $builder->select('id, name, css_class, page_roles, token, update_time, modules_config,');
        }
        else
        {
            $builder->select('COUNT(id) AS count');
        }

        if (!is_null($this->roleId))  
        {
            $builder->where('id', $this->roleId);
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

        if ($this->format === 'select-option')
        {
            foreach ($q as $row)
            {
                $userRole = [
                    'id' => (int)$row->id,
                    'name' => $row->name,
                ];
                
                $userRoles[$row->id] = $userRole;
            }
            
            return $userRoles;
        }

        $__system = new CRMAppModuleModel;
        $modulesConfig = $__system->getModulesColumns();

        foreach ($q as $row)
        {
            $updateTime = new DateTime($row->update_time);

            $updateLink = APP_URL . 'permissions/' . $row->id . '/update';

            $pageRoles = NULL;
            if ($row->page_roles != NULL)
            {
                $pageRoles = json_decode($row->page_roles, TRUE);
            }

            $userRole = [
                'id' => (int)$row->id,
                'name' => $row->name,
                'token' => $row->token,
                'page_roles' => $pageRoles,
                'html' => '<span><span class="label label-' . $row->css_class . ' label-dot mr-2"></span><span class="font-weight-bold text-' . $row->css_class . '">' . $row->name . '</span></span>',
                'links' => [
                    'update' => $updateLink,
                ],                
                'update_time' => [
                    'format' => $updateTime->format('d.m.Y H:i:s'),
                    'source' => $updateTime,
                ],

                'modules_config' => $modulesConfig,
            ];

            $userRoles[$row->id] = $userRole;
        }

        if (!is_null($this->roleId) && array_key_exists($this->roleId, $userRoles))
        {
            return $userRoles[$this->roleId];
        }

        return $userRoles;
    }

    public function updateRecord()
    {
        $builder = $this->db->table($this->table);

        $updateTime = new DateTime;

        $modulesConfig = [];

        $__crmModule = new CRMAppModuleModel;
        $crmModulesColumns = $__crmModule->getModulesColumns();

        foreach ($crmModulesColumns as $moduleKey => $crmModule)
        {
            foreach ($this->data['user_role_modules_config'] as $module => $rank)
            {
                if ($moduleKey == $module)
                {
                    $moduleConfig = [
                        'name' => $crmModule['name'],
                        'rank' => $rank,
                        'columns' => [],
                    ];
                    $modulesConfig[$module] = $moduleConfig;
                }
            }            
        }

        $userRole = [
            'update_time' => $updateTime->format('Y-m-d H:i:s'),
            'modules_config' => json_encode($modulesConfig, JSON_UNESCAPED_UNICODE),
        ];
        
        $builder->where('id', $this->roleId);
        $builder->update($userRole);        
        if ( $builder->affectedRows() === -1)
        {
            return FALSE;
        }

        return TRUE;        
    }

    public function getCacheData($type)
    {
        $userRoles = [];
        $loadUserRoles = FALSE;

        if ($type === 'select-option')
        {
            $fileUserRoles = CACHE_PATH . 'user_roles.json';

            if (file_exists($fileUserRoles) === TRUE)
            {            
                $fileUserRolesDate = filemtime($fileUserRoles);
                if (time() - $fileUserRolesDate <= CACHE_MAX_TIME)
                {
                    $dataJson = get_filenames($fileUserRoles);
                    $dataArray = FALSE;
                    if (!empty($dataJson))
                    {
                        $dataArray = json_decode($dataJson, TRUE);
                    }
                    
                    if (is_array($dataArray) === TRUE)
                    {
                        foreach ($dataArray as $data)
                        {
                            $userRole = [
                                'id' => $data['id'],
                                'name' => $data['name'],
                            ];
                            $userRoles[$data['id']] = $userRole;
                        }
                        $loadUserRoles = TRUE;
                    }
                }
            }
        }
        else if ($type === 'data')
        {
            $fileUserRoles = CACHE_PATH . 'user_roles_data.json';

            if (file_exists($fileUserRoles) === TRUE)
            {
                $fileUserRolesDate = filemtime($fileUserRoles);
                if (time() - $fileUserRolesDate <= CACHE_MAX_TIME)
                {
                    $dataJson = get_filenames($fileUserRoles);
                    $dataArray = FALSE;
                    if (!empty($dataJson))
                    {
                        $dataArray = json_decode($dataJson, TRUE);
                    }

                    if (is_array($dataArray) === TRUE)
                    {
                        foreach ($dataArray as $data)
                        {
                            $userRoles[$data['id']] = $data;
                        }
                        
                        $userRoles = TRUE;
                    }
                }

            }
        }

        if ($loadUserRoles === FALSE)
        {
            $__userRole = new UserRoleModel;
            $__userRole->setFormat($type); //ROZDÍL
            $__userRole->setPageLimit(NULL);
            //$__userRole->serActive(TRUE);
            $userRoles = $__userRole->getRecord();

            $dataUserRoles = json_encode(array_values($userRoles), JSON_UNESCAPED_UNICODE);
            write_file($fileUserRoles, $dataUserRoles);
        }

        return $userRoles;
    }
}