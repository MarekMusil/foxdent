<?php
namespace App\Models\System;

use CodeIgniter\Model;

class MenuModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
    }

    public function getMenu()
    {
        $menuItems = '{
            "menuLeft": [
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Zaměstnanci",
                            "route": "/employees",
                            "bootstrapIcon": "bi bi-people"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Ceník",
                            "route": "/pricelists",
                            "bootstrapIcon": "bi bi-tags"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Služby",
                            "route": "/services",
                            "bootstrapIcon": "bi bi-file-text"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Technologie",
                            "route": "/technologies",
                            "bootstrapIcon": "bi bi-cpu"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Texty",
                            "route": "/texts",
                            "bootstrapIcon": "bi bi-card-text"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Reference",
                            "route": "/ratings",
                            "bootstrapIcon": "bi bi-star"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Prezentace",
                            "route": "/slides",
                            "bootstrapIcon": "bi bi-card-image"
                        }
                    ]
                },
                {
                    "pages": [
                      {
                        "roles": [1],
                        "sectionTitle": "Nastavení",
                        "route": "/settings",
                        "bootstrapIcon": "bi bi-gear",
                        "sub": [
                          {
                            "roles": [1],
                            "heading": "Kontakt",
                            "route": "/settings/contact"
                          },
                          {
                            "roles": [1],
                            "heading": "Pojišťovny",
                            "route": "/settings/insurances"
                          }
                        ]
                      }
                    ]
                }
            ],
            "menuTop" : [
                {
                    "pages": [
                        {
                        "roles": [1],
                        "heading": "Zaměstnanci",
                        "route": "/employees",
                        "bootstrapIcon": "bi-app-indicator"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Ceník",
                            "route": "/pricelists",
                            "bootstrapIcon": "bi-app-indicator"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Služby",
                            "route": "/services",
                            "bootstrapIcon": "bi-app-indicator"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Technologie",
                            "route": "/technologies",
                            "bootstrapIcon": "bi-app-indicator"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Texty",
                            "route": "/texts",
                            "bootstrapIcon": "bi-app-indicator"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Reference",
                            "route": "/ratings",
                            "bootstrapIcon": "bi-app-indicator"
                        }
                    ]
                },
                {
                    "pages": [
                        {
                            "roles": [1],
                            "heading": "Prezentace",
                            "route": "/slides",
                            "bootstrapIcon": "bi-app-indicator"
                        }
                    ]
                },
                {
                    "heading": "Nastavení",
                    "route": "/settings",
                    "pages": [
                      {
                        "roles": [1],
                        "heading": "Kontakt",
                        "route": "/settings/contact",
                        "bootstrapIcon": "bi-cart"
                      },
                      {
                        "roles": [1],
                        "heading": "Pojišťovny",
                        "route": "/settings/insurances",
                        "bootstrapIcon": "bi-cart"
                      }
                    ]
                }
            ]
        }';
        return json_decode($menuItems, TRUE);
    }
}
