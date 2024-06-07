<?php
namespace App\Controllers\Test;
use App\Controllers\BaseController;
use CodeIgniter\Controller;

class TestController extends Controller
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
      function formatValue($value, $length)
      {
        return str_pad(substr($value, 0, $length), $length, " ");
    }
    
    function generateStatementHeader($data) {
        $header = "074";
        $header .= formatValue($data['accountNumber'], 16);
        $header .= formatValue($data['accountOwner'], 20);
        $header .= formatValue($data['openingBalanceDate'], 6);
        $header .= formatValue($data['openingBalance'], 14);
        $header .= formatValue($data['openingBalanceSign'], 1);
        $header .= formatValue($data['closingBalance'], 14);
        $header .= formatValue($data['closingBalanceSign'], 1);
        $header .= formatValue($data['debitSum'], 14);
        $header .= "0"; // Sign for debit balances
        $header .= formatValue($data['creditSum'], 14);
        $header .= "0"; // Sign for credit balances
        $header .= formatValue($data['serialNumber'], 3);
        $header .= formatValue($data['statementDate'], 6);
        $header .= str_repeat(" ", 13); // Filled by spaces
        return $header;
    }
    
    function generateTransactionDetail($data) {
        $transaction = "075";
        $transaction .= formatValue($data['accountNumber'], 16);
        $transaction .= formatValue($data['counterpartyAccountNumber'], 16);
        $transaction .= formatValue($data['transactionIdentifier'], 13);
        $transaction .= formatValue($data['transactionAmount'], 12);
        $transaction .= formatValue($data['accountingType'], 1);
        $transaction .= formatValue($data['variableCode'], 10);
        $transaction .= "00"; // Delimiter
        $transaction .= formatValue($data['counterpartyBankCode'], 4);
        $transaction .= formatValue($data['constantCode'], 4);
        $transaction .= formatValue($data['specificCode'], 10);
        $transaction .= formatValue($data['valueDate'], 6);
        $transaction .= formatValue($data['counterpartyName'], 20);
        $transaction .= formatValue($data['currencyCode'], 5);
        $transaction .= formatValue($data['postingDate'], 6);
        return $transaction;
    }
    
    // Usage example
    $statementData = [
        'accountNumber' => "1234567890123456",
        'accountOwner' => "Account Owner",
        'openingBalanceDate' => "01012024",
        'openingBalance' => "100000000000.00",
        'openingBalanceSign' => "+",
        'closingBalance' => "120000000000.00",
        'closingBalanceSign' => "+",
        'debitSum' => "5000000000.00",
        'creditSum' => "7000000000.00",
        'serialNumber' => "001",
        'statementDate' => "311223"
    ];
    
    $transactionData = [
      0 => [
        'accountNumber' => "1234567890123456",
        'counterpartyAccountNumber' => "9876543210123456",
        'transactionIdentifier' => "001000000001",
        'transactionAmount' => "150099",
        /*
        Accounting type – 1 for debit (outgoing) transaction, 2 for credit (incoming)
        transaction, 4 for debit reversal and 5 for credit reversal 
         */
        'accountingType' => "1",
        'variableCode' => "0000000000",
        'counterpartyBankCode' => "6211",
        'constantCode' => "6210",
        'specificCode' => "0000000000",
        'valueDate' => "311223",
        'counterpartyName' => "Counterparty Name 11",
        'currencyCode' => "00208",
        'postingDate' => "311223"
      ],
      1 => [
        'accountNumber' => "6543210987654321",
        'counterpartyAccountNumber' => "5555543210123456",
        'transactionIdentifier' => "001000000001",
        'transactionAmount' => "35000",
        'accountingType' => "1",
        'variableCode' => "0000000000",
        'counterpartyBankCode' => "1051",
        'constantCode' => "1050",
        'specificCode' => "0000000000",
        'valueDate' => "311223",
        'counterpartyName' => "Counterparty Name 22",
        'currencyCode' => "00208",
        'postingDate' => "311223"
      ]
    ];
    $content = generateStatementHeader($statementData) . "\n";
    foreach ($transactionData as $transaction)
    {
      $content .= generateTransactionDetail($transaction) . "\n";
    }

    $file = fopen("../test_files/generateGpc.gpc", "w") or die("Unable to open file!");
    fwrite($file, $content);
    fclose($file);

    }
 
}
