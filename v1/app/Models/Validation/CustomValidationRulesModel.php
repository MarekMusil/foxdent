<?php
namespace App\Models\Validation;

use App\Models\User\UserModel;
use App\Models\User\UserRoleModel;


class CustomValidationRulesModel
{

    public function selectedFromUsers($userId, ?string &$error = null)
    {
        $__user = new UserModel;

        if ($__user->existsId($userId) === TRUE)
        {
            return TRUE;
        }
        $error = lang('Vybrali jste neplatnou hodnotu.');
        return FALSE;      
    }

    public function selectedFromUsersTechnicians($userId, ?string &$error = null)
    {
        $__user = new UserModel;

        if ($__user->existsTechnicianId($userId) === TRUE)
        {
            return TRUE;
        }
        $error = lang('Vybrali jste neplatnou hodnotu.');
        return FALSE;      
    }

    public function isStrongPassword($password, ?string &$error = null)
    {
        $hasCapitalLetter = FALSE;
        $hasDigit = FALSE;
        $isLong = FALSE;

        $letters = [];
        for ($i = 0; $i < strlen($password); $i++)
        {
            $letters[$i] = substr($password, $i, 1);
        }

        if (strlen($password) >= 6) {
            $isLong = TRUE;
        }

        foreach ($letters as $letter)
        {
            if (ctype_upper($letter))
            {
                $hasCapitalLetter = TRUE;
            }
            
            if (ctype_digit($letter))
            {
                $hasDigit = TRUE;
            }            
        }
        
        if ($hasCapitalLetter === TRUE && $hasDigit === TRUE && $isLong === TRUE)
        {
            return TRUE;
        }

        $error = lang('Heslo není dostatečně silné');
        return FALSE;
    }

}