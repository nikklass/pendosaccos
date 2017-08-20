<?php

use App\User;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
* change plain number to formatted currency
*
* @param $number
* @param $currency
*/
function formatCurrency($number, $decimals = 2, $currency = 'Ksh')
{
    return $currency . " " . number_format($number, $decimals, '.', ',');
}

//format phone number
function formatPhoneNumber($phone_number) {    
	return   "254". substr(trim($phone_number),-9); 
}

//check for valid phone number
function isValidPhoneNumber($phone_number) {
        		
	$phone_number_status = false; 
	
	$phone_number = trim($phone_number);
	
	if (strlen($phone_number) == 12) 
	{
		$pattern = "/^2547(\d{8})$/";
		if (preg_match($pattern, $phone_number)) {
			$phone_number_status = true;
		}
	}
	
	if (strlen($phone_number) == 13) 
	{
		$pattern = "/^\+2547(\d{8})$/";
		if (preg_match($pattern, $phone_number)) {
			$phone_number_status = true;
		}
	}
	
	if (strlen($phone_number) == 10) 
	{
		$pattern = "/^07(\d{8})$/";
		if (preg_match($pattern, $phone_number)) {
			$phone_number_status = true;
		}
	}

	if (strlen($phone_number) == 9) 
	{
		$pattern = "/^7(\d{8})$/";
		if (preg_match($pattern, $phone_number)) {
			$phone_number_status = true;
		}
	}

    return  $phone_number_status;
	
}

//validate an email address
function validateEmail($email) {

	return preg_match("/^(((([^]<>()[\.,;:@\" ]|(\\\[\\x00-\\x7F]))\\.?)+)|(\"((\\\[\\x00-\\x7F])|[^\\x0D\\x0A\"\\\])+\"))@((([[:alnum:]]([[:alnum:]]|-)*[[:alnum:]]))(\\.([[:alnum:]]([[:alnum:]]|-)*[[:alnum:]]))*|(#[[:digit:]]+)|(\\[([[:digit:]]{1,3}(\\.[[:digit:]]{1,3}){3})]))$/", $email);

}

//format date
function formatFriendlyDate($date) {
	return Carbon\Carbon::parse($date)->format('d-M-Y, H:i');
}

function downloadExcelFile($excel_name, $excel_title, $excel_desc, $data_array, $data_type) {

	Excel::create($excel_name, function($excel) use ($data_array) {

        // Set the spreadsheet title, creator, and description
        //$excel->setTitle($excel_title);
        $excel->setCreator(config('app.name'))->setCompany(config('app.name'));
        //$excel->setDescription($excel_desc);

        // Build the spreadsheet, passing in the payments array
        $excel->sheet('sheet1', function($sheet) use ($data_array) {
            $sheet->fromArray($data_array, null, 'A1', false, false);
            // Set auto size for sheet
			$sheet->setAutoSize(true);
        });

    })->download($data_type);

}

//shorten text title
function reducelength($str,$maxlength=100) {
	if (strlen($str) > $maxlength) {
		$newstr = substr($str,0,$maxlength-3) . "...";	
	} else {
		$newstr = $str;
	}
	return $newstr;
}

/// function to generate random number ///////////////
function generateCode($length = 5, $add_dashes = false, $available_sets = 'ud')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';
	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];
	$password = str_shuffle($password);
	if(!$add_dashes)
		return $password;
	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
} 
// end of generate random number function

//format number 
function format_num($num, $decimals=2) {
	return number_format($num, $decimals, '.', ',');
}

function getUserAgent(){
	return @$_SERVER["HTTP_USER_AGENT"]?$_SERVER["HTTP_USER_AGENT"]: "" ;
}

function getIp(){
	//Just get the headers if we can or else use the SERVER global
	if ( function_exists( 'apache_request_headers' ) ) {
		$headers = apache_request_headers();
	} else {
		$headers = $_SERVER;
	}
	//Get the forwarded IP if it exists
	if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
		$the_ip = $headers['X-Forwarded-For'];
	} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
	) {
		$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
	} else {
		
		$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
	}
	return $the_ip;
}

function getHost() {
	return @$_SERVER["REMOTE_HOST"]? $_SERVER["REMOTE_HOST"]: "" ; 
}

