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
        $csvFile = '../test_files/csv.csv';
        $headers = [];
        $transactionData = [];
        
        if (($handle = fopen($csvFile, "r")) !== FALSE)
        {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
            {
                if (count($data) > 5) {
                    $headers = $data;
                    break;
                }
            }
            
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
            {
                $rowData = [];
                foreach ($headers as $index => $header)
                {
                    $rowData[$header] = $data[$index];
                }
                $transactionData[] = $rowData;
            }
            fclose($handle);
        }
        
        print_r($transactionData);
        exit;
    }

}
