<?php
namespace App\Models\Button;

use CodeIgniter\Model;

class ButtonModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
    }

    public function getButtons()
    {
        $modules = '{
            "users": {
                "create": {
                    "title": "Přidat",
                    "isLink": 1,
                    "class" : "btn-success",
                    "icon": "bi bi-plus",
                    "url": "/settings/users/create"
                }
            },
            "employees": {
                "create": {
                    "title": "Přidat",
                    "isLink": 1,
                    "class" : "btn-success",
                    "icon": "bi bi-plus",
                    "url": "/employees/create"
                }
            },
            "slides": {
                "create": {
                    "title": "Přidat",
                    "isLink": 1,
                    "class" : "btn-success",
                    "icon": "bi bi-plus",
                    "url": "/slides/create"
                }
            },
            "texts": {
                "create": {
                    "title": "Přidat",
                    "isLink": 1,
                    "class" : "btn-success",
                    "icon": "bi bi-plus",
                    "url": "/texts/create"
                }
            }
        }';
        return json_decode($modules, TRUE);
    }
}