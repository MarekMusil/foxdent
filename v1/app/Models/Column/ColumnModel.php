<?php
namespace App\Models\Column;

use CodeIgniter\Model;

class ColumnModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
    }

    public function getColumns()
    {
        $modules = '{                      
            "users": [
                {
                    "key": "id",
                    "dataAttr": "id",
                    "name": "ID",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "name",
                    "dataAttr": "name",
                    "name": "Jméno",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 1,
                    "url": "/settings/users"
                },
                {
                    "key": "role_id",
                    "dataAttr": "role.name",
                    "name": "Typ uživatele",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "create_time",
                    "dataAttr": "createTime.format",
                    "name": "Vytvořeno",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "options",
                    "name": "Možnosti",
                    "rank": 0,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "...",
                    "items": [
                        {
                            "key": "edit",
                            "icon": "bi bi-pencil",
                            "name": "Editovat",
                            "isLink": 1,
                            "url": "/settings/users/{:id}"
                        }                     
                    ]
                }
            ],
            "employees": [
                {
                    "key": "id",
                    "dataAttr": "id",
                    "name": "ID",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                
                {
                    "key": "name",
                    "dataAttr": "name",
                    "name": "Jméno",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 1,
                    "url": "/employees/{:id}"
                },
                {
                    "key": "degree",
                    "dataAttr": "degree",
                    "name": "Titul",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "text",
                    "dataAttr": "text",
                    "name": "Povolání",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "type",
                    "dataAttr": "type.name",
                    "name": "Typ",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "rank",
                    "dataAttr": "rank",
                    "name": "Pořadí",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "create_time",
                    "dataAttr": "createTime.format",
                    "name": "Vytvořeno",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "options",
                    "name": "Možnosti",
                    "rank": 0,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "...",
                    "items": [
                        {
                            "key": "edit",
                            "icon": "bi bi-pencil",
                            "name": "Editovat",
                            "isLink": 1,
                            "url": "/employees/{:id}"
                        }                     
                    ]
                }
            ],
            "slides": [
                {
                    "key": "id",
                    "dataAttr": "id",
                    "name": "ID",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "img",
                    "dataAttr": "photoImgUrl",
                    "name": "Pozadí",
                    "rank": 1,
                    "sorting": 0,
                    "isImg": 1,
                    "isLink": 1,
                    "url": "/slides/{:id}"
                },
                {
                    "key": "title",
                    "dataAttr": "title",
                    "name": "Titulek",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 1,
                    "url": "/slides/{:id}"
                },
                {
                    "key": "text",
                    "dataAttr": "text.plainShort",
                    "name": "Text",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "button_1",
                    "dataAttr": "button1",
                    "name": "Tlačítko 1",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "button_2",
                    "dataAttr": "button2",
                    "name": "Tlačítko 2",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "rank",
                    "dataAttr": "rank",
                    "name": "Pořadí",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "update_time",
                    "dataAttr": "updateTime.format",
                    "name": "Upraveno",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "options",
                    "name": "Možnosti",
                    "rank": 0,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "...",
                    "items": [
                        {
                            "key": "edit",
                            "icon": "bi bi-pencil",
                            "name": "Editovat",
                            "isLink": 1,
                            "url": "/slides/{:id}"
                        }                     
                    ]
                }
            ],
            "texts": [
                {
                    "key": "texts_translations.id",
                    "dataAttr": "id",
                    "name": "ID",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "name",
                    "dataAttr": "name",
                    "name": "Jméno",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 1,
                    "url": "/texts/{:id}"
                },
                {
                    "key": "localization",
                    "dataAttr": "localization",
                    "name": "Jazyk",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "type",
                    "dataAttr": "type.text",
                    "name": "Typ",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "title",
                    "dataAttr": "title",
                    "name": "Titulek",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "subtitle",
                    "dataAttr": "subtitle",
                    "name": "Podtitulek",
                    "rank": 1,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "rank",
                    "dataAttr": "rank",
                    "name": "Pořadí",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "update_time",
                    "dataAttr": "updateTime.format",
                    "name": "Upraveno",
                    "rank": 1,
                    "sorting": 1,
                    "isLink": 0,
                    "url": "..."
                },
                {
                    "key": "options",
                    "name": "Možnosti",
                    "rank": 0,
                    "sorting": 0,
                    "isLink": 0,
                    "url": "...",
                    "items": [
                        {
                            "key": "edit",
                            "icon": "bi bi-pencil",
                            "name": "Editovat",
                            "isLink": 1,
                            "url": "/texts/{:id}"
                        }                     
                    ]
                }
            ]
        }';
        
        return json_decode($modules, TRUE);
    }
}