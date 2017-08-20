<?php

namespace App\Services\Mpesa;

use App\Group;
use App\Mpesac2b;
use App\User;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Mpesac2bStore 
{
	protected $errors = [];
	protected $valid = true;

	public function checkData($data)
	{

        //get logged in user
        $auth_user = auth()->user();

        //get user data
        $user_id = $data->user_id;
        $user = User::findOrFail($user_id);

        if ((($auth_user->hasRole('administrator')) 
                && ($auth_user->group->id == $user->group->id))
                || ($auth_user->hasRole('superadministrator'))) {

                //do sth

        } else {

            $message = config('constants.error.invalid_access');
            $this->errors = $message;
            $this->valid = false;

        }

		return $this->valid;

	}

	public function createItem($data) {
        
        $amount = "500";
        $phone_number = "0720743211";
        $billRefNumber = "0012";

        $validation_url = "https://rczhkxfxge.localtunnel.me";
        $confirmation_url = "https://rczhkxfxge.localtunnel.me";

        //register c2b trans url
        //lt --port 8310
        $c2bregister = createC2bTransactionRegisterUrl($validation_url, $confirmation_url);

        //simulate c2b mpesa trans
        $c2b_mpesa_trans = createMpesac2bSimulateTransaction($amount, $phone_number, $billRefNumber);

        //create b2b payment request
        $queue_timeout_url = "https://rczhkxfxge.localtunnel.me";
        $result_url = "https://rczhkxfxge.localtunnel.me";
        $command_id='BusinessPayBill';
        $username = "nikk";
        $receiver_short_code = "456345";
        $amount = "300";
        $remarks = "product test";
        $account_reference = "3432";

        $b2b_payment_request = createMpesab2bPaymentRequest($username, $receiver_short_code, $amount, $remarks, $account_reference, $queue_timeout_url, $result_url, $command_id);


        //create b2c payment request
        $queue_timeout_url = "https://rczhkxfxge.localtunnel.me";
        $result_url = "https://rczhkxfxge.localtunnel.me";
        $command_id='BusinessPayment';
        $username = "nikk";
        $receiver_short_code = "254720743211";
        $amount = "300";
        $remarks = "product";
        $occassion = "return_data";

        $b2c_payment_request = createMpesab2cPaymentRequest($username, $receiver_short_code, $amount, $remarks, $occassion, $queue_timeout_url, $result_url, $command_id);


        //get mpesa account balance
        $queue_timeout_url = "https://rczhkxfxge.localtunnel.me";
        $result_url = "https://rczhkxfxge.localtunnel.me";
        $username = "nikk";
        $receiver_short_code = "254720743211";
        $remarks = "product";

        $mpesa_account_balance = getMpesaAccountBalance($username, $receiver_short_code, $remarks, $queue_timeout_url, $result_url);


        //create lipa na mpesa online payment
        $amount = "200";
        $phone_number = "254720743211";
        $callback_url = "https://rczhkxfxge.localtunnel.me";
        $account_reference = "product";
        $transaction_desc = "product";

        //$lipa_mpesa_online_payment = createLipaMpesaOnlinePayment($amount, $phone_number, $callback_url, $account_reference, $transaction_desc);

        //dd($c2bregister, $c2b_mpesa_trans, $b2b_payment_request, $b2c_payment_request, 
        //    $mpesa_account_balance, $lipa_mpesa_online_payment);

        dd($c2bregister, $c2b_mpesa_trans, $b2b_payment_request, $b2c_payment_request, 
            $mpesa_account_balance);

        //////////////////////////

        {
            "ConversationID": "AG_20170820_0000780b4867bed330a9",
            "OriginatorConversationID": "32515-56378-1",
            "ResponseCode": "0",
            "ResponseDescription": "The service request has been accepted successfully."
        }


        DB::beginTransaction();
            
            //update user account balance
            $user->account_balance = $user->account_balance + $amount;
            $user->save();

            //update group account balance
            $group = Group::findOrFail($group_id);
            $group->account_balance = $group->account_balance + $amount;
            $group->save();

            $deposit = Deposit::create([
                    'user_id' => $user->id,
                    'group_id' => $user->group_id,
                    'amount' => $amount,
                    'before_balance' => $before_balance,
                    'after_balance' => $after_balance,
                    'comment' => $data->comment,
                    'updated_by' => $user_id,
                    'created_by' => $user_id,
                    'src_host' => getUserAgent(),
                    'src_ip' => getIp()
            ]);

            $deposit->save();

        DB::commit();

        return $deposit;

	}

	/*get errors*/
	public function getErrors()
	{

		if (count($this->errors)) {
			return $this->errors;
		} else {
			return [];
		}

	}

}