// fetching bulk sms data
function getBulkSMSData($user_id) {
	
	$sms_user_name = ENV('BULK_SMS_USR');
	$sms_user_name = 'yehu';

	if ($sms_user_name) {
		
		//get bulk sms data for this client
		$get_sms_data_url_main = config('constants.bulk_sms.get_sms_data_url');
		$get_sms_data_url = $get_sms_data_url_main . "?usr=" . $sms_user_name;
		//dd($get_sms_data_url);

		//get sms data
	    $client = new \GuzzleHttp\Client();

	    $resp = $client->request('GET', $get_sms_data_url);

	    if ($resp->getBody()) {
		    
		    $result = json_decode($resp->getBody());
		    //dd($result);
					
			// get results
			if  ($result->default_source) {
				
				$sms_balance = 0;
				if ($result->sms_balance) {
					$sms_balance = $result->sms_balance;
				}
				//show data
				$response["error"] = false;
				$response["sms_user_name"] = $sms_user_name;
				$response["passwd"] = $result->passwd;
				$response["alphanumeric_id"] = $result->alphanumeric_id;
				$response["fullname"] = $result->fullname;
				$response["rights"] = $result->rights;
				$response["active"] = $result->active;
				$response["default_sid"] = $result->default_sid;
				$response["default_source"] = $result->default_source;
				$response["paybill"] = $result->paybill;
				$response["relationship"] = $result->relationship;
				$response["home_ip"] = $result->home_ip;
				$response["default_priority"] = $result->default_priority;
				$response["default_dest"] = $result->default_dest;
				$response["default_msg"] = $result->default_msg;
				$response["sms_balance"] = $sms_balance;
				$response["sms_expiry"] = $result->sms_expiry;
				$response["routes"] = $result->routes;
				$response["last_updated"] = $result->last_updated;			
		        
		    } else {
				
				$response["error"] = true;
				$response["message"] = $result->message;
				
		    }

		} else {
				
			$response["error"] = true;
			$response["message"] = "An error occured fetching bulk sms data";
			
	    }

	} else {
				
		$response["error"] = true;
		$response["message"] = "No SMS account exists";
		
    }
	
	return $response; 
	
}

function sendSms($params) {
	
	//send sms
    $client = new \GuzzleHttp\Client();

    $body['usr'] = $params['usr'];
    $body['pass'] = $params['pass'];
    $body['src'] = $params['src'];
    $body['dest'] = $params['phone_number'];
    $body['msg'] = $params['sms_message'];

    //get the url for sending sms from constants file - \app\constants.php
    $send_bulk_sms_url = config('constants.bulk_sms.send_sms_url');

    $resp = $client->request('POST', $send_bulk_sms_url, ['form_params' => $body]);

    if ($resp->getBody()) {
	    
	    $result = json_decode($resp->getBody());
				
		// get results
		if  (!$result->error) {
			
			//show data
			$response["error"] = false;
			$response["message"] = $result->message;
			$response["mobile"] = $result->mobile;
	        
	    } else {
			
			$response["error"] = true;
			$response["message"] = $result->message;
			
	    }

	} else {
			
		$response["error"] = true;
		$response["message"] = "An error occured while sending sms";
		
    }

    return $response; 

}

//check if paybill is valid	
function isPaybillValid($est_id, $user_id=NULL, $admin=NULL) {
	
	$response = array();
	
	$results = array();

	if (!$user_id) { $user_id = USER_ID; }
	
	//check user permissions
	$super_admin = $this->isSuperAdmin($user_id);
	if ($admin && !$super_admin) {
		$perms = ALL_MPESA_TRANS_PERMISSIONS; 
		$company_ids = $this->getUserCompanyIds($user_id, $perms, $est_id); 
	}
	
	if ($super_admin || ($admin && $company_ids)) {
		
		//get bulk sms data
		$bulk_sms_data = $this->getBulkSMSData(BULK_SMS_USERNAME); 
		$usr = $est_id;
		$pass = $bulk_sms_data["passwd"];
		$src = $bulk_sms_data["default_source"];
		$paybill_no = $bulk_sms_data["paybill"];
					
		if ($usr && $pass && $paybill_no) {
		
			//show success msg
			$response["message"] = SUCCESS_MESSAGE;
			$response["error"] = false;
		
		} else {
			
			//get est name
			$est_data_items = $this->getEstablishments("", $est_id);
			$est_data_item = $est_data_items["rows"][0];
			$est_name = $est_data["name"];
			
			//show error msg
			$response["message"] = sprintf(NO_PAYBILL_NUMBER_ERROR_MESSAGE, $est_name);
			$response["error_type"] = NO_PERMISSION_ERROR;
			$response["error"] = true;
		
		}
		
	} else {
		
		//show error msg
		$response["message"] = NO_PERMISSION_ERROR_MESSAGE;
		$response["error_type"] = NO_PERMISSION_ERROR;
		$response["error"] = true;
		
	}
	
	return $response; 

}


