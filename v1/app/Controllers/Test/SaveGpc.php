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

        //GPC_TYPE_REPORT = '074';
        //GPC_TYPE_ITEM = '075';
        
        $filename = '../test_files/generateGpc.gpc';
        //$GpcString = file_get_contents($GpcPath);

        $data = array();

        if (($handle = fopen($filename, "r")) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, ";")) !== FALSE)
            {
                $data[] = $row;
            }
            fclose($handle);
        }

        foreach ($data as $row)
        {
          $records[] = $this->parseLine($row[0]);
        }

        foreach($records as $Record)
        {
          if($Record['Type'] == GPC_TYPE_REPORT) {
            $recordData = array(
                'AccountName' => $Record['AccountName'],
                'AccountNumber' => $Record['AccountNumber'],
                'OldBalanceDate' => date('j.n.Y', $Record['OldBalanceDate']),
                'OldBalanceValue' => $Record['OldBalanceValue'],
                'NewBalanceDate' => date('j.n.Y', $Record['Date']),
                'NewBalanceValue' => $Record['NewBalanceValue'],
                'CreditValue' => $Record['CreditValue'],
                'DebitValue' => $Record['DebitValue']
            );
            // Přidání záznamu do pole
            $GpcData[] = $recordData;
          } elseif($Record['Type'] == GPC_TYPE_ITEM) {
              $recordData = array(
                  'DueDate' => date('j.n.Y', $Record['DueDate']),
                  'Value' => $Record['Value'],
                  'OffsetAccount' => $Record['OffsetAccount'],
                  'BankCode' => $Record['BankCode'],
                  'ConstantSymbol' => $Record['ConstantSymbol'],
                  'VariableSymbol' => $Record['VariableSymbol'],
                  'SpecificSymbol' => $Record['SpecificSymbol'],
                  'ClientName' => $Record['ClientName']
              );
              // Přidání záznamu do pole
              $GpcData[] = $recordData;
          }
        }

        print_r($GpcData);exit;

    }

    private function ParseLine($Line)
    {  
      $Line = ' '.$Line;
      $Type = substr($Line, 1, 3);                                                    
         
      if($Type == GPC_TYPE_REPORT)
      {
        $GPCLine = array
        (
          'Type' => GPC_TYPE_REPORT,
          'AccountNumber' => substr($Line, 4, 16),
          'AccountName' => iconv('Windows-1250', 'UTF-8//TRANSLIT', trim(substr($Line, 20, 20))),
          'OldBalanceDate' => mktime(0, 0, 0, substr($Line, 42, 2), substr($Line, 40, 2), '20'.substr($Line, 44, 2)),
          'OldBalanceValue' => (substr($Line, 60, 1).substr($Line, 46, 14)) / 100, 
          'NewBalanceValue' => (substr($Line, 75, 1).substr($Line, 61, 14)) / 100,
          'DebitValue' => (substr($Line, 90, 1).substr($Line, 76, 14)) / 100,    
          'CreditValue' => (substr($Line, 105, 1).substr($Line, 91, 14)) / 100,    
          'SequenceNumber' => intval(substr($Line, 106, 3)),
          'Date' => mktime(0, 0, 0, substr($Line, 111, 2), substr($Line, 109, 2), '20'.substr($Line, 113, 2)),
          //'DataAlignment' => substr($Line, 115, 14),
          'CheckSum' => sha1(md5($Line).$Line),
        );
      } else    
      if($Type == GPC_TYPE_ITEM)
      {    
        $GPCLine = array
        (
          'Type' => GPC_TYPE_ITEM,
          'AccountNumber' => substr($Line, 4, 16),
          'OffsetAccount' => substr($Line, 20, 16), 
          'RecordNumber' => substr($Line, 36, 13), 
          'Value' => substr($Line, 49, 12) / 100,
          'Code' => substr($Line, 61, 1),    
          'VariableSymbol' => intval(substr($Line, 62, 10)),
          'BankCode' => substr($Line, 74, 4),
          'ConstantSymbol' => intval(substr($Line, 78, 4)),
          'SpecificSymbol' => intval(substr($Line, 82, 10)), 
          'Valut' => substr($Line, 92, 6),
          'ClientName' => iconv('Windows-1250', 'UTF-8//TRANSLIT', substr($Line, 98, 20)),
          //'Zero' => substr($Line, 118, 1),
          'CurrencyCode' => substr($Line, 119, 4),
          'DueDate' => mktime(0, 0, 0, substr($Line, 125, 2), substr($Line, 123, 2), substr($Line, 127, 2)),
          'CheckSum' => sha1(md5($Line).$Line),
        );
      } else 
      $GPCLine = NULL;
      
      return($GPCLine);
    }
  
}
