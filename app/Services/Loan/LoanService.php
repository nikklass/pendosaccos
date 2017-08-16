<?php

namespace App\Services\Loan;

use App\Group;
use App\Loan;
use App\User;
use Illuminate\Support\Facades\DB;

class LoanService 
{
	protected $errors = [];
	protected $valid = true;

	public function checkData($data)
	{
		
        //get logged in user
        $auth_user = auth()->user();
        $user_id = $auth_user->id;

        //get loan user data
        $loan_user = User::findOrFail($data->user_id);

        if ((($auth_user->hasRole('administrator')) 
                && ($auth_user->group->id == $loan_user->group->id))
                || ($auth_user->hasRole('superadministrator'))) {

            //get groups account balance
            if ($auth_user->hasRole('administrator')) {
                $account_balance = (float)$auth_user->group->account_balance;
                $group_name = $auth_user->group->name;
            } else {
                $account_balance = (float)$loan_user->group->account_balance;
                $group_name = $loan_user->group->name;
            }
            //amount to be disbursed
            $amount = (float)$data->amount;

            //check if loan is more than groups account balance 
            if ($amount > $account_balance) {
                $message = config('constants.error.excess_loan');
                $message = sprintf($message, format_num($amount, 0), $group_name, format_num($account_balance, 0));
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


	public function createLoan($data) {
			
		//get logged in user
		$auth_user = auth()->user();
        $user_id = $auth_user->id;

        //get loan user data
        $user = User::findOrFail($data->user_id);

		//if user is admin, and users and created user groups are same, proceed
        if ((($auth_user->hasRole('administrator')) 
                && ($auth_user->group->id == $user->group->id))
                || ($auth_user->hasRole('superadministrator'))) {
            
            //get groups current balance
            $account_balance = (float)$auth_user->group->account_balance;
            if ($auth_user->hasRole('administrator')) {
                $account_balance = (float)$auth_user->group->account_balance;
                $group_id = $auth_user->group->id;
            } else {
                $account_balance = (float)$user->group->account_balance;
                $group_id = $user->group->id;
            }
            //amount withdrawn
            $amount = (float)$data->amount;


            DB::beginTransaction();

                //update the group loan balance - reduce by amount
                $group = Group::findOrFail($group_id);
                $group->account_balance = $group->account_balance - $amount;
                $group->save();

                //calculate loan payment expiry date
                /*$end_at_date = Carbon::parse($end_at);

                echo $start_at_date->addMonths(3);
                dd('hello');*/

                //dd($groupLoan);

                $loan = Loan::create([
                        'user_id' => $user->id,
                        'group_id' => $group_id,
                        'loan_type_id' => $data->loan_type_id,
                        'interest' => $data->interest,
                        'period' => $data->period,
                        'loan_amount' => $amount,
                        'loan_balance' => $amount,
                        'comment' => $data->comment,
                        'updated_by' => $user_id,
                        'created_by' => $user_id,
                        'src_host' => getUserAgent(),
                        'src_ip' => getIp()
                ]);

                $loan->save();

            DB::commit();

            return $loan;

        }

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
