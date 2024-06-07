<?php
namespace App\Controllers\Test;
use App\Controllers\BaseController;
use CodeIgniter\Controller;
use DateTime;

class TestController extends BaseController
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
        $file = '../test_files/bankTransactions.csv';
        if (($handle = fopen($file, 'r')) !== FALSE)
        {
            $payments = [];
            $delimiter = ',';
            $row = 0;
            $dt = new DateTime;
            $errors_count = 0;
            $errors_string = '';
            while (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE)
            {
                if ($row == 0)
                {
                    //print_r($data);
                }
    
                if ($row > 0)
                {
                    //print_r($data);exit;
                    $account_number = $data[2] . '/' . $data[3];
                    if ($this->isValidBankAccount($account_number) === FALSE)
                    {
                        $errors_count++;
                        $errors_string .= 'r.' . ($row) . ' ' . $account_number . '; ';
                    }
    
                    $payment = [
                        'bank_account' => $data[2],
                        'bank_code' => $data[3],
                        'amount' => $data[1],
                        'var_symbol' => $data[4],
                        'message' => $data[5],
                    ];
                    $payments[] = $payment;
                }
    
                $row++;
            }
            //var_dump($errors_count);exit;
            //print_r($errors_string);exit;
            //print_r($payments);exit;
            //$data = $payments[5];
            //$payments = [];
            //$payments[] = $data;
    
            if ($errors_count == 0)
            {
                $xml_file = './temp/data_xml/fio_payments.xml';
    
                $document = new \DOMDocument('1.0', 'utf-8');
                $document->formatOutput = true;
    
                $el_Import = $document->createElement('Import');
                $document->appendChild($el_Import);
    
                $at_xmlns_xsi = $document->createAttribute('xmlns:xsi');
                $at_xmlns_xsi->value = 'http://www.w3.org/2001/XMLSchema-instance';
                $el_Import->appendChild($at_xmlns_xsi);
    
                $at_xsi_noNamespaceSchemaLocation = $document->createAttribute('xsi:noNamespaceSchemaLocation');
                $at_xsi_noNamespaceSchemaLocation->value = 'http://www.fio.cz/schema/importIB.xsd';
                $el_Import->appendChild($at_xsi_noNamespaceSchemaLocation);
    
                $el_Orders = $document->createElement('Orders');
                $el_Import->appendChild($el_Orders);
    
                foreach ($payments as $payment)
                {
                    $el_DomesticTransaction = $document->createElement('DomesticTransaction');
                    $el_Orders->appendChild($el_DomesticTransaction);
    
                    $el_accountFrom = $document->createElement('accountFrom', FIO_PAYMENT_BANK_ACCOUNT);
                    $el_DomesticTransaction->appendChild($el_accountFrom);
    
                    $el_currency = $document->createElement('currency', FIO_PAYMENT_CURRENCY);
                    $el_DomesticTransaction->appendChild($el_currency);
    
                    $el_amount = $document->createElement('amount', $payment['amount']);
                    $el_DomesticTransaction->appendChild($el_amount);    
    
                    $el_accountTo = $document->createElement('accountTo', $payment['bank_account']);
                    $el_DomesticTransaction->appendChild($el_accountTo);
    
                    $el_bankCode = $document->createElement('bankCode', $payment['bank_code']);
                    $el_DomesticTransaction->appendChild($el_bankCode);
    
                    $el_vs = $document->createElement('vs', $payment['var_symbol']);
                    $el_DomesticTransaction->appendChild($el_vs);
    
                    $el_date = $document->createElement('date', $dt->format('Y-m-d'));
                    $el_DomesticTransaction->appendChild($el_date);
    
                    $el_messageForRecipient = $document->createElement('messageForRecipient', $payment['message']);
                    $el_DomesticTransaction->appendChild($el_messageForRecipient);
    
                    $el_paymentType = $document->createElement('paymentType', 431001);
                    $el_DomesticTransaction->appendChild($el_paymentType);
                }
    
                $document->save($xml_file);
    
                $curl_url = FIO_API_URL;
                //var_dump($curl_url);exit;
                $c_file = new \CURLFile($xml_file, 'application/xml');
                $curl_header = [
                    'Content-Type:multipart/form-data;charset=utf-8;',
                ];
                $curl_data = [
                    'type' => 'xml',
                    'token' => FIO_API_TOKEN,
                    'lng' => 'cs',
                    'file' => $c_file,
                ];
    
                $c = curl_init();
                curl_setopt($c, CURLOPT_URL, $curl_url);
                curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($c, CURLOPT_POST, 1);
                curl_setopt($c, CURLOPT_POSTFIELDS, $curl_data);
                curl_setopt($c, CURLOPT_HTTPHEADER, $curl_header);
                curl_setopt($c, CURLOPT_HEADER, 0);
                curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
                /*curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 1);
                curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($c, CURLOPT_VERBOSE, 0);*/
    
                $xml_response = curl_exec($c);
                curl_close($c);
                file_put_contents('./temp/api/response.xml', $xml_response);
                unlink($file);
                unlink($xml_file);
    
                $xml_response_file = simplexml_load_file('./temp/api/response.xml');
                print_r($xml_response_file->result);exit;
    
                if ($xml_response_file->result->errorCode == 0)
                {
                    return $this->respond(NULL, 201, lang('Platební příkazy byly vytvořeny. <a href="' . base_url() . '">Můžete nahrát další soubor.</a>'));

                }
                else
                {
                    return $this->respond(NULL, 500, lang('Platební příkazy nemohly být vytvořeny. <a href="https://dropshippingcz.dataimport.cz/temp/api/response.xml" target="_blank">Zobrazit podrobnosti</a>.'));
                }
            }
            else
            {
                if (substr($errors_string, -2, 2) == '; ')
                {
                    $errors_string = substr($errors_string, 0, -2);
                }

                return $this->respond(NULL, 500, lang('Některá čísla účtů [' . $errors_count . '] (konkrétně [' . $errors_string . ']) jsou chybná.'));

            }
        }
        else
        {
            return $this->respond(NULL, 500, lang('Soubor se nepodařilo otevřít.'));
        }
    }

    private function isValidBankAccount($bank_account, $return_bank_name = FALSE)
    {
        $prefix_weights = [ 10, 5, 8, 4, 2, 1 ];
        
        // Váhy pro kontrolu základní části čísla
        $base_weights = [6, 3, 7, 9, 10, 5, 8, 4, 2, 1];
        
        // Výpis všech bank působících v ČR k datu 31. 08. 2017
        $banks = [
            "0100" => "Komerční banka, a.s.",
            "0300" => "Československá obchodní banka, a.s.",
            "0600" => "MONETA Money Bank, a.s.",
            "0710" => "Česká národní banka",
            "0800" => "Česká spořitelna, a.s.",
            "2010" => "Fio banka, a.s.",
            "2020" => "MUFG Bank (Europe) N.V. Prague Branch",
            "2030" => "Československé úvěrní družstvo",
            "2060" => "Citfin, spořitelní družstvo",
            "2070" => "Moravský Peněžní Ústav – spořitelní družstvo",
            "2100" => "Hypoteční banka, a.s.",
            "2200" => "Peněžní dům, spořitelní družstvo",
            "2220" => "Artesa, spořitelní družstvo",
            "2240" => "Poštová banka, a.s., pobočka Česká republika",
            "2250" => "Banka CREDITAS a.s.",
            "2260" => "ANO spořitelní družstvo",
            "2275" => "Podnikatelská družstevní záložna",
            "2310" => "Raiffeisenbank a.s.-doběh plateb ZUNO",
            "2600" => "Citibank Europe plc, organizační složka",
            "2700" => "UniCredit Bank Czech Republic and Slovakia, a.s.",
            "3030" => "Air Bank a.s.",
            "3050" => "BNP Paribas Personal Finance SA, odštěpný závod",
            "3060" => "PKO BP S.A., Czech Branch",
            "3500" => "ING Bank N.V.",
            "4000" => "Expobank CZ a.s.",
            "4300" => "Českomoravská záruční a rozvojová banka, a.s.",
            "5500" => "Raiffeisenbank a.s.",
            "5800" => "J & T BANKA, a.s.",
            "6000" => "PPF banka a.s.",
            "6100" => "Equa bank a.s.",
            "6200" => "COMMERZBANK Aktiengesellschaft, pobočka Praha",
            "6210" => "mBank S.A., organizační složka",
            "6300" => "BNP Paribas Fortis SA/NV, pobočka Česká republika",
            "6700" => "Všeobecná úverová banka a.s., pobočka Praha",
            "6800" => "Sberbank CZ, a.s.",
            "7910" => "Deutsche Bank Aktiengesellschaft Filiale Prag, organizační složka",
            "7940" => "Waldviertler Sparkasse Bank AG",
            "7950" => "Raiffeisen stavební spořitelna a.s.",
            "7960" => "Českomoravská stavební spořitelna, a.s.",
            "7970" => "Wüstenrot-stavební spořitelna a.s.",
            "7980" => "Wüstenrot hypoteční banka a.s.",
            "7990" => "Modrá pyramida stavební spořitelna, a.s.",
            "8030" => "Raiffeisenbank im Stiftland eG pobočka Cheb, odštěpný závod",
            "8040" => "Oberbank AG pobočka Česká republika",
            "8060" => "Stavební spořitelna České spořitelny, a.s.",
            "8090" => "Česká exportní banka, a.s.",
            "8150" => "HSBC Bank plc - pobočka Praha",
            "8200" => "PRIVAT BANK AG der Raiffeisenlandesbank Oberösterreich Aktiengesellschaft, pobočka Česká republika",
            "8220" => "Payment Execution s.r.o.",
            "8230" => "EEPAYS s.r.o.",
            "8240" => "Družstevní záložna Kredit",
            "8250" => "Bank of China (Hungary) Close Ltd. Prague branch, odštěpný závod",
            "8265" => "Industrial and Commercial Bank of China Limited Prague Branch, odštěpný závod",
        ];
        
        // Kontrola formátu.
        if(!preg_match('/^(([0-9]{0,6})-)?([0-9]{2,10})\/([0-9]{4})$/', $bank_account, $parts)) {
            return FALSE;
        }
    
        // Kontrola prefixu 
        if ( !empty( $parts[2] ) ) { 

            // Doplnění na 6 číslic nulami zleva
            $prefix = str_pad( $parts[2], 6, "0", STR_PAD_LEFT );

            // Suma všech čísel pronásobených jejich váhami
            $sum = 0;
            for( $i = 0; $i < 6; $i++ ) {
                $sum += intval( $prefix[ $i ] ) * $prefix_weights[ $i ];
            }

            // Kontrola na dělitelnost 11
            if ( $sum % 11 != 0 ) {
                return FALSE;
            }

        }

        // Doplnění na 10 číslic nulami zleva
        $base = str_pad( $parts[3], 10, "0", STR_PAD_LEFT );

        // Suma všech číslic pronásobených jejich vahami
        $sum = 0;
        for( $i = 0; $i < 10; $i++ ) {
            $sum += intval( $base[ $i ] ) * $base_weights[ $i ];
        }

        // Kontrola na dělitelnost 11
        if ( $sum % 11 != 0 ) {
            return FALSE;
        }

        return TRUE;

        // Kontrola bankovního čísla
        /*$code = $parts[4];
        if ( empty( $banks[ $code ] ) ) {
            return false;
        }

        if ( $return_bank_name ) {
            return $banks[ $code ];
        } else {
            return true;
        }*/
    }   

}
