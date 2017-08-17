<?php

namespace App\Services\User;

use App\Group;
use App\Loan;
use App\User;
use Illuminate\Support\Facades\DB;

class UserStore 
{
	protected $errors = [];
	protected $valid = true;

	public function checkData($data, $id)
	{
		
        //get logged in user
        $auth_user = auth()->user();
        $user_id = $auth_user->id;

        //get loan user data
        $loan_user = User::findOrFail($id);

        if ((($auth_user->hasRole('administrator')) 
                && ($auth_user->group->id == $loan_user->group->id))
                || ($auth_user->hasRole('superadministrator'))) {

	        //valid phone number?
	        if ($data->phone_number) {
	            if (!isValidPhoneNumber($data->phone_number)){
	                $message = config('constants.error.invalid_phone_number');
	                $this->errors = $message;
            		$this->valid = false;
	            }
	            
	        }

        } else {

            $message = config('constants.error.invalid_access');
            $this->errors = $message;
            $this->valid = false;

        }

		return $this->valid;

	}


	public function createUser($data, $id) {
			
		//get logged in user
		$auth_user = auth()->user();
        $user_id = $auth_user->id;

        //get loan user data
        //dd($data);

		//if user is admin, and users and created user groups are same, proceed
        if ((($auth_user->hasRole('administrator')) 
                && ($auth_user->group->id == $user->group->id))
                || ($auth_user->hasRole('superadministrator'))) {
            
            //get group details
            if ($auth_user->hasRole('administrator')) {
                $current_group_account_balance = (float)$auth_user->group->account_balance;
                $current_group_id = $auth_user->group->id;
            } else {
               //get user group data
                $current_group_id = $data->group_id;
                $new_group = Group::findOrFail($current_group_id);
	            $current_group_account_balance = $new_group->account_balance;
            }

            DB::beginTransaction();
                
	            //update group new balance

				//calculate and update  account balance for new group user moves to
				$new_group = Group::findOrFail($new_group_id);
	            $new_group->account_balance = $new_group->account_balance + $user_account_balance;
	            $new_group->save();

                //create the user 
                $phone_number = formatPhoneNumber($data->phone_number);

		                 //generate random password
		        $password = generateCode(6);

		        // create user
		        $userData = [
		            'first_name' => $data->first_name,
		            'last_name' => $data->last_name,
		            'email' => $data->email,
		            'group_id' => $data->group_id,
		            'account_number' => $data->account_number,
		            'account_balance' => $data->account_balance,
		            'gender' => $data->gender,
		            'phone_number' => $phone_number,
		            'password' => bcrypt($password),
		            'api_token' => str_random(60),
		            'created_by' => $data->user()->id,
		            'updated_by' => $data->user()->id
		        ];

		        $user = User::create($userData);

            DB::commit();  

            return $user;          

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