//mpesa

function getMpesaTokenCredentials() {
	
	//read static mpesa data from env
    $mpesa_consumer_key = config('constants.mpesa.consumer_key');
    $mpesa_consumer_secret = config('constants.mpesa.consumer_secret');
    $get_mpesa_token_url = config('constants.mpesa.get_mpesa_token_url');

    $credentials = base64_encode("$mpesa_consumer_key:$mpesa_consumer_secret"); 

    return $credentials;

}

function byteStr2byteArray($s) {
    return array_slice(unpack("C*", "\0".$s), 1);
}

function getMpesaSecurityCredentials() 
{ 
  	
  	$mpesa_initiator_password = config('constants.mpesa.consumer_secret');
    //$password_byte_array = byteStr2byteArray($mpesa_initiator_password);

    //read cert
    $cert_path = Storage::disk('local')->get('cert/cert.cer');;
    //$ssl = openssl_x509_parse($cert_path);

    openssl_public_encrypt($mpesa_initiator_password, $encrypted, $cert_path, OPENSSL_PKCS1_PADDING);

  	return(base64_encode($encrypted)); 

} 

function getGuzzleClient($token)
{
    return new \GuzzleHttp\Client([
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ],
    ]);
}

function getTokenGuzzleClient()
{
    //get mpesa credentials
    $credentials = getMpesaTokenCredentials(); 
    return new \GuzzleHttp\Client([
        'headers' => [
            'Authorization' => 'Basic ' . $credentials,
            'Content-Type' => 'application/json'
        ],
    ]);
}

function createC2bTransactionRegisterUrl($validation_url, $confirmation_url) {
	
    $get_mpesa_token_url = config('constants.mpesa.get_mpesa_token_url');
    $c2b_register_url = config('constants.mpesa.c2b_register_url');
    $short_code = config('constants.mpesa.short_code');

    //get mpesa credentials
    $tokenclient = getTokenGuzzleClient();

    $resp = $tokenclient->request('GET', $get_mpesa_token_url);   

    if ($resp->getBody()) {
        
        $result = json_decode($resp->getBody());
        $access_token = $result->access_token;

        try {

            //send request to mpesa
            //ReponseType - how mpesa responds in case of timeout = cancelled/completed
            $dataclient = getGuzzleClient($access_token);
            $response = $dataclient->request('POST', $c2b_register_url, [
                'json' => [
                    'ShortCode' => $short_code,
                    'ResponseType' => 'Cancelled',
                    'ConfirmationURL' => $confirmation_url,
                    'ValidationURL' => $validation_url
                ]
            ]);

            if ($response->getStatusCode() == 200) {

                if ($response->getBody()) {
        
                    $result = json_decode($response->getBody());

                    return $result;
                    

                }

            }  

        } catch (\Exception $e) {
            dump($e);
        }

    }

}

