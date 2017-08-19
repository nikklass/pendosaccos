<?php

namespace App\Services\Withdrawal;

use App\Group;
use App\Withdrawal;
use App\User;
use Illuminate\Support\Facades\DB;

class WithdrawalUpdate 
{
	protected $errors = [];
	protected $valid = true;

	public function checkData($data, $id)
	{

        //get logged in user
        $auth_user = auth()->user();

        //get user data
        $user_id = $data->user_id;
        $user = User::findOrFail($user_id);

        if ((($auth_user->hasRole('administrator')) 
                && ($auth_user->group->id == $user->group->id))
                || ($auth_user->hasRole('superadministrator'))) {

                //get withdrawal
                $withdrawal = Withdrawal::findOrFail($id);
                $withdrawn_amount = (float)$withdrawal->amount;

                //get user account object
                $user = User::findOrFail($data->user_id);

                //get users current loan balance
                $account_balance = (float)$user->account_balance;
                //$before_balance = $account_balance;

                //current withdrawal amount
                $amount = (float)$data->amount;

                //check if repayment is more than loan balance
                if ($amount > ($account_balance + $withdrawn_amount)) {
                    
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

	public function updateItem($data, $id) {
			
        //get logged in user
		$auth_user = auth()->user();
        $user_id = $auth_user->id;
        $amount = $data->amount;
        $comment = $data->comment;

        //get old withdrawal data
        $old_withdrawal = Withdrawal::findOrFail($id);
        $old_amount = (float)$old_withdrawal->amount;
        $old_group_id = $old_withdrawal->group_id;
        $old_user_id = $old_withdrawal->user_id;

        DB::beginTransaction();
            
            $old_user = User::findOrFail($old_user_id);

            //update old user data
            $old_user->account_balance = ($old_user->account_balance - $old_amount) + $amount;
            $old_user->save();

            //update group data
            $old_group = Group::findOrFail($old_group_id);
            $old_group->account_balance = ($old_group->account_balance - $old_amount) + $amount;
            $old_group->save();

            //update withdrawal info
            $withdrawal = withdrawal::findOrFail($id);
                $withdrawal->amount = $data->amount;
                $withdrawal->comment = $data->comment;
                $withdrawal->before_balance = ($old_withdrawal->before_balance - $old_amount) + $amount;
                $withdrawal->after_balance = ($old_withdrawal->after_balance - $old_amount) + $amount;
                $withdrawal->src_host = getUserAgent();
                $withdrawal->src_ip = getIp();
                $withdrawal->updated_by = $user_id;

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