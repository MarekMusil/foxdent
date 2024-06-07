<?php
namespace App\Controllers\Test;
use App\Controllers\BaseController;
use CodeIgniter\Controller;
use CodeIgniter\Format\XMLFormatter;

class GenerateOfxXml extends Controller
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
                'TRNTYPE' => 'XFER',
                'DTPOSTED' => '20210103000000.000[+01.00:CET]',
                'TRNAMT' => '-301.2900',
                'FITID' => '23629012914',
                'NAME' => 'Platba prevodem uvnitr banky',
                'BANKACCTTO' => [
                    'BANKID' => '2010',
                    'ACCTID' => '2000295813',
                    'ACCTTYPE' => 'CHECKING'
                ]
            ],
            [
                'TRNTYPE' => 'POS',
                'DTPOSTED' => '20210104000000.000[+01.00:CET]',
                'TRNAMT' => '-99.0000',
                'FITID' => '23629305623',
                'NAME' => 'Platba kartou',
                'MEMO' => 'Nakup: AWS EMEA, 5 Rue Plaetis, aws.amazon.co, L2338, LUX, dne 3.1.2021, castka 4.50 USD'
            ]
        ];

        $data = [
            'OFX' => [
                'BANKMSGSRSV1' => [
                    'STMTTRNRS' => [
                        'TRNUID' => '65b1f3dd-47bc-49ce-8543-83b2c18d46aa',
                        'STATUS' => [
                            'CODE' => 0,
                            'SEVERITY' => 'INFO'
                        ],
                        'STMTRS' => [
                            'CURDEF' => 'CZK',
                            'BANKACCTFROM' => [
                                'BANKID' => '2010',
                                'ACCTID' => '2301614881',
                                'ACCTTYPE' => 'CHECKING'
                            ],
                            'BANKTRANLIST' => [
                                'DTSTART' => '20210101000000.000[+01.00:CET]',
                                'DTEND' => '20210131000000.000[+01.00:CET]',
                                '@array_STMTTRN' => $transactions,
                            ],
                        ]
                    ]
                ]
            ]
        ];

        function arrayToXml($array, $xmlSettings = NULL, $withXmlSettings = false)
        {
            if ($withXmlSettings && !is_null($xmlSettings))
            {
                $xml = $xmlSettings;
            }
            else
            {
                $xml = '';
            }

            foreach ($array as $key => $value)
            {
                if ($key === '@attr')
                {
                    continue;
                }

                if (strpos($key, '@array_') !== false)
                {
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
        $xmlSettings = '<?xml version="1.0" encoding="utf-8" ?><?OFX OFXHEADER="200" VERSION="211" SECURITY="NONE" OLDFILEUID="NONE" NEWFILEUID="NONE"?>';
        $xmlString = arrayToXml($data, $xmlSettings, TRUE);
        file_put_contents('../ofx-generetaed.ofx', $xmlString);
        echo "Vygenerováno - ../ofx-generetaed.ofx";
    }

}
