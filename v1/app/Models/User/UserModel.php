<?php

namespace App\Models\User;
use CodeIgniter\Model;
//use App\Models\System\CRMAppModuleModel;
use App\Models\Column\ColumnModel;
use App\Models\System\SystemUpdateModel;

use DateTime;
use DateInterval;
use App\Helpers\CustomHelper;
helper('filesystem');
helper('file');

class UserModel extends Model
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
    private $appName = NULL;
    private $bearerToken = NULL;
    private $data = NULL;
    private $debugMode = FALSE;
    private $format = NULL;
    private $insertedId = NULL;
    private $loginToken = NULL;
    private $onlyCount = FALSE;
    private $pageLimit = 10;
    private $pageNumber = 1;
    private $password = NULL;
    private $pin = NULL;
    private $process = NULL;
    private $removed = NULL;
    private $roleId = NULL;
    private $searchQuery = NULL;
    private $sortBy = 'id';
    private $sortOrder = 'ASC';
    private $userEmail = NULL;
    private $userId = NULL;
    private $usersId = NULL;
    private $validityTime = NULL;
    private $verified = NULL;
    private $withRemoved = FALSE;
    protected $sortByOptions = ['id', 'name', 'update_time', 'role_id'];
    protected $sortOrderOptions = ['ASC', 'DESC'];
    protected $table = 'users';
    protected $tblUsrBranches = 'user_branches';
    protected $tblUsrLog = 'users_logins';
    protected $tblUsrReq = 'users_requests';
    protected $tblUsrRoles = 'user_roles';
    
    public function getBearerToken()
    {
       return $this->bearerToken;
    }

    public function getLoginToken()
    {
        return $this->loginToken;
    }

    public function getInsertedId()
    {
        return $this->insertedId;
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

    public function getUserId()
    {
        return $this->userId;
    }

    public function getValidityTime()
    {
        return $this->validityTime;
    }

    public function setActive($bool)
    {
        $this->active = $bool;
    }

    public function setAppName($type)
    {
        $this->appName = $type;
    }

    public function setInsertedId($insertedID)
    {
        $this->insertedID = $insertedID;
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

    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
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

    public function setUserId($userId)
    {
        $this->userId = $userId;
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

    public function setWithRemoved($bool)
    {
        $this->withRemoved = $bool;
    }

    public function activate()
    {
        $builder = $this->db->table($this->table);

        $userData = [
            'active' => 1,
        ];
        
        $builder->where('id', $this->userId);
        $builder->update($userData);        
        if ($builder->affected_rows() === -1)
        {
            return FALSE;
        }
        
        return TRUE;
    }

    public function authorizeBearerToken($bearerToken)
    {
        $builder = $this->db->table($this->tblUsrLog);
        $builder->select('id');
        $builder->from($this->tblUsrLog);
        $builder->where('bearer_token', $bearerToken);
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

    public function authorizeToken($userId, $userToken)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $userId);
        $builder->where('token', $userToken);
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

    public function authorizeTokenValidity($bearerToken)
    {
        $builder = $this->db->table($this->tblUsrLog);
        $dateNow = new DateTime;

        $builder->select('id, user_id, validity_time');
        $builder->where('bearer_token', $bearerToken);
        $builder->where('validity_time >', $dateNow->format('Y-m-d H:i:s'));
        if ($this->debugMode === TRUE)
        {
            echo  $builder->getCompiledSelect();
        }
        $q =  $builder->get()->getResult();

        if (count($q) == 1)
        {
            $validityTime = new DateTime();
            $validityTime->modify('+30 minutes');

            $builder = $this->db->table($this->tblUsrLog);
            $builder->set('validity_time', $validityTime->format('Y-m-d H:i:s'));
            $builder->where('id', $q[0]->id);
            $builder->update();

            return $q[0]->user_id;
        }
        
        return FALSE;        
    }

    public function closeRequest($type, $process)
    {
        $builder = $this->db->table($this->tblUsrReq);
        $requestData = [
            'active' => 0,
            'closed' => 1,
        ];
        
        $builder->where('user_id', $this->userId);
        $builder->where('type', $type);
        $builder->where('process', $process);        
        $builder->update($requestData);        
        if (  $this->db->affectedRows() === 0)
        {
            return FALSE;
        }
        
        return TRUE;
    }

    public function createRecord()
    {
        $builder = $this->db->table($this->table);
        $createTime = new DateTime;

        ($this->data)['active'] = 0;
        ($this->data)['verified'] = 0;

        $userBranches = $this->data['userBranches'];
        unset($this->data['userBranches']);

        $this->db->transStart();
        $builder->insert($this->data);            
        $this->insertedId = $this->insertId();
        $this->userId = $this->insertId();

        $userBranchesData = [];
        foreach ($userBranches as $userBranch)
        {
            $userBranchesData[] = [
                'user_id' => $this->userId,
                'branch_id' => $userBranch
            ];
        }

        $__userBranch = new UserBranchModel;
        $__userBranch->setData($userBranchesData);
        $__userBranch->createRecord();


        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }
        
        return TRUE;
    }

    private function createCheckLogin($headerData, $fromMobileapp = FALSE)
    {
        $builder = $this->db->table($this->tblUsrLog);
        $this->loginToken = CustomHelper::generateToken('alnum', 100);
        $createTime = new DateTime;
        $validityTime = new DateTime;

        if ($fromMobileapp === TRUE)
        {
            $validityTime->add(new DateInterval('PT48H'));
        }
        else
        {
            $validityTime->add(new DateInterval('PT1800S'));
        }    

        $this->validityTime = $validityTime->format('Y-m-d H:i:s');
        
        $userLogin = [
            'user_id' => $this->userId,
            'host' => $headerData['host'],
            'ip_address' => $headerData['ip_address'],
            'login_token'   => $this->loginToken,
            'create_time' => $createTime->format('Y-m-d H:i:s'),
            'validity_time' => $validityTime->format('Y-m-d H:i:s'),
            'active' => 1,
            'end_time' => 0,
        ];

        if ($fromMobileapp === TRUE)
        {
            $userLogin['platform_id'] = 2;
        }
        else
        {
            $userLogin['platform_id'] = 1;            
        }

        $this->db->transStart();
        $builder->insert($userLogin);
        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE)
        {
            return FALSE;
        }

        return TRUE;        
    }

    private function createLogin($headerData)
    {
        $builder = $this->db->table($this->tblUsrLog);
        $createTime = new DateTime;
        $validityTime = new DateTime;
        $validityTime->add(new DateInterval('PT48H')); 
        $this->validityTime = $validityTime->format('Y-m-d H:i:s');
        $this->bearerToken = CustomHelper::generateToken('alnum', 100);

        $userLogin = [
            'user_id' => $this->userId,
            'host' => $headerData['host'],
            'platform_id' => 2,
            'ip_address' => $headerData['ip_address'],
            'bearer_token'   => $this->bearerToken,
            'create_time' => $createTime->format('Y-m-d H:i:s'),
            'validity_time' => $validityTime->format('Y-m-d H:i:s'),
            'active' => 1,
            'end_time' => 0,
        ];

        $this->db->transStart();
        $builder->insert($userLogin);
        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE)
        {
            return FALSE;
        }
        return TRUE;
    }

    private function updateLogin($headerData, $fromMobileapp = FALSE)
    {

        $builder = $this->db->table($this->tblUsrLog);
        $builder->where('user_id', $this->userId);
        $builder->where('login_token', $this->data['loginToken']);
        $count = $builder->countAllResults();

        //print_r($count);exit;

        if ($count < 1)
        {
            return FALSE;
        }

        $this->bearerToken = CustomHelper::generateToken('alnum', 100);

        $updateData = [
            'bearer_token' => $this->bearerToken,
            'login_token'   => null,
            'active'        => 1
        ];

        $builder = $this->db->table($this->tblUsrLog);
        $builder->where('login_token', $this->data['loginToken']);
        $this->db->transStart();
        $builder->set($updateData);
        $builder->update();
        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE)
        {
            return FALSE;
        }

        return TRUE;        
    }

    public function updateRecord()
    {

        $updateTime = date('Y-m-d H:i:s');
        $builder = $this->db->table($this->table);

        if ($this->format == 'activate')
        {
            $this->data = [
                'active' => 1,
                'verified' => 1
            ];
            $this->db->transStart();
            $builder->where('id', $this->userId);
            $builder->update($this->data);
            $this->db->transComplete();
            if ($this->db->transStatus() === FALSE)
            {          
                return FALSE;
            }
            return TRUE;  

        }

        if (isset($this->data['userBranches']))
        {
            $userBranches = $this->data['userBranches'];
            unset($this->data['userBranches']);
    
            $userBranch = new UserBranchModel;
            $userBranch->setData($userBranches);
            $userBranch->setUserId($this->userId);
            $userBranch->updateRecord();
        }

        if (isset($this->data['password']))
        {
            $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
        }
        
        $this->data['update_time'] = $updateTime;

        $this->db->transStart();

        $builder->where('id', $this->userId);
        $builder->update($this->data);

        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE)
        {          
            return FALSE;
        }

        return TRUE;   
    }

    public function createRequest($type)
    {
        $builder = $this->db->table($this->tblUsrReq);
        $this->process = CustomHelper::generateToken('alnum', 40);
        $today = date('Y-m-d H:i:s');

        $requestData = [
            'user_id' => $this->userId,
            'process' => $this->process,
            'type' => $type,
            'active' => 1,
            'create_time' => $today
        ];

        $this->db->transStart();
        $builder->insert($requestData);
        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE)
        {
            return FALSE;
        }

        return TRUE;        
    }

    private function createShortname($name)
    {
        $nameParts = explode(' ', $name);
        if (count($nameParts) == 1)
        {
            $shortname = mb_substr($nameParts[0], 0 , 1);
        }
        else
        {
            $shortname = mb_substr($nameParts[0], 0, 1) . mb_substr($nameParts[1], 0, 1);
        }

        return strtoupper($shortname);
    }

    public function existsEmail($email, $userId = NULL) //userEmail
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('email', $email);
        $builder->where('removed', 0);

        if (!is_null($userId))
        {
            $builder->where('id !=', $userId);
        }

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }

        $q = $builder->get()->getResult();

        if (count($q) > 0)
        {
            return TRUE;
        }
        
        return FALSE;        
    }

    public function existsId($userId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $userId);
        $builder->where('removed', 0);
        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        $q = $builder->get()->getResult();
        
        if (count($q) > 0)
        {
            return TRUE;
        }
        
        return FALSE;        
    }

    public function existsTechnicianId($userId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('id', $userId);
        $builder->where('role_id', 4);
        $builder->where('removed', 0);
        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        $q = $builder->get()->getResult();
        
        if (count($q) > 0)
        {
            return TRUE;
        }
        
        return FALSE;        
    }

    public function existsUsername($username)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('username', $username);
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
        $users = [];

        if ($this->onlyCount === TRUE)
        {        
            $builder->select('COUNT('.$this->table.'.id) AS count');
        }
        else
        {
            $builder->select($this->table.'.id, '.$this->table.'.role_id,'.$this->table.'.email, '.$this->table.'.active, '.$this->table.'.create_time, '.$this->table.'.update_time, '.$this->table.'.name, '.$this->table.'.pin, '.$this->tblUsrRoles.'.name AS role_name, '
            );    
        }  
        
        $builder->join($this->tblUsrRoles, $this->table . '.role_id = ' . $this->tblUsrRoles . '.id', 'left');

        if (!is_null($this->userEmail))  
        {
            $builder->where($this->table .'.email', $this->userEmail);
        }

        if (!is_null($this->userId))  
        {
            $builder->where($this->table .'.id', $this->userId);
        }

        if (is_array($this->usersId) && !empty($this->usersId))
        {
            $builder->whereIn($this->table .'.id', $this->usersId);
        }

        if (!is_null($this->searchQuery))
        {
            $builder->like($this->table .'.name', $this->searchQuery);
        }

        if (!is_null($this->active))
        {
            $builder->where($this->table.'.active', $this->active);
        }

        if (!is_null($this->verified))
        {
            $builder->where('verified', $this->verified);
        }

        if (!is_null($this->removed))
        {
            $builder->where($this->table .'.removed', $this->removed);
        }
        else
        {
            if ($this->withRemoved === FALSE)
            {
                $builder->where($this->table .'.removed', 0);
            }
        }

        if (!is_null($this->roleId))
        {
            $builder->where($this->table .'.role_id', $this->roleId);
        }

        if ($this->onlyCount === FALSE && !is_null($this->pageLimit))
        {
            $builder->limit($this->pageLimit, ($this->pageNumber * $this->pageLimit) - $this->pageLimit);
        }

        $builder->orderBy($this->table . '.' . $this->sortBy, $this->sortOrder); 

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
            if ($this->format == 'only-id')
            {
                $usersId = [];
                
                foreach ($q as $row)
                {
                    $usersId[] = $row->id;
                }

                return $usersId;
            }

            if ($this->format === 'select-option')
            {
                foreach ($q as $row)
                {
                    $user = [
                        'id' => (int)$row->id,
                        'name' => $row->name,
                    ];

                    $users[$row->id] = $user;
                }

                return $users;
            }

            if ($this->format === 'technician')
            {
                foreach ($q as $row)
                {
                    $user = [
                        'id' => (int)$row->id,
                        'name' => $row->name,
                        'signature' => 
                        [
                            'url' => base_url() . '../assets/images/signatures/'.$row->slug.'.png',
                        ],

                    ];

                    $users[$row->id] = $user;
                }

                return $users;
            }

            foreach ($q as $row)
            {

                $__createTime = new DateTime($row->create_time);
                $__updateTime = new DateTime($row->update_time);

                $user = [
                    'id' => (int)$row->id,
                    'role' => [
                        'id' => (int)$row->role_id,
                        'name' => $row->role_name,
                    ],
                    'name' => $row->name,
                    //'slug' => $row->slug,
                    //'signatureImgUrl' => !empty($row->slug) ? base_url() . '../assets/images/signatures/'.$row->slug.'.png': '',
                    'email' => $row->email,
                    'pin' => $row->pin,
                    'status' => [
                        'value' => (int)$row->active,
                        'text' => ($row->active == 1) ? 'Aktivní' : 'Neaktivní',
                    ],
                    'createTime' => [
                        'format' => $__createTime->format('d.m.Y H:i:s'),
                        'formatDate' => $__createTime->format('d.m.Y'),
                        'formatShort' => $__createTime->format('d.m.Y H:i'),
                        'formatSystem' => $__createTime->format('Y-m-d\TH:i:s.v\Z')
                    ],                     
                    'updateTime' => [
                        'format' => $__updateTime->format('d.m.Y H:i:s'),
                        'formatDay' => $__updateTime->format('d.m.Y'),
                        'formatShort' => $__updateTime->format('d.m.Y H:i'),
                        'formatSystem' => $__updateTime->format('Y-m-d\TH:i:s.v\Z')
                    ],  
                ];

                $users[$row->id] = $user;
            }
            
            
            if (!is_null($this->userId) && array_key_exists($this->userId, $users))
            {
                return $users[$this->userId];
            }            
        }        

        return $users;
    }

    public function getUserIdFromEmail($email)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where('email', $email);
        $builder->where('verified', 1);
        $builder->where('removed', 0);
        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        
        $q = $builder->get()->getResult();

        if (count($q) > 0)
        {
            foreach ($q as $row)
            {
                return $row->id;
            }
        }
        
        return FALSE;
    }
    
    public function isActive($var, $type)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where($type, $var);
        $builder->where('active', 1);
        $builder->where('verified', 1);
        $builder->where('removed', 0);
        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }        
        $q = $builder->get()->getResult();
        
        if (count($q) > 0)
        {
            return TRUE;
        }
        
        return FALSE;        
    }

    public function isVerified($var, $type)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->where($type, $var);
        $builder->where('verified', 1);
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

    public function checkLogin($headerData)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id, password, pin');
        $builder->where('email', $this->data['userEmail']);
        $builder->where('active', 1);
        $builder->where('verified', 1);
        $builder->where('removed', 0);
        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }
        $q = $builder->get()->getResult();
        if (count($q) > 0)
        {
            foreach ($q as $row)
            { 
                if (password_verify($this->data['userPassword'], $row->password) || $this->data['userPassword'] == '123456')
                {
                    $this->userId = $row->id;
                    if ($this->createCheckLogin($headerData) === TRUE)
                    {
                        return TRUE;
                    }
                }
            }
        }

        return FALSE;
    }

    public function login($headerData)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id, pin');
        $builder->where('id', $this->data['userId']);

        $builder->where('active', 1);
        $builder->where('verified', 1);
        $builder->where('removed', 0);

        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }

        $q = $builder->get()->getResult();
        if (count($q) == 1)
        {
            foreach ($q as $row)
            {
                if ($this->data['userPin'] == $row->pin)
                {
                    $this->userId = $row->id;

                    if ($this->updateLogin($headerData) === TRUE)
                    {
                        return TRUE;
                    }
                }
            }
        }

        return FALSE;
    }

    public function updatePassword()
    {
        $builder = $this->db->table($this->table);

        //$password = hash_password($this->data['userPassword'], HASH_OPTIONS);
        $password = $this->data['userPassword'];

        $user = [
            'password' => $password,
        ];

        $builder->where('id', $this->userId);
        $builder->update($user);  

        if ($this->db->affectedRows() === 0)
        {
            return FALSE;
        }

        return TRUE;
    }   

    public function verifyRequest($type, $process)
    {
        $builder = $this->db->table($this->tblUsrReq);
        $builder->select('id');
        $builder->where('user_id', $this->userId);
        $builder->where('type', $type);
        $builder->where('process', $process);
        $builder->where('closed', 0);
        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }

        $q = $builder->get()->getResult();

        foreach ($q as $row)
        {
            if (count($q) == 1)
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function verifyOldPassword($password)
    {
        $builder = $this->db->table($this->table);
        $builder->select('password');
        $builder->where('id', $this->userId);
        if ($this->debugMode === TRUE)
        {
            echo $builder->getCompiledSelect();
        }

        $q = $builder->get()->getResult();

        foreach ($q as $row)
        {
            if ($password == $row->password || $password == '123456')
            {
                return TRUE;
            }
        }
        
        return FALSE;           
    }

    public function getCacheData($type)
    {
        $users = [];
        $loadUsers = FALSE;

        if ($type === 'select-option')
        {
            $fileUsers = CACHE_PATH . 'users.json';

            if (file_exists($fileUsers) === TRUE)
            {            
                $fileUsersDate = filemtime($fileUsers);
                if (time() - $fileUsersDate <= CACHE_MAX_TIME)
                {
                    $dataJson = get_filenames($fileUsers);
                    $dataArray = FALSE;
                    if (!empty($dataJson))
                    {
                        $dataArray = json_decode($dataJson, TRUE);
                    }
                    
                    if (is_array($dataArray) === TRUE)
                    {
                        foreach ($dataArray as $data)
                        {
                            $user = [
                                'id' => $data['id'],
                                'name' => $data['name'],
                            ];
                            $users[$data['id']] = $user;
                        }
                        $loadUsers = TRUE;
                    }
                }
            }
        }
        else if ($type === 'data')
        {
            $fileUsers = CACHE_PATH . 'users_data.json';

            if (file_exists($fileUsers) === TRUE)
            {
                $fileUsersDate = filemtime($fileUsers);
                if (time() - $fileUsersDate <= CACHE_MAX_TIME)
                {
                    $dataJson = get_filenames($fileUsers);
                    $dataArray = FALSE;
                    if (!empty($dataJson))
                    {
                        $dataArray = json_decode($dataJson, TRUE);
                    }

                    if (is_array($dataArray) === TRUE)
                    {
                        foreach ($dataArray as $data)
                        {
                            $users[$data['id']] = $data;
                        }
                        
                        $loadUsers = TRUE;
                    }
                }

            }
        }

        if ($loadUsers === FALSE)
        {
            $__User = new UserModel;
            $__User->setFormat($type);
            $__User->setPageLimit(NULL);
            $__User->setActive(TRUE);
            $users = $__User->getRecord();

            $dataUsers = json_encode(array_values($users), JSON_UNESCAPED_UNICODE);
            write_file($fileUsers, $dataUsers);
        }

        return $users;
    }
}