<?php
namespace App\Controllers\Test;
use App\Controllers\BaseController;
use CodeIgniter\Controller;
use CodeIgniter\Format\XMLFormatter;

//FOR_CLEAR_TEMPLATE
//class TestController extends Controller
//FOR_FOXDENT_LOCAL
class GenerateXml extends Controller
{    

    public function __construct()
    {
        //FOR_CLEAR_TEMPLATE
        //parent::__construct(); 
    }
    
    public function __destruct()
    {
       exit;
    }

    public function index()
    {

        $transactions = [
            [
                'NtryRef' => '23629012914',
                'Amt' => [
                    '@attr' => [
                        'Ccy' => 'CZK'
                    ],
                    '@val' => '301.29'
                ],
                'CdtDbtInd' => 'DBIT',
                'RvslInd' => 'false',
                'Sts' => 'BOOK',
                'BookgDt' => [
                    'Dt' => '2021-01-03'
                ],
                'ValDt' => [
                    'Dt' => '2021-01-03'
                ],
                'BkTxCd' => [
                    'Prtry' => [
                        'Cd' => '10000101000',
                        'Issr' => 'Czech Banking Association'
                    ]
                ],
                'NtryDtls' => [
                    'TxDtls' => [
                        'Refs' => [
                            'MsgId' => '23629012914',
                            'EndToEndId' => 'VS:1201201261SS:KS:'
                        ],
                        'BkTxCd' => [
                            'Prtry' => [
                                'Cd' => '10000101000',
                                'Issr' => 'Czech Banking Association'
                            ]
                        ],
                        'RltdPties' => [
                            'CdtrAcct' => [
                                'Id' => [
                                    'Othr' => [
                                        'Id' => '2000295813'
                                    ]
                                ]
                            ]
                        ],
                        'RltdAgts' => [
                            'CdtrAgt' => [
                                'FinInstnId' => [
                                    'Othr' => [
                                        'Id' => '2010'
                                    ]
                                ]
                            ]
                        ],
                        'RmtInf' => [
                            'Ustrd' => 'PLATBA ZA VP201201261'
                        ]
                    ]
                ]
            ],
            [
                'NtryRef' => '23629305623',
                'Amt' => [
                    '@attr' => [
                        'Ccy' => 'CZK'
                    ],
                    '@val' => '99.00'
                ],
                'CdtDbtInd' => 'DBIT',
                'RvslInd' => 'false',
                'Sts' => 'BOOK',
                'BookgDt' => [
                    'Dt' => '2021-01-04'
                ],
                'ValDt' => [
                    'Dt' => '2021-01-04'
                ],
                'BkTxCd' => [
                    'Prtry' => [
                        'Cd' => '30000201000',
                        'Issr' => 'Czech Banking Association'
                    ]
                ],
                'NtryDtls' => [
                    'TxDtls' => [
                        'Refs' => [
                            'MsgId' => '23629305623',
                            'EndToEndId' => 'VS:2572SS:KS:'
                        ],
                        'BkTxCd' => [
                            'Prtry' => [
                                'Cd' => '30000201000',
                                'Issr' => 'Czech Banking Association'
                            ]
                        ],
                        'RmtInf' => [
                            'Ustrd' => 'Nákup: AWS EMEA, 5 Rue Plaetis, aws.amazon.co, L2338, LUX, dne 3.1.2021, částka 4.50 USD'
                        ],
                        'AddtlTxInf' => 'Nákup: AWS EMEA, 5 Rue Plaetis, aws.amazon.co, L2338, LUX, dne 3.1.2021, částka 4.50 USD'
                    ]
                ]
            ]
        ];

        $data = [
            'Document' => [
                '@attr' => [
                    'xmlns' => 'urn:iso:std:iso:20022:tech:xsd:camt.053.001.02'
                ],
                'BkToCstmrStmt' => [
                    'GrpHdr' => [
                        'MsgId' => 'camt.053-2021-01-31-001',
                        'CreDtTm' => '2024-05-15T08:33:15.033+02:00',
                        'MsgRcpt' => [
                            'Nm' => 'Davmo Software s.r.o.',
                            'PstlAdr' => [
                                'StrtNm' => 'Podbabská 81/17',
                                'PstCd' => '16000',
                                'TwnNm' => 'Praha 6 Bubeneč',
                                'Ctry' => 'CZ'
                            ],
                            'Id' => [
                                'OrgId' => [
                                    'Othr' => [
                                        'Id' => 'Davmo Software s.r.o.'
                                    ]
                                ]
                            ]
                        ],
                        'MsgPgntn' => [
                            'PgNb' => '1',
                            'LastPgInd' => 'true'
                        ],
                        'AddtlInf' => 'Měsíční'
                    ],
                    'Stmt' => [
                        'Id' => 'CZ2420100000002301614881-2021-01-31',
                        'ElctrncSeqNb' => '1',
                        'LglSeqNb' => '1',
                        'CreDtTm' => '2024-05-15T08:33:15.033+02:00',
                        'FrToDt' => [
                            'FrDtTm' => '2021-01-01T00:00:00.000+01:00',
                            'ToDtTm' => '2021-01-31T23:59:59.999+01:00'
                        ],
                        'Acct' => [
                            'Id' => [
                                'IBAN' => 'CZ2420100000002301614881'
                            ],
                            'Tp' => [
                                'Cd' => 'CASH'
                            ],
                            'Ccy' => 'CZK',
                            'Nm' => 'Davmo Software s.r.o.',
                            'Ownr' => [
                                'Nm' => 'Davmo Software s.r.o.',
                                'PstlAdr' => [
                                    'StrtNm' => 'Podbabská 81/17',
                                    'PstCd' => '16000',
                                    'TwnNm' => 'Praha 6 Bubeneč',
                                    'Ctry' => 'CZ'
                                ],
                                'Id' => [
                                    'OrgId' => [
                                        'Othr' => [
                                            'Id' => 'Davmo Software s.r.o.'
                                        ]
                                    ]
                                ]
                            ],
                            'Svcr' => [
                                'FinInstnId' => [
                                    'BIC' => 'FIOBCZPPXXX',
                                    'Nm' => 'FIOBCZPP',
                                    'PstlAdr' => [
                                        'StrtNm' => 'V Celnici 1028/10',
                                        'TwnNm' => '11721 Praha 1',
                                        'Ctry' => 'CZ'
                                    ],
                                    'Othr' => [
                                        'Id' => '2010'
                                    ]
                                ]
                            ]
                        ],
                        'Intrst' => [
                            'Rate' => [
                                'Tp' => [
                                    'Pctg' => '0.00'
                                ]
                            ]
                        ],
                        '@array_Bal' => [
                            [
                                'Tp' => [
                                    'CdOrPrtry' => [
                                        'Cd' => 'PRCD'
                                    ]
                                ],
                                'Amt' => [
                                    '@attr' => [
                                        'Ccy' => 'CZK'
                                    ],
                                    '@val' => '308182.83'
                                ],
                                'CdtDbtInd' => 'CRDT',
                                'Dt' => [
                                    'Dt' => '2021-01-01'
                                ]
                            ],
                            [
                                'Tp' => [
                                    'CdOrPrtry' => [
                                        'Cd' => 'CLBD'
                                    ]
                                ],
                                'Amt' => [
                                    '@attr' => [
                                        'Ccy' => 'CZK'
                                    ],
                                    '@val' => '266182.51'
                                ],
                                'CdtDbtInd' => 'CRDT',
                                'Dt' => [
                                    'Dt' => '2021-01-31'
                                ]
                            ]
                        ],
                        'TxsSummry' => [
                            'TtlNtries' => [
                                'NbOfNtries' => '19',
                                'Sum' => '57911.82',
                                'TtlNetNtryAmt' => '42000.32',
                                'CdtDbtInd' => 'DBIT'
                            ],
                            'TtlCdtNtries' => [
                                'NbOfNtries' => '2',
                                'Sum' => '7955.75'
                            ],
                            'TtlDbtNtries' => [
                                'NbOfNtries' => '17',
                                'Sum' => '49956.07'
                            ]
                        ], 
                        '@array_Ntry' => $transactions
                    ]
                ]
            ]
        ];

        function arrayToXml($array, $filename = 'file' )
        {
            $xml = '';
            foreach ($array as $key => $value) {
                if ($key === '@attr') {
                    continue;
                }

                if (strpos($key, '@array_') !== false) {
                    $elementName = substr($key, strpos($key, '@array_') + strlen('@array_'));
                    //print_r($value);
                    foreach ($value as $arrayValue)
                    {
                        $xml .= "<$elementName";
                        if (isset($arrayValue['@attr'])) {
                            foreach ($arrayValue['@attr'] as $attrKey => $attrValue) {
                                $xml .= " $attrKey=\"$attrValue\"";
                            }
                        }
                        $xml .= ">";
        
                        if (is_array($arrayValue)) {
                            if (isset($arrayValue['@attr'])) {
                                unset($arrayValue['@attr']);
                            }
                            if (isset($arrayValue['@val'])) {
                                $xml .= htmlspecialchars($arrayValue['@val']);
                            } else {
                                $xml .= arrayToXml($arrayValue);
                            }
                        } else {
                            $xml .= htmlspecialchars($arrayValue);
                        }
                        $xml .= "</$elementName>";
                    }
                }
                else
                {
                    $xml .= "<$key";
                    // Přidání atributů, pokud jsou k dispozici
                    if (isset($value['@attr'])) {
                        foreach ($value['@attr'] as $attrKey => $attrValue) {
                            $xml .= " $attrKey=\"$attrValue\"";
                        }
                    }
                    $xml .= ">";
    
                    if (is_array($value)) {
                        if (isset($value['@attr'])) {
                            unset($value['@attr']);
                        }
                        if (isset($value['@val'])) {
                            $xml .= htmlspecialchars($value['@val']);
                        } else {
                            $xml .= arrayToXml($value);
                        }
                    } else {
                        $xml .= htmlspecialchars($value);
                    }
                    $xml .= "</$key>";
                }
            }
            return $xml;
        }
        
        // Vytvoření XML řetězce
        $xmlString = arrayToXml($data, 'filename');

        file_put_contents('../test_file.xml', $xmlString);

        // Tisk XML
        echo $xmlString;
    }
}
