<?php
namespace App\Controllers\Test;
use App\Controllers\BaseController;
use CodeIgniter\Controller;

class SaveXml extends Controller
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
        $xmlFilePath = '../test_files/sba_xml.xml';
        $xmlString = file_get_contents($xmlFilePath);
        $xml = simplexml_load_string($xmlString);
        $xml->registerXPathNamespace('ns', 'urn:iso:std:iso:20022:tech:xsd:camt.053.001.02');
        $statement = [];
        $xml = $xml->xpath('//ns:BkToCstmrStmt')[0];

        $headerXml = $xml->GrpHdr;
        $recipientXml = $headerXml->MsgRcpt;
        $postalAddressXml = $recipientXml->PstlAdr;
        $paginationXml = $headerXml->MsgPgntn;
        
        $statement['header'] = [
            'messageId' => (string)$headerXml->MsgId,
            'creationDateTime' => (string)$headerXml->CreDtTm,
            'recipient' => [
                'id' => (string)$recipientXml->Id->OrgId->Othr->Id,
                'recipientName' => (string)$recipientXml->Nm,
                'recipientAddress' => [
                    'street' => (string)$postalAddressXml->StrtNm,
                    'postalCode' => (string)$postalAddressXml->PstCd,
                    'town' => (string)$postalAddressXml->TwnNm,
                    'country' => (string)$postalAddressXml->Ctry,
                ],
            ],
            'pagination' => [
                'pageNumber' => (string)$paginationXml->PgNb,
                'lastPage'   => (string)$paginationXml->LastPgInd,
            ],
            'additionalInformation' => (string)$headerXml->AddtlInf
        ];

        $statementDataXml =  $xml->Stmt;
        $statement['data'] = [
            'id' => (string)$statementDataXml->Id,
            'ElctrncSeqNb' => (int)$statementDataXml->ElctrncSeqNb,
            'LglSeqNb' => (int)$statementDataXml->LglSeqNb
        ];

        $fromToDateXml = $statementDataXml->FrToDt;
        $statement['data']['fromToDate'] = [
            'from' => (string)$fromToDateXml->FrDtTm,
            'to' => (string)$fromToDateXml->ToDtTm
        ];

        $accountXml = $statementDataXml->Acct;
        $ownerXml = $accountXml->Ownr;
        $serviceProviderXml = $accountXml->Svcr->FinInstnId;

        $statement['data']['account'] = [
            'iban' => (string)$accountXml->Id->IBAN,
            'currency' => (string)$accountXml->Ccy,
            'name' => (string)$accountXml->Nm,
            'owner' => [
                'id' => (string)$ownerXml->Id->OrgId->Othr->Id,
                'name' => (string)$ownerXml->Nm,
                'address' => [
                    'street' => (string)$accountXml->Ownr->PstlAdr->StrtNm,
                    'postalCode' => (string)$accountXml->Ownr->PstlAdr->PstCd,
                    'town' => (string)$accountXml->Ownr->PstlAdr->TwnNm,
                    'country' => (string)$accountXml->Ownr->PstlAdr->Ctry,
                ]
            ],
            'serviceProvider' => [
                'bic' => (string)$serviceProviderXml->BIC,
                'name' => (string)$serviceProviderXml->Nm,
                'address' => [
                    'street' => (string)$serviceProviderXml->PstlAdr->StrtNm,
                    'town' => (string)$serviceProviderXml->PstlAdr->TwnNm,
                    'country' => (string)$serviceProviderXml->PstlAdr->Ctry,
                ],
                'other' => [
                    'id' => (string)$serviceProviderXml->Othr->Id,
                    'scheme' => (string)$serviceProviderXml->Othr->SchmeNm->Prtry,
                    'issr' => (string)$serviceProviderXml->Othr->Issr,
                ]
            ]
        ];

        $statement['data']['interestRate'] = [
            'percent' => (string)$statementDataXml->Intrst->Rate->Tp->Pctg,
        ];

        $balances = [];
        $balancesXml = $statementDataXml->Bal;
        foreach ($balancesXml as $balanceXml) {
            $balance = [
                'amount' => (float)$balanceXml->Amt,
                'type' => (string)$balanceXml->Tp->CdOrPrtry->Cd,
                'currency' => (string)$balanceXml->Amt['Ccy'],
                'creditDebitIndicator' => (string)$balanceXml->CdtDbtInd,
                'date' => (string)$balanceXml->Dt->Dt,
            ];
            $balances[] = $balance;
        }
        $statement['data']['balances'] = $balances;

        $transactionSummaryTotalXml = $statementDataXml->TxsSummry->TtlNtries;
        $transactionSummaryTotalCreditXml = $statementDataXml->TxsSummry->TtlCdtNtries;
        $transactionSummaryTotalDebitXml = $statementDataXml->TxsSummry->TtlDbtNtries;

        $transactionSummary = [
            'type' => (string)$transactionSummaryTotalXml->CdtDbtInd,
            'totalNetEntryAmount' => (float)$transactionSummaryTotalXml->TtlNetNtryAmt,
            'total' => [
                'entries' => (int)$transactionSummaryTotalXml->NbOfNtries,
                'sum' => (float)$transactionSummaryTotalXml->Sum,
            ],
            'totalCredit' => [
                'entries' => (int)$transactionSummaryTotalCreditXml->NbOfNtries,
                'sum' => (float)$transactionSummaryTotalCreditXml->Sum,
            ],
            'totalDebit' => [
                'entries' => (int)$transactionSummaryTotalDebitXml->NbOfNtries,
                'sum' => (float)$transactionSummaryTotalDebitXml->Sum,
            ],
        ];
        $statement['data']['transactionSummary'] = $transactionSummary;

        $transactions = [];
        $transactionsXml = $statementDataXml->Ntry;
        foreach ($transactionsXml as $transactionXml) {
            $transaction = [
                'entryReference' => (string)$transactionXml->NtryRef,
                'amount' => (float)$transactionXml->Amt,
                'currency' => (string)$transactionXml->Amt['Ccy'],
                'creditDebitIndicator' => (string)$transactionXml->CdtDbtInd,
                'storned' => (string)$transactionXml->RvslInd,
                'status' => (string)$transactionXml->Sts,
                'bookingDate' => (string)$transactionXml->BookgDt->Dt,
                'valueDate' => (string)$transactionXml->ValDt->Dt,
            ];
            if (isset($transactionXml->NtryDtls->TxDtls->Refs->MsgId)) {
                $transaction['messageId'] = (string)$transactionXml->NtryDtls->TxDtls->Refs->MsgId;
            }
            if (isset($transactionXml->NtryDtls->TxDtls->Refs->EndToEndId)) {
                $transaction['endToEndId'] = (string)$transactionXml->NtryDtls->TxDtls->Refs->EndToEndId;
            }
            if (isset($transactionXml->NtryDtls->TxDtls->BkTxCd->Prtry->Cd)) {
                $transaction['bankTransactionCode'] = (string)$transactionXml->NtryDtls->TxDtls->BkTxCd->Prtry->Cd;
            }
            if (isset($transactionXml->NtryDtls->TxDtls->BkTxCd->Prtry->Issr)) {
                $transaction['bankTransactionIssuer'] = (string)$transactionXml->NtryDtls->TxDtls->BkTxCd->Prtry->Issr;
            }
            if (isset($transactionXml->NtryDtls->TxDtls->RltdPties->CdtrAcct->Id->IBAN)) {
                $transaction['creditorAccountIBAN'] = (string)$transactionXml->NtryDtls->TxDtls->RltdPties->CdtrAcct->Id->IBAN;
            }
            if (isset($transactionXml->NtryDtls->TxDtls->RltdPties->CdtrAcct->Id->Othr->Id)) {
                $transaction['creditorAccountId'] = (string)$transactionXml->NtryDtls->TxDtls->RltdPties->CdtrAcct->Id->Othr->Id;
            }
            if (isset($transactionXml->NtryDtls->TxDtls->RltdAgts->CdtrAgt->FinInstnId->BIC)) {
                $transaction['creditorAgentBIC'] = (string)$transactionXml->NtryDtls->TxDtls->RltdAgts->CdtrAgt->FinInstnId->BIC;
            }
            if (isset($transactionXml->NtryDtls->TxDtls->RltdAgts->CdtrAgt->FinInstnId->Othr->Id)) {
                $transaction['creditorAgentId'] = (string)$transactionXml->NtryDtls->TxDtls->RltdAgts->CdtrAgt->FinInstnId->Othr->Id;
            }
            if (isset($transactionXml->NtryDtls->TxDtls->RmtInf->Ustrd)) {
                $transaction['remittanceInformation'] = (string)$transactionXml->NtryDtls->TxDtls->RmtInf->Ustrd;
            }
            if (isset($transactionXml->NtryDtls->TxDtls->AddtlTxInf)) {
                $transaction['AdditionalTextInfo'] = (string)$transactionXml->NtryDtls->TxDtls->AddtlTxInf;
            }
        
            $transactions[] = $transaction;
        }
        $statement['data']['transactions'] = $transactions;

        print_r($statement);

    }
}
