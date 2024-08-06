<?php
namespace App\Controllers\System;
use App\Controllers\BaseController;
use CodeIgniter\Controller;

use App\Models\System\MenuModel;
use App\Models\User\UserModel;
use App\Models\User\UserRoleModel;
use App\Models\Text\TextModel;

class SystemOptionController extends BaseController
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
        $__user = new UserModel;
        $users = $__user->getCacheData(IMPLICIT_DATA_FORMAT);

        $__userRole = new UserRoleModel;
        $userRoles = $__userRole->getCacheData(IMPLICIT_DATA_FORMAT);

        $__text = new TextModel;
        $texts = $__text->getCacheData('select-option-group-by-type');

        $__menu = new MenuModel;
        $menuItems = $__menu->getMenu();

        $localizations = [
            "1" => [
                'code' => 'cs_CZ',
                'name' => 'čeština'
            ],
            "2" => [
                'code' => 'en_GB',
                'name' => 'angličtina'
            ],
        ];

        $textTypes = [
            "1" => [
                'id' => '1',
                'name' => 'Služby'
            ],
            "2" => [
                'id' => '2',
                'name' => 'Technologie'
            ],
            "3" => [
                'id' => '3',
                'name' => 'Ostatní'
            ]
        ];

        $employeeTypes = [
            "1" => [
                'id' => '1',
                'name' => 'Stomatologie'
            ],
            "2" => [
                'id' => '2',
                'name' => 'Dentální hygiena'
            ],
            "3" => [
                'id' => '3',
                'name' => 'Zubní instrumentářky'
            ]
        ];

        $data = [
            'textServices'             => ($texts['services']),
            'textTechnologies'             => ($texts['technologies']),
            'textOthers'             => ($texts['others']),
            'texts'             => ($texts['all']),

            'users'             => array_values($users),
            'userRoles'         => array_values($userRoles),  
            'localizations'     => array_values($localizations),  
            'textTypes'         => array_values($textTypes),
            'employeeTypes'     => array_values($employeeTypes),    
            'menus'             => $menuItems,

        ];

        return $this->respond($data, 200, lang('Response.200'));
    }
}