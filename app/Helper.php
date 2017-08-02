<?php

use GuzzleHttp\Psr7\Request as GuzzleRequest;
use App\User;

/**
* change plain number to formatted currency
*
* @param $number
* @param $currency
*/
function formatNumber($number, $currency = 'IDR')
{
   if($currency == 'Ksh') {
        return number_format($number, 2, '.', ',');
   }
   return number_format($number, 0, '.', '.');
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
	return number_format($num,$decimals, '.', ',');
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
		
	$user = User::where('id', $user_id)->first();
	//dd($user);
	$sms_user_name = $user->sms_user_name;

	//dd($sms_username);

	if ($sms_user_name) {
		
		//get bulk sms data for this client
		$get_sms_data_url_main = \Config::get('constants.bulk_sms.get_sms_data_url');
		$get_sms_data_url = $get_sms_data_url_main . "?usr=" . $sms_user_name;
		//dd($get_sms_data_url);

		//get sms data
	    $client = new \GuzzleHttp\Client();

	    $resp = $client->request('GET', $get_sms_data_url);

	    if ($resp->getBody()) {
		    
		    $result = json_decode($resp->getBody());
					
			// get results
			if  (!$result->error) {
				
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
				$response["sms_balance"] = $result->sms_balance;
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
    $send_bulk_sms_url = \Config::get('constants.bulk_sms.send_sms_url');

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