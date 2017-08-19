<?php

namespace App\Services\Withdrawal;

use App\Group;
use App\Withdrawal;
use App\User;
use Illuminate\Support\Facades\DB;

class WithdrawalStore 
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

                //get user account object
                $user = User::where('id', $data->user_id)
                        ->first();

                //get users current loan balance
                $account_balance = (float)$user->account_balance;
                $before_balance = $account_balance;

                //current withdrawal amount
                $amount = (float)$data->amount;

                //check if repayment is more than loan balance
                if ($amount > $account_balance) {
                    
                    $message = config('constants.error.excess_withdrawal_amount');
                    $message = sprintf($message, formatCurrency($amount, 0), formatCurrency($account_balance, 0));
                    $this->errors = $message;

                    $this->valid = false;
                }

        } else {

            $message = config('constants.error.invalid_access');
            $this->errors = $message;
            $this->valid = false;

        }

		return $this->valid;

	}

	public function createItem($data) {
			
        //get logged in user
		$auth_user = auth()->user();
        $user_id = $auth_user->id;
        $amount = $data->amount;

        //get user group id and account balance
        $user = User::findOrFail($data->user_id);
        $group_id = $user->group_id;
        $before_balance = (float)$user->account_balance;

        if ($before_balance > 0) {
            $after_balance = $before_balance - $amount;
        } 

        DB::beginTransaction();
            
            //update user account balance
            $user->account_balance = $user->account_balance - $amount;
            $user->save();

            //update group account balance
            $group = Group::findOrFail($group_id);
            $group->account_balance = $group->account_balance - $amount;
            $group->save();

            $withdrawal = Withdrawal::create([
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

            $withdrawal->save();

        DB::commit();

        return $withdrawal;

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