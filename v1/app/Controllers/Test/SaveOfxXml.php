<?php
namespace App\Controllers\Test;
use App\Controllers\BaseController;
use CodeIgniter\Controller;

class SaveOfxXml extends Controller
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
        $xmlFilePath = '../test_files/ofx.ofx';
        $xmlString = file_get_contents($xmlFilePath);
        $xml = simplexml_load_string($xmlString);
    
        $statement = [];
    
        $stmttrnrs = $xml->BANKMSGSRSV1->STMTTRNRS;
        $status = $stmttrnrs->STATUS;
        $stmtrs = $stmttrnrs->STMTRS;
        $bankacntfrom = $stmtrs->BANKACCTFROM;
        $banktranlist = $stmtrs->BANKTRANLIST;
    
        $statement['header'] = [
            'trnuid' => (string)$stmttrnrs->TRNUID,
            'status' => [
                'code' => (int)$status->CODE,
                'severity' => (string)$status->SEVERITY
            ]
        ];
    
        $statement['transactions'] = [];


        $statement['transactions']['bankAccountFrom'] = [
            'bankId' => (string)$bankacntfrom->BANKID,
            'accountId' => (string)$bankacntfrom->ACCTID,
            'accountType' => (string)$bankacntfrom->ACCTTYPE,
        ];

        $statement['transactions']['fromToDate'] = [
            'from' => (string)$banktranlist->DTSTART,
            'to' => (string)$banktranlist->DTEND,
        ];
    
        foreach ($banktranlist->STMTTRN as $transaction) {
            $transactionData = [
                'trntype' => (string)$transaction->TRNTYPE,
                'dtposted' => (string)$transaction->DTPOSTED,
                'trnamt' => (float)$transaction->TRNAMT,
                'fitid' => (string)$transaction->FITID,
                'name' => (string)$transaction->NAME
            ];
    
            if (isset($transaction->MEMO))
            {
                $transactionData['memo'] = (string)$transaction->MEMO;
            }
            if (isset($transaction->BANKACCTTO))
            {
                $transactionData['bankacctto'] = [
                    'bankid' => (string)$transaction->BANKACCTTO->BANKID,
                    'acctid' => (string)$transaction->BANKACCTTO->ACCTID,
                    'accttype' => (string)$transaction->BANKACCTTO->ACCTTYPE
                ];
            }
    
            $statement['transactions']['records'][] = $transactionData;
        }
    
        print_r($statement);

    }
}
