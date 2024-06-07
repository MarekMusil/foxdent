<?php
namespace App\Controllers\Account;
use App\Controllers\BaseController;
use CodeIgniter\Controller;

use App\Models\User\UserModel;


class AccountMeController extends BaseController
{

    public function __construct()
    {
        parent::__construct(); 
    }

    public function __destruct()
    {
        exit;
    }

	public function update()
	{
		$userId = $this->getLoggedUserId();

		$__user = new UserModel;

		if ($__user->existsId($userId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

		$validation = \Config\Services::validation();

		$inputData = $this->request->getJSON(TRUE);

        $validationRules = [
            'userEmail'     	   =>'required|valid_email',
        ];
        $validation->setRules($validationRules);

        if ($validation->run($inputData) === FALSE)
        {
            $errors = $validation->getErrors();
            $data['errors']=$errors;
            return $this->respond($data, 422, lang('Response.422'));
        } 

		if ($__user->existsEmail($inputData['userEmail'], $userId) === TRUE)
        {
            return $this->respond(null, 422, lang('Email již existuje'));
        }

		$data = [
			'email' => $inputData['userEmail'],
		];
        
		$__user->setUserId($userId);
		$__user->setData($data);
		if ($__user->updateRecord() === FALSE)
		{
			return $this->respond(null, 500, lang('Response.500'));
		}

		return $this->respond(null, 200, lang('Response.200'));

	}

    public function updatePassword()
	{
		$userId = $this->getLoggedUserId();
		$__user = new UserModel;

		if ($__user->existsId($userId) === FALSE)
        {
            return $this->respond(null, 404, lang('Response.404'));
        }

		$validation = \Config\Services::validation();

		$inputData = $this->request->getJSON(TRUE);

        $validationRules = [
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

		$data = [
			'password' => $inputData['userRepassword'],
		];
        
		$__user->setUserId($userId);
		$__user->setData($data);
		if ($__user->updateRecord() === FALSE)
		{
			return $this->respond(null, 500, lang('Response.500'));
		}

		return $this->respond(null, 200, lang('Response.200'));

	}
}