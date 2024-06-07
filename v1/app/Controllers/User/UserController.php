<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;
use CodeIgniter\Controller;
use App\Models\Column\ColumnModel;
use App\Models\Button\ButtonModel;

use App\Models\User\UserModel;
use App\Helpers\PaginationHelper;
use App\Helpers\CustomHelper;
use App\Models\EmailStackModel;

class UserController extends BaseController
{    

    public function __construct()
    {
        parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function get()
    {
        $module = "users";
        $__user = new UserModel;
        $__user->setAppName($this->clientAppName);

        $pagination = PaginationHelper::createPagination($this->request, $__user, 'id' , 'ASC');

        $users = $__user->getRecord();

        $__column = new ColumnModel;
        $columns = $__column->getColumns()[$module];

        $col_options = $columns[count($columns) - 1];
        if ($col_options['key'] != 'options')
        {
            return $this->respond($task, 409, lang('Response.409'));
        }

        foreach ($columns as $index => $col)
        {
            if ($col['key'] == 'name')
            {
                $columns[$index]['url'] .= '/{:id}';
            }
        }

        foreach ($col_options['items'] as $index => $item)
        {
            if ($item['key'] == 'edit')
            {
                $columns[count($columns) - 1]['items'][$index]['url'] .= '/{:id}';
            }
        }
        
        $buttons = [];
        $__button = new ButtonModel;

        if (isset($__button->getButtons()[$module]))
        {
            $buttons = $__button->getButtons()[$module];
        }

        $responseData = [
            'pagination' => $pagination,
            'records' => array_values($users),
            'columns' => $columns,
            'buttons' => $buttons
        ];

        return $this->respond($responseData, 200, lang('Response.200'));
    }

    public function detail($userId)
    {
        $__user = new UserModel;
        $__user->setAppName($this->clientAppName);

        if ($__user->existsId($userId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }
        
        $__user->setUserId($userId);

        $users = $__user->getRecord();

        $responseData = [
            'user' => $users
        ];

        return $this->respond($responseData, 200, lang('Response.200'));
    }

    public function create()
    {
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'userName'             => 'required|min_length[4]|max_length[50]',
            'userPin'              => 'required|exact_length[4]',
            'userRoleId'            => 'required|selectedFromUserRoles',
            'userEmail'            => 'required|valid_email',
            'userBranchesId.*'       => 'required',
            'userCashdeskId'   => 'permit_empty|selectedFromCashdesks'
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        $password = CustomHelper::generatePassword();
        $slug = CustomHelper::createSlug($inputData['userName']);

        if(!isset($inputData['userCashdeskId']))
        {
            $inputData['userCashdeskId'] = null;
        }

        $userData = [
            'name'      => $inputData['userName'],
            'slug'      => $slug,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'email'     => $inputData['userEmail'],
            'pin'       => $inputData['userPin'],
            'role_id'   => $inputData['userRoleId'],
            'cashdesk_id'   => is_null($inputData['userCashdeskId'])? null : (int)$inputData['userCashdeskId'],
            'userBranches' => $inputData['userBranchesId']
        ];

        $__user = new UserModel;
        $__user->setData($userData);

        if ($__user->createRecord() === FALSE)
        {
            return $this->respond(NULL, 500, lang('Response.500'));
        }

        $userId = $__user->getUserId();
        $__user->setUserId($userId);
        $user = $__user->getRecord();

        if ($__user->createRequest('activate_account') === FALSE)
        {
            return $this->respond(NULL, 500, lang('Response.500'));
        }

        $activateAccountPage = URL_APP . '#/accounts/activate';

        $emailData = [
            'verify_url' => $activateAccountPage . '?user_id=' . $user['id'] . '&email=' . $user['email'] . '&process=' . $__user->getProcess() . '&type=activate_account',
        ];

        $email = \Config\Services::email();
        $email->setTo($inputData['userEmail']);
        $email->setFrom(SYSTEM_EMAIL, SYSTEM_EMAIL_SENDER_NAME);
        $email->setSubject("Aktivace účtu");
        $msg = view("emails/activateAccount", [
            'activateUrl'          => $emailData['verify_url'],  
            'name'          => $inputData['userName'],   
            'password'          => $password,     
        ]);        
        $email->setMessage($msg)
        ;
        if ($email->send() === FALSE)
        {
            return $this->respond($responseData, 500, lang('Response.500'));
        }
        
        $responseData = [
            'user' => [
                'id' => $__user->getInsertedId(),
            ],
            'redirectUrl'  => '/settings/users/'.$__user->getInsertedId()
        ];

        return $this->respond($responseData, 201, lang('Response.201'));
    }

    public function update($userId)
    {
        $__user = new UserModel;
        $__user->setAppName($this->clientAppName);
        if ($__user->existsId($userId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'userName'             => 'required|min_length[4]|max_length[50]',
            //'userPassword'         => 'required',
            'userPin'              => 'permit_empty|exact_length[4]',
            'userRoleId'             => 'required|selectedFromUserRoles',
            'userEmail'            => 'required|valid_email',
            'userBranchesId.*'       => 'required',
            'userCashdeskId'   => 'permit_empty|selectedFromCashdesks'
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors'] = $errors;
            return $this->respond($data, 422, lang('Response.422'));
        }   

        if(!isset($inputData['userCashdeskId']))
        {
            $inputData['userCashdeskId'] = null;
        }

        //$slug = CustomHelper::createSlug($inputData['userName']);

        $userData = [
            'name'      => $inputData['userName'],
            //'slug'      => $slug,
            'email'     => $inputData['userEmail'],
            'role_id'   => $inputData['userRoleId'],
            'cashdesk_id'   => is_null($inputData['userCashdeskId'])? null : (int)$inputData['userCashdeskId'],
            'userBranches' => $inputData['userBranchesId'],
        ];

        $__user = new UserModel;
        $__user->setData($userData);
        $__user->setUserId($userId);
        if ($__user->updateRecord() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }
        
        return $this->respond(null, 200, lang('Response.200'));
    }

    public function uploadSignature($userId)
    {
        $__user = new UserModel;
        $__user->setAppName($this->clientAppName);

        if ($__user->existsId($userId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }
        
        $__user->setUserId($userId);

        $slug = $__user->getRecord()['slug'];

        $uploadDirectory = '../assets/images/signatures/';

        $file = $_FILES['file'];

        $destinationPath = $uploadDirectory . $slug . '.png';
        move_uploaded_file($file['tmp_name'], $destinationPath);

        return $this->respond(null, 200, lang('Response.200'));

    }
}