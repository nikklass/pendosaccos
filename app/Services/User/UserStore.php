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

	public function checkData($data)
	{
		
        //get logged in user
        $auth_user = auth()->user();
        $user_id = $auth_user->id;

        //get user data
        $user_group_id = Group::findOrFail($data->group_id);

        if ((($auth_user->hasRole('administrator')) 
                && ($auth_user->group->id == $user_group_id))
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


	public function createUser($data) {
			
		//get logged in user
		$auth_user = auth()->user();
        $user_id = $auth_user->id;

        //get user data
        $user_group_id = Group::findOrFail($data->group_id);

        //if user is admin, and users and created user groups are same, proceed
        if ((($auth_user->hasRole('administrator')) 
                && ($auth_user->group->id == $user_group_id))
                || ($auth_user->hasRole('superadministrator'))) {
            
            //get group details
            if ($auth_user->hasRole('administrator')) {
                $current_group_id = $auth_user->group->id;
            } else {
               //get user group data
                $current_group_id = $data->group_id;
            }

            DB::beginTransaction();
                
	            //update group new balance
	            $account_balance = $data->account_balance;

				//calculate and update new account balance for group
				$new_group = Group::findOrFail($current_group_id);
	            $new_group->account_balance = $new_group->account_balance + $account_balance;
	            $new_group->save();

                //format the user  phone
                $phone_number = formatPhoneNumber($data->phone_number);

		        //generate random password
		        $password = generateCode(6);

		        //plain password
		        $plain_password = $password;

		        // create user
		        $userData = [
		            'first_name' => $data->first_name,
		            'last_name' => $data->last_name,
		            'email' => $data->email,
		            'gender' => $data->gender,
		            'phone_number' => $phone_number,
		            'password' => bcrypt($password),
		            'api_token' => str_random(60),
		            'created_by' => $user_id,
		            'updated_by' => $user_id
		        ];

		        $user = User::create($userData);

		        //attach user to group
		        $user->groups()->attach($data->group_id, 
		        				[
		        				 'account_balance' => $account_balance, 
		        				 'account_number' => $data->account_number, 
		        				 'account_type_id' => "", 
		        				 'created_by' => $user_id, 
		        				 'updated_by' => $user_id
		        				]);

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
