<?php

namespace App\Http\Controllers;

use SoapClient;
use App\Http\Requests\Request;

class SoapController extends Controller
{
    public function __construct()
    {
        $params = array(
            'location'=> 'https://10.54.19.242:30002/payment/services/SYNCAPIRequestMgrService',
            'uri' => 'https://10.54.19.242:30002/payment/services/SYNCAPIRequestMgrService',
            'trace' => 1
        );

        //$this->instance = new SoapClient(NULL, $params);
    }

    public function sendXmlOverPost($url, $xml) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);

	// For xml, change the content-type.
	curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

	// Send to remote and return data to caller.
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
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

            // $client = new SoapClient(
            //     null,
            //     array(
            //         'location' => 'https://10.54.19.242:30002/payment/services/SYNCAPIRequestMgrService',
            //         'uri' => 'https://10.54.19.242:30002/payment/services/SYNCAPIRequestMgrService',
            //         'trace' => 1,
            //         'use' => SOAP_LITERAL,
            //     )
            // );
            // $params = new \SoapVar("<Acquirer><Id>MyId</Id><UserId>MyUserId</UserId><Password>MyPassword</Password></Acquirer>", XSD_ANYXML);
            // $result = $client->Echo($params);

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

        $parameter['uri'] = $target;
        $parameter['location'] = $target;
        $param['PayerReferenceNumber'] = '123456789';
        $param['AgreedTC'] = 1;
        $param['PayeeAccountName'] = 'PayeeAccount';
        $param['PayeeAccountName'] = 'PayeeAccount';
        $param['FirstPaymentDate'] = '20171010';
        $param['Frequency'] = '06';
        $param['StartRangeOfDays'] = 1;
        $param['EndRangeOfDays'] = 22;
        $param['ExpiryDate'] = 20181010;

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

	$result = $this->xmlsend($target, $wdsl);


	dd($result);

	

    }
}
