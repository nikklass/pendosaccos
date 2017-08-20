<?php

namespace App\Services\Mpesa;

use App\Group;
use App\Mpesac2b;
use App\User;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Support\Facades\DB;

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
        
        $client = new \GuzzleHttp\Client();

        $get_mpesa_token_url = config('constants.mpesa.get_mpesa_token_url');
        $c2b_simulate_trans_url = config('constants.mpesa.c2b_simulate_trans_url');
        $short_code = config('constants.mpesa.short_code');

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
                        'CommandID' => 'CustomerPayBillOnline',
                        'Amount' => $data->amount,
                        'Msisdn' => '254720743211',
                        'BillRefNumber' => 'payment-01'
                    ]
                ]);

                if ($response->getStatusCode() == 200) {
                    dump("ok here");
                    if ($response->getBody()) {
            
                        $result = json_decode($response->getBody());
                        dd($result);

                    }
                }  

            } catch (\Exception $e) {
                dump($e);
            }

        }
        dd("hereeee");

        //////////////////////////


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