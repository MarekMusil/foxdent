<?php

namespace App\Models\User;
use CodeIgniter\Model;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;

use DateTime;
use DateInterval;
use App\Models\User\UserBranchModel;
use App\Helpers\CustomHelper;


class UserLoginModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function __destruct()
    {
        
    }

    private $active = NULL;
    private $appType = NULL;
    private $bearerToken = NULL;
    private $data = NULL;
    private $debugMode = FALSE;
    private $format = NULL;
    private $headerData = NULL;
    private $insertedId = NULL;
    private $onlyCount = FALSE;
    private $pageLimit = 10;
    private $pageNumber = 1;
    private $loginToken = NULL;
    private $password = NULL;
    private $pin = NULL;
    private $process = NULL;
    private $searchQuery = NULL;
    private $sortBy = 'id';
    protected $sortByOptions = ['id', 'name', 'update_time'];
    private $sortOrder = 'ASC';
    protected $sortOrderOptions = ['ASC', 'DESC'];
    private $singleLogin = NULL;
    protected $table = 'users_logins';
    private $userId = NULL;
    private $userEmail = NULL;
    private $usersId = NULL;
    private $validityTime = NULL;
    private $verified = NULL;
    
    public function getBearerToken()
    {
       return $this->bearerToken;
    }

    public function getInsertedId()
    {
        return $this->insertedId;
    }

    public function getLoginToken()
    {
        return $this->loginToken;
    }

    public function getPageLimit()
    {
        return $this->pageLimit;
    }

    public function getPageNumber()
    {
        return $this->pageNumber;
    }    

    public function getProcess()
    {
       return $this->process;
    }

    public function getValidityTime()
    {
        return $this->validityTime;
    }

    public function setActive($bool)
    {
        $this->active = $bool;
    }

    public function setAppType($bool)
    {
        $this->appType = $bool;
    }

    public function setBearerToken($bearerToken)
    {
       $this->bearerToken = $bearerToken;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setDebugMode($bool)
    {
        $this->debugMode = $bool;
    }

    public function setHeaderData($headerData)
    {
        $this->headerData = $headerData;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function setInsertedId($insertedID)
    {
        $this->insertedID = $insertedID;
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

    public function setSearchQuery($query)
    {
        $this->searchQuery = $query;
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

    public function setSingleLogin($bool)
    {
        $this->singleLogin = $bool;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setUserLoginId($userLoginId)
    {
        $this->userLoginId = $userLoginId;
    }

    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    public function setUsersId($usersId)
    {
        $this->usersId = $usersId;
    }    

    public function setVerified($bool)
    {
        $this->verified = $bool;
    }

    public function getRecord()
    {
        $builder = $this->db->table($this->table);
        $logins = [];

        if ($this->onlyCount === TRUE)
        {        
            $builder->select('COUNT(id) AS count');
        }
        elseif($this->appType == 'getcash_ma')
        {        
            $builder->select('*');
        }
        else
        {
            $builder->select('*');
        }

        //JEDNORÁZOVÉ PŘIHLÁŠENÍ
        //$builder->where('is_one_time', 1);
        
        if (!is_null($this->active))
        {
            $builder->where('active', $this->active);
        }

        if (!is_null($this->bearerToken))
        {
            $builder->where('bearer_token',$this->bearerToken);
        }

        if ($this->onlyCount === FALSE && is_int($this->pageLimit) && is_int($this->pageNumber))
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
            if ($this->appType === 'getcash_ma')
            {    
                foreach ($q as $row)
                {
                    $__createTime = new DateTime($row->create_time);

                    $login = [
                        'id' => (int)$row->id,
                        'user' => ['id' => $row->user_id, 'name' => ''],
                        'createTime' => [
                            'format' => $__createTime->format('d.m.Y H:i:s'),
                            'formatSystem' => $__createTime->format('Y-m-d\TH:i:s.v\Z')
                        ],
                    ];
    
                    $logins[] = $login;
                }
            }
            else
            {
                foreach ($q as $row)
                {
                    $__createTime = new DateTime($row->create_time);

                    $login = [
                        'id' => (int)$row->id,
                        'user' => ['id' => $row->user_id, 'name' => ''],
                        'createTime' => [
                            'format' => $__createTime->format('d.m.Y H:i:s'),
                            'formatSystem' => $__createTime->format('Y-m-d\TH:i:s.v\Z')
                        ],
                    ];
    
                    $logins[] = $login;
                }
            }

            if (!is_null($this->userLoginId) && array_key_exists($this->userLoginId, $logins))
            {
                return $logins[$this->userLoginId];
            }
        }        

        return $logins;
    }

}
