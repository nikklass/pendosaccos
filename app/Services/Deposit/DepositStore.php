<?php

namespace App\Services\Deposit;

use App\Group;
use App\Deposit;
use App\User;
use Illuminate\Support\Facades\DB;

class DepositStore 
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
			
        //get logged in user
		$auth_user = auth()->user();
        $user_id = $auth_user->id;
        $amount = $data->amount;

        //get user group id and account balance
        $user = User::findOrFail($user_id);
        $group_id = $user->group_id;
        $before_balance = (float)$user->account_balance;

        if ($before_balance > 0) {
            $after_balance = $before_balance + $amount;
        } else {
            $after_balance = $amount;
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