function createMpesac2bSimulateTransaction($amount, $phone_number, $billRefNumber, $commandId='CustomerPayBillOnline') {
	
	//commandId Options 
	/*
		CustomerPayBillOnline
 		CustomerBuyGoodsOnline
	*/
	$client = new \GuzzleHttp\Client();

    $get_mpesa_token_url = config('constants.mpesa.get_mpesa_token_url');
    $c2b_simulate_trans_url = config('constants.mpesa.c2b_simulate_trans_url');
    $short_code = config('constants.mpesa.short_code');

    //format phone number
    $phone_number = formatPhoneNumber($phone_number);

    //get mpesa credentials
    $credentials = getMpesaTokenCredentials(); 

    $resp = $client->request('GET', $get_mpesa_token_url,
    [
        'headers' => [
            'Authorization' => 'Basic ' . $credentials,
            'Content-Type' => 'application/json'
        ],
    ]);   

    if ($resp->getBody()) {
        
        $result = json_decode($resp->getBody());
        $access_token = $result->access_token;

        try {

            //send request to mpesa
            $dataclient = getGuzzleClient($access_token);
            $response = $dataclient->request('POST', $c2b_simulate_trans_url, [
                'json' => [
                    'ShortCode' => $short_code,
                    'CommandID' => $commandId,
                    'Amount' => $amount,
                    'Msisdn' => $phone_number,
                    'BillRefNumber' => $billRefNumber
                ]
            ]);

            if ($response->getStatusCode() == 200) {

                if ($response->getBody()) {
        
                    $result = json_decode($response->getBody());

                    return $result;
                    

                }

            }  

        } catch (\Exception $e) {
            dump($e);
        }

    }

}

/*B2B Payment Request*/
function createMpesab2bPaymentRequest($username, $receiver_short_code, $amount, $remarks, $account_reference, $queue_timeout_url, $result_url, $command_id='BusinessPayBill') {
	
	//commandId Options 
	/*
		BusinessPayBill
		BusinessBuyGoods
		DisburseFundsToBusiness
		BusinessToBusinessTransfer
		BusinessTransferFromMMFToUtility
		BusinessTransferFromUtilityToMMF
		MerchantToMerchantTransfer
		MerchantTransferFromMerchantToWorking
		MerchantServicesMMFAccountTransfer
		AgencyFloatAdvance
	*/

	/*	
		SenderIdentifierType/ ReceiverIdentifierType

		1 – MSISDN

		2 – Till Number

		4 – Organization short code
	*/

    $get_mpesa_token_url = config('constants.mpesa.get_mpesa_token_url');
    $b2b_payment_request_url = config('constants.mpesa.b2b_payment_request_url');
    $short_code = config('constants.mpesa.short_code');

    //get mpesa credentials
    $tokenclient = getTokenGuzzleClient();

    $resp = $tokenclient->request('GET', $get_mpesa_token_url);   

    if ($resp->getBody()) {
        
        $result = json_decode($resp->getBody());
        $access_token = $result->access_token;
        $mpesa_security_credentials = getMpesaSecurityCredentials();

        try {

            //send request to mpesa
            $dataclient = getGuzzleClient($access_token);
            $response = $dataclient->request('POST', $b2b_payment_request_url, [
                'json' => [
                    'Initiator' => $username,
                    'CommandID' => $command_id,
                    'Amount' => $amount,
                    'SecurityCredential' => $mpesa_security_credentials,
                    'SenderIdentifierType' => 4,
                    'RecieverIdentifierType' => 4,
                    'PartyA' => $short_code,
                    'PartyB' => $receiver_short_code,
                    'AccountReference' => $account_reference,
                    'Remarks' => $remarks,
                    'QueueTimeOutURL' => $queue_timeout_url,
                    'ResultURL' => $result_url
                ]
            ]);

            if ($response->getStatusCode() == 200) {

                if ($response->getBody()) {
        
                    $result = json_decode($response->getBody());

                    return $result;
                    

                }

            }  

        } catch (\Exception $e) {
            dump($e);
        }

    }

}


/*B2C Payment Request*/
function createMpesab2cPaymentRequest($username, $receiver_short_code, $amount, $remarks, $occassion, $queue_timeout_url, $result_url, $command_id='BusinessPayment') {
	
	//commandId Options 
	/*
		SalaryPayment
		BusinessPayment
		PromotionPayment
	*/

    $get_mpesa_token_url = config('constants.mpesa.get_mpesa_token_url');
    $b2c_payment_request_url = config('constants.mpesa.b2c_payment_request_url');
    $short_code = config('constants.mpesa.short_code');

    //get mpesa credentials
    $tokenclient = getTokenGuzzleClient();

    $resp = $tokenclient->request('GET', $get_mpesa_token_url);  

    if ($resp->getBody()) {
        
        $result = json_decode($resp->getBody());
        $access_token = $result->access_token;
        $mpesa_security_credentials = getMpesaSecurityCredentials();
        //dd($access_token);

        try {

            //send request to mpesa
            $dataclient = getGuzzleClient($access_token);
            $response = $dataclient->request('POST', $b2c_payment_request_url, [
                'json' => [
                    'InitiatorName' => $username,
                    'CommandID' => $command_id,
                    'Amount' => $amount,
                    'SecurityCredential' => $mpesa_security_credentials,
                    'PartyA' => $short_code,
                    'PartyB' => $receiver_short_code,
                    'Remarks' => $remarks,
                    'QueueTimeOutURL' => $queue_timeout_url,
                    'ResultURL' => $result_url,
                    'Occassion' => $occassion
                ]
            ]);

            if ($response->getStatusCode() == 200) {

                if ($response->getBody()) {
        
                    $result = json_decode($response->getBody());

                    return $result;

                }

            }  

        } catch (\Exception $e) {
            dump($e);
        }

    }

}


