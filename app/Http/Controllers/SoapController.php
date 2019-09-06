<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;

class SoapController extends Controller
{
    public function __construct(){
    }

    public function xmlsend($url, $xml){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_SSL_VERIFYPEER=> false,
        CURLOPT_POSTFIELDS => $xml,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: text/xml",
            "postman-token: e992afcc-8510-6636-7a5d-b15a8427628e"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
    public function send($target, $parameter = NULL, $method = 'POST')
    {
        $content = array('http' =>
                            array(
                                'method'  => $method,
                                'header'=> "Content-type: application/x-www-form-urlencoded\r\n",
                                'content' => http_build_query($parameter),
 				'ssl' => [
        				"verify_peer"=>false,
        				"verify_peer_name"=>false,
    				]

                            )
                        );
        $var = stream_context_create($content);
        // dd($var);
        $result = file_get_contents($target, false, $var);
        return json_decode($result, TRUE);
    }

    public function enabled()
    {
	$target = 'https://10.54.19.242:30002/payment/services/SYNCAPIRequestMgrService';

        $PayerReferenceNumber= '123456789';
        $AgreedTC= 1;
        $PayeeAccountName= 'PayeeAccount';
        $FirstPaymentDate = '20171010';
        $Frequency ='06';
        $StartRangeOfDays= 1;
        $EndRangeOfDays = 22;
        $ExpiryDate = 20181010;

        $CallerType = '2';
        $ThirdPartyID = 'twallet';
        $Password = 'hUms+aPOadIvjhrjGM5tPg==';
        $KeyOwner = 'KeyOwner';
        $Timestamp = '20180410152345';

        $wdsl = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://cps.huawei.com/synccpsinterface/api_requestmgr" xmlns:req="http://cps.huawei.com/synccpsinterface/request" xmlns:com="http://cps.huawei.com/synccpsinterface/common" xmlns:cus="http://cps.huawei.com/cpsinterface/customizedrequest">
        <soapenv:Header/>
        <soapenv:Body>
        <api:Request>
        <req:Header>
        <req:Version>1.0</req:Version>
        <req:CommandID>CreateDirectDebitMandateByPayer</req:CommandID>
        <req:OriginatorConversationID>S_X2013012921001</req:OriginatorConversationID>
        <req:ConversationID>AG_20130129T102103</req:ConversationID>
        <req:Caller>
        <req:CallerType>'.$CallerType.'</req:CallerType>
        <req:ThirdPartyID>'.$ThirdPartyID.'</req:ThirdPartyID>
        <req:Password>'.$Password.'</req:Password>
        </req:Caller>
        <req:KeyOwner>'.$KeyOwner.'</req:KeyOwner>
        <req:Timestamp>'.$Timestamp.'</req:Timestamp>
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
        <com:PayerReferenceNumber>'.$PayerReferenceNumber.'</com:PayerReferenceNumber>
        <com:AgreedTC>'.$AgreedTC.'</com:AgreedTC>
        <com:PayeeAccountName>'.$PayeeAccountName.'</com:PayeeAccountName>
        <com:PayerAccountName>'.$PayeeAccountName.'</com:PayerAccountName>
        <com:FirstPaymentDate>'.$FirstPaymentDate.'</com:FirstPaymentDate>
        <com:Frequency>'.$Frequency.'</com:Frequency>
        <com:StartRangeOfDays>'.$StartRangeOfDays.'</com:StartRangeOfDays>
        <com:EndRangeOfDays>'.$EndRangeOfDays.'</com:EndRangeOfDays>
        <com:ExpiryDate>'.$ExpiryDate.'</com:ExpiryDate>
        </req:DirectDebitMandateInfo>
        </req:CreateDirectDebitMandateByPayerRequest>
        </req:Body>
        </api:Request>
        </soapenv:Body>
        </soapenv:Envelope>
        ';

	$result = $this->xmlsend($target, $wdsl);

	dd($result);

    }
}
