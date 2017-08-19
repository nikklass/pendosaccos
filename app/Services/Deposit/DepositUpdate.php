<?php

namespace App\Services\Deposit;

use App\Group;
use App\Deposit;
use App\User;
use Illuminate\Support\Facades\DB;

class DepositUpdate 
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

	public function updateItem($data, $id) {
			
        //get logged in user
		$auth_user = auth()->user();
        $user_id = $auth_user->id;
        $amount = $data->amount;
        $comment = $data->comment;

        //get old deposit data
        $old_deposit = Deposit::findOrFail($id);
        $old_amount = (float)$old_deposit->amount;
        $old_group_id = $old_deposit->group_id;
        $old_user_id = $old_deposit->user_id;

        DB::beginTransaction();
            
            $old_user = User::findOrFail($old_user_id);

            //update old user data
            $old_user->account_balance = ($old_user->account_balance - $old_amount) + $amount;
            $old_user->save();

            //update group data
            $old_group = Group::findOrFail($old_group_id);
            $old_group->account_balance = ($old_group->account_balance - $old_amount) + $amount;
            $old_group->save();

            //update deposit info
            $deposit = Deposit::findOrFail($id);
                $deposit->amount = $data->amount;
                $deposit->comment = $data->comment;
                $deposit->before_balance = ($old_deposit->before_balance - $old_amount) + $amount;
                $deposit->after_balance = ($old_deposit->after_balance - $old_amount) + $amount;
                $deposit->src_host = getUserAgent();
                $deposit->src_ip = getIp();
                $deposit->updated_by = $user_id;

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