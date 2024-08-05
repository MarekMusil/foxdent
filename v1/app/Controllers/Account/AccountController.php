<?php
namespace App\Controllers\Account;
use App\Controllers\BaseController;
use CodeIgniter\Controller;

use App\Models\User\UserModel;

class AccountController extends BaseController
{

    public function __construct()
    {
        parent::__construct(); 
    }

    public function __destruct()
    {
        exit;
    }

    public function checkLogin()
    {
        
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'userEmail'           =>'required|valid_email',
            'userPassword'        =>'required',
        ];

        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        } 

        $__user = new UserModel;
        /* $__user->setUserEmail($inputData['userEmail']);
        $__user->setFormat('only-id');
        $userId = $__user->getRecord(); */
        
        if ($__user->existsEmail($inputData['userEmail']) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

        if ($__user->isVerified($inputData['userEmail'], 'email') === FALSE)
        {
            return $this->respond(null, 403, lang('Response.403'));
        }

        if ($__user->isActive($inputData['userEmail'], 'email') === FALSE)
        {
            return $this->respond(null, 403, lang('Response.403'));
        }

        $userId = $__user->getUserIdFromEmail($inputData['userEmail']);
        $__user->setUserId($userId);
        $user = $__user->getRecord();
        
        if ($user['role']['id'] != 1 && $user['role']['id'] != 2)
        {
            return $this->respond(null, 403, lang('S tímto oprávněním se nelze přihlásit do systému'));
        }

        $headers = $this->request->getHeaders();

        $headerData = [
            'host' => $headers['Host']->getValue(),
            'ip_address' => $this->request->getIPAddress()
        ];

        $__user = new UserModel;
        $__user->setData($inputData);

        if ($__user->checkLogin($headerData) === FALSE)
        {
            return $this->respond(null, 400, lang('Response.400'));
        }

        $loginToken =  $__user->getLoginToken();

        $responseData['user'] = [
            'id' => (int)$userId,
            'loginToken'   => $loginToken
        ];

        return $this->respond($responseData, 200, lang('Response.200'));      
    }

    public function login()
    {        
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'userId'           =>'required|selectedFromUsers',
            'userPin'           =>'required',
            'loginToken'        => 'required'
        ];

        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        } 
        
        $__user = new UserModel;
        
        if ($__user->existsId($inputData['userId']) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

        if ($__user->isVerified($inputData['userId'], 'id') === FALSE)
        {
            return $this->respond(null, 403, lang('Response.403'));
        }

        if ($__user->isActive($inputData['userId'], 'id') === FALSE)
        {
            return $this->respond(null, 403, lang('Response.403'));
        }

        $headers = $this->request->getHeaders();

        $headerData = [
            'host' => $headers['Host']->getValue(),
            'ip_address' => $this->request->getIPAddress()
        ];

        $__user = new UserModel;
        $__user->setData($inputData);
        $__user->setAppName($this->clientAppName);

        if ($__user->login($headerData) === FALSE)
        {
            return $this->respond(null, 400, lang('Response.400'));
        }  

        $user = $__user->getRecord();

        $responseData = [
            'bearerToken' => $__user->getBearerToken(),
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'roleId' => $user['role']['id']
            ],                         
        ];            

        return $this->respond($responseData, 200, lang('Response.200'));      
    }

    public function resetPassword()
    {

        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'userEmail'           =>'required|valid_email|max_length[50]',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        } 

        $__user = new UserModel;
        if ($__user->existsEmail($inputData['userEmail']) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

        if ($__user->isVerified($inputData['userEmail'], 'email') === FALSE)
        {
            return $this->respond(null, 403, lang('Response.404'));
        }

        if ($__user->isActive($inputData['userEmail'], 'email') === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

        $userId = $__user->getUserIdFromEmail($inputData['userEmail']);
        if ($userId === FALSE)            
        {
            return $this->respond(null, 500, lang('Response.500'));
        }

        $headers = $this->request->getHeaders();

        $headerData = [
            'host' => $headers['Host']->getValue(),
            'ip_address' => $this->request->getIPAddress()
        ];

        $__user->setUserId($userId);
        if ($__user->createRequest('verify_password_reset') === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }

        $passwordNewPage = URL_APP . '#/accounts/passwords/new';
        $user = $__user->getRecord();

        $emailData = [
            'verify_url' => $passwordNewPage . '?userId=' . $user['id'] . '&email=' . $user['email'] . '&process=' . $__user->getProcess() . '&type=verify_password_reset',
        ];

        $email = \Config\Services::email();
        $email->setTo($inputData['userEmail']);
        $email->setFrom(SYSTEM_EMAIL, SYSTEM_EMAIL_SENDER_NAME);
        $email->setSubject('Resetování hesla');
        $msg = view("emails/resetPassword", [
            'url'          => $emailData['verify_url'],      
        ]);       
        $email->setMessage($msg);

        if ($email->send() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }

        return $this->respond(null, 200, lang('Response.200'));
    }

    public function newPassword()
    {
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'userId'           =>'required',
            'process'           =>'required',
            'userPassword'     =>'required|min_length[6]|max_length[20]|isStrongPassword',
            'userRepassword'   =>'required|matches[userPassword]',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        } 

        $__user = new UserModel;
        $__user->setUserId($inputData['userId']);
        if ($__user->verifyRequest('verify_password_reset', $inputData['process']) === FALSE)
        {
            return $this->respond(null, 403, lang('Response.403'));
        }

        $__user->setData($inputData);
        if ($__user->updatePassword() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }

        if ($__user->closeRequest('verify_password_reset', $inputData['process']) === FALSE)
        {
            return $this->respond(null, 403, lang('Response.403'));
        }

        $headers = $this->request->getHeaders();

        $headerData = [
            'host' => $headers['Host']->getValue(),
            'ip_address' => $this->request->getIPAddress()
        ];

        $responseData = [
            'redirect' => APP_URL . 'account/login?action=you_can_login',
        ];

        return $this->respond($responseData, 200, lang('Response.password_changed_succesfully'));
    }

    public function updatePassword()
    {
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'account_id'            =>'required',
            'user_old_password'     =>'required',
            'userPassword'         =>'required|min_length[6]|max_length[20]|isStrongPassword',
            'userRepassword'       =>'required|matches[userPassword]',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        } 

        $__user = new UserModel;
        $__user->setUserId($inputData['account_id']);
        if ($__user->verifyOldPassword($inputData['user_old_password']) === FALSE)
        {
            return $this->respond(null, 403, lang('Response.403'));
        }

        $__user->setData($inputData);
        if ($__user->updatePassword() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }

        return $this->respond(null, 200, lang('Response.password_changed_succesfully'));
        
        return TRUE;        
    }

    public function singleLogin()
    {
        $data =  "single login controller";
        return $this->respond($data, 200, lang('Response.200'));
    }

    public function activateAccount()
    {
        $validation = \Config\Services::validation();

        $inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'user_id'    =>'required',
            'process'    =>'required',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        } 

        $__user = new UserModel;
        $__user->setUserId($inputData['user_id']);
        if ($__user->verifyRequest('activate_account', $inputData['process']) === FALSE)
        {
            return $this->respond(null, 403, lang('Response.403'));
        }

        $__user->setFormat('activate');
        $__user->setUserId($inputData['user_id']);
        if ($__user->updateRecord() === FALSE)
        {
            return $this->respond(null, 500, lang('Response.500'));
        }

        if ($__user->closeRequest('activate_account', $inputData['process']) === FALSE)
        {
            return $this->respond(null, 403, lang('Response.403'));
        }

        return $this->respond(NULL, 200, 'Účet úspěšně aktivovaný.');
    }
}