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
      $data = [
        [
            "ID operace" => "23629012914",
            "Datum" => "03.01.2021",
            "Objem" => "-301,29",
            "Měna" => "CZK",
            "Protiúčet" => "2000295813",
            "Název protiúčtu" => "",
            "Kód banky" => "2010",
            "Název banky" => "Fio banka, a.s.",
            "KS" => "",
            "VS" => "1201201261",
            "SS" => "",
            "Poznámka" => "PLATBA ZA VP201201261",
            "Zpráva pro příjemce" => "PLATBA ZA VP201201261",
            "Typ" => "Platba převodem uvnitř banky",
            "Provedl" => "Musil, David",
            "Upřesnění" => "",
            "BIC" => "",
            "ID pokynu" => "28600063364"
        ],
        [
          "ID operace" => "33829555714",
          "Datum" => "06.01.2021",
          "Objem" => "681,67",
          "Měna" => "CZK",
          "Protiúčet" => "2000295813",
          "Název protiúčtu" => "",
          "Kód banky" => "6210",
          "Název banky" => "Mbank",
          "KS" => "",
          "VS" => "1201201261",
          "SS" => "",
          "Poznámka" => "TEST",
          "Zpráva pro příjemce" => "TEST1111",
          "Typ" => "Platba převodem uvnitř banky",
          "Provedl" => "Nový, Marek",
          "Upřesnění" => "",
          "BIC" => "",
          "ID pokynu" => "33610066674"
      ],
    ];
    
    // File path to save CSV
    $csvFilePath = "../test_files/transactions.csv";
    
// Open file for writing
$file = fopen($csvFilePath, 'w');

// Write column headers
$headerRow = '"ID operace";"Datum";"Objem";"Měna";"Protiúčet";"Název protiúčtu";"Kód banky";"Název banky";"KS";"VS";"SS";"Poznámka";"Zpráva pro příjemce";"Typ";"Provedl";"Upřesnění";"BIC";"ID pokynu"';
fwrite($file, $headerRow . PHP_EOL);

// Write data rows
foreach ($data as $row) {
    $rowData = [];
    foreach ($row as $value) {
        $rowData[] = '"' . str_replace('"', '""', $value) . '"';
    }
    fwrite($file, implode(';', $rowData) . PHP_EOL);
}

// Close the file
fclose($file);

echo "CSV file generated successfully at: $csvFilePath";
        exit;
    }

}
