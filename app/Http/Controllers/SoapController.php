<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoapController extends Controller
{
    public function __construct()
    {
        $params = array(
            'location'=> 'https://10.54.19.242:30002/payment/services/SYNCAPIRequestMgrService',
            'uri' => 'https://10.54.19.242:30002/payment/services/SYNCAPIRequestMgrService',
            'trace' => 1
        );

        $this->instance = new SoapClient(NULL, $params);
    }

    public function directDebit()
    {
        if(!isset($_GET['trxId'])){
            return back()
            ->with(['alert'=> "'title':'Gagal Menyimpan','text':'No Transaksi tidak ada, periksa kembali data inputan', 'icon':'error'"]);
        }else{
            $trx = $_GET['trxId'];
            $tagihan = Tagihan::where('trxId',$trx)->first();
            $request = 
            '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://cps.huawei.com/synccpsinterface/api_requestmgr" xmlns:req="http://cps.huawei.com/synccpsinterface/request" xmlns:com="http://cps.huawei.com/synccpsinterface/common" xmlns:cus="http://cps.huawei.com/cpsinterface/customizedrequest">
            <soapenv:Header/>
            <soapenv:Body>
            <api:Request>
            <req:Header>
            <req:Version>1.0</req:Version>
            <req:CommandID>CreateDirectDebitMandateByPayer</req:CommandID>
            <req:OriginatorConversationID>S_X2013012921001</req:OriginatorConversationID>
            <req:ConversationID>AG_20130129T102103</req:ConversationID>
            <req:Caller>
            <req:CallerType>2</req:CallerType>
            <req:ThirdPartyID>POS_Broker</req:ThirdPartyID>
            <req:Password>B1YNY8GylVo=</req:Password>
            </req:Caller>
            <req:KeyOwner>1</req:KeyOwner>
            <req:Timestamp>20171010152345</req:Timestamp>
            </req:Header>
            <req:Body>
            <req:Identity>
            <req:Initiator>
            <req:IdentifierType>1</req:IdentifierType>
            <req:Identifier>628128080819</req:Identifier>
            </req:Initiator>
            <req:ReceiverParty>
            <req:IdentifierType>1</req:IdentifierType>
            <req:Identifier>628128080819</req:Identifier>
             
            </req:ReceiverParty>
            </req:Identity>
            <req:CreateDirectDebitMandateByPayerRequest>
            <req:Payee>
            <com:IdentifierType>4</com:IdentifierType>
            <com:IdentifierValue>GOOGLE</com:IdentifierValue>
            </req:Payee>
            <req:DirectDebitMandateInfo>
            <com:PayerReferenceNumber>123456789</com:PayerReferenceNumber>
            <com:AgreedTC>1</com:AgreedTC>
            <com:PayeeAccountName>PayeeAccount</com:PayeeAccountName>
            <com:PayerAccountName>PayerAccount</com:PayerAccountName>
            <com:FirstPaymentDate>20171010</com:FirstPaymentDate>
            <com:Frequency>06</com:Frequency>
            <com:StartRangeOfDays>1</com:StartRangeOfDays>
            <com:EndRangeOfDays>22</com:EndRangeOfDays>
            <com:ExpiryDate>20181010</com:ExpiryDate>
            </req:DirectDebitMandateInfo>
            </req:CreateDirectDebitMandateByPayerRequest>
            </req:Body>
            </api:Request>
            </soapenv:Body>
            </soapenv:Envelope>
            ';

        }
    }
}