/*Get Mpesa Account Balance*/
function getMpesaAccountBalance($username, $receiver_short_code, $remarks, $queue_timeout_url, $result_url,  $receiver_identifier='4') {

    $get_mpesa_token_url = config('constants.mpesa.get_mpesa_token_url');
    $account_balance_url = config('constants.mpesa.account_balance_url');
    $short_code = config('constants.mpesa.short_code');

    //get mpesa credentials
    $tokenclient = getTokenGuzzleClient();

    $resp = $tokenclient->request('GET', $get_mpesa_token_url);  

    if ($resp->getBody()) {
        
        $result = json_decode($resp->getBody());
        $access_token = $result->access_token;
        $mpesa_security_credentials = getMpesaSecurityCredentials();

        try {

            //send request to mpesa
            $dataclient = getGuzzleClient($access_token);
            $response = $dataclient->request('POST', $account_balance_url, [
                'json' => [
                    'Initiator' => $username,
                    'CommandID' => 'AccountBalance',
                    'SecurityCredential' => $mpesa_security_credentials,
                    'IdentifierType' => $receiver_identifier,
                    'PartyA' => $short_code,
                    'Remarks' => $remarks,
                    'QueueTimeOutURL' => $queue_timeout_url,
                    'ResultURL' => $result_url
                ]
            ]);

            if ($response->getStatusCode() == 200) {

                if ($response->getBody()) {
        
                    $result = json_decode($response->getBody());

                    return $result;

                }

            }  

        } catch (\Exception $e) {
            dump($e);
        }

    }

}

/*Create Lipa na mpesa Online Payment*/
function createLipaMpesaOnlinePayment($amount, $phone_number, $callback_url, $account_reference, $transaction_desc) {

    $get_mpesa_token_url = config('constants.mpesa.get_mpesa_token_url');
    $lipa_mpesa_online_payment_url = config('constants.mpesa.lipa_mpesa_online_payment_url');
    $short_code = config('constants.mpesa.short_code');
    $business_short_code = config('constants.mpesa.short_code');
    $lipa_mpesa_password = config('constants.mpesa.lipa_mpesa_password');

    //get mpesa credentials
    $tokenclient = getTokenGuzzleClient();

    $resp = $tokenclient->request('GET', $get_mpesa_token_url);  

    if ($resp->getBody()) {
        
        $result = json_decode($resp->getBody());
        $access_token = $result->access_token;
        $time = date('YmdHis');
        $password = base64_encode("$business_short_code:$lipa_mpesa_password:$time");

        try {

            //send request to mpesa
            $dataclient = getGuzzleClient($access_token);
            $response = $dataclient->request('POST', $lipa_mpesa_online_payment_url, [
                'json' => [
                    'BusinessShortCode' => $business_short_code,
                    'Password' => $password,
                    'Timestamp' => $time,
                    'TransactionType' => 'CustomerPayBillOnline',
                    'Amount' => $amount,
                    'PartyA' => $short_code,
                    'PartyB' => $short_code,
                    'PhoneNumber' => $phone_number,
                    'CallBackURL' => $callback_url,
                    'AccountReference' => $account_reference,
                    'TransactionDesc' => $transaction_desc
                ]
            ]);

            if ($response->getStatusCode() == 200) {

                if ($response->getBody()) {
        
                    $result = json_decode($response->getBody());

                    return $result;

                }

            }  

        } catch (\Exception $e) {
            dump($e);
        }

    }

}