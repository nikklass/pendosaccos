<?php

namespace App\Services\Repayment;

use App\Group;
use App\Loan;
use App\Repayment;
use App\User;
use Illuminate\Support\Facades\DB;

class RepaymentService 
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

                //get loan object
                $loan = Loan::where('id', $data->loan_id)
                        ->first();

                //get users current loan balance
                $loan_balance = (float)$loan->loan_balance;
                $before_balance = $loan_balance;
                
                //get paid amount
                $paid_amount = (float)$loan->paid_amount;
                //current repayment amount
                $amount = (float)$data->amount;

                //check if repayment is more than loan balance
                if ($amount > $loan_balance) {
                    
                    $message = config('constants.error.excess_loan_repayment');
                    $message = sprintf($message, format_num($amount, 0), format_num($loan_balance, 0));
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

	public function createRepayment($data) {
			
		//get logged in user
		$auth_user = auth()->user();
        $user_id = $auth_user->id;

		//get loan object
        $loan = Loan::where('id', $data->loan_id)
                ->first();

        //get users current loan balance
        $loan_balance = (float)$loan->loan_balance;
        $before_balance = $loan_balance;
        
        //get paid amount
        $paid_amount = (float)$loan->paid_amount;
        //current repayment amount
        $amount = (float)$data->amount;

        //get new loan balance & new paid_amount
        $new_loan_balance = $loan_balance - $amount;
        $new_paid_amount = $paid_amount + $amount;
        $after_balance = $new_loan_balance;

        DB::beginTransaction();
            
            //update the user loan balance
            $userLoan = Loan::findOrFail($data->loan_id);
            $userLoan->paid_amount = $new_paid_amount;
            $userLoan->loan_balance = $new_loan_balance;
            $userLoan->save();

            //update the group account balance
            $groupLoan = Group::where('id', $data->group_id)->first();
            $groupLoan->account_balance = $groupLoan->account_balance + $amount;
            $groupLoan->save();

            //add a new repayment record
            $repayment = Repayment::create([
                'user_id' => $loan->user_id,
                'group_id' => $loan->user->group_id,
                'loan_id' => $data->loan_id,
                'amount' => $amount,
                'before_balance' => $before_balance,
                'after_balance' => $after_balance,
                'comment' => $data->comment,
                'updated_by' => $user_id,
                'created_by' => $user_id,
                'src_host' => getUserAgent(),
                'src_ip' => getIp()
            ]);

            $repayment->save();

        DB::commit();

        return $repayment;

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