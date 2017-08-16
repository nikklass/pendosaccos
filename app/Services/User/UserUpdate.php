<?php

namespace App\Services\User;

use App\Group;
use App\Loan;
use App\User;
use Illuminate\Support\Facades\DB;

class UserUpdate 
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


	public function updateUser($data, $id) {
			
		//get logged in user
		$auth_user = auth()->user();
        $user_id = $auth_user->id;

        //get loan user data
        $user = User::findOrFail($id);

		//if user is admin, and users and created user groups are same, proceed
        if ((($auth_user->hasRole('administrator')) 
                && ($auth_user->group->id == $user->group->id))
                || ($auth_user->hasRole('superadministrator'))) {
            
            //get group's current balance
            $account_balance = (float)$auth_user->group->account_balance;
            if ($auth_user->hasRole('administrator')) {
                $current_group_account_balance = (float)$auth_user->group->account_balance;
                $current_group_id = $auth_user->group->id;
            } else {
                $current_group_account_balance = (float)$user->group->account_balance;
                $current_group_id = $user->group->id;
            }

            //get the new group id
            $new_group_id = $data->group_id;


            DB::beginTransaction();
                
                $group_change = false;

                //if user group has been changed and user is superadmin, alter account balance totals
	            if (($current_group_id != $new_group_id) && ($auth_user->hasRole('superadministrator'))) {

		            $group_change = true;

		            //calculate and update group new balance
		            //get amount to add from the user balance
		            $user_account_balance = (float)$user->account_balance;

		            //update old group
		            $group = Group::findOrFail($current_group_id);
		            $group->account_balance = $group->account_balance - $user_account_balance;
		            $group->save();

					//calculate and update  account balance for new group user moves to
					$new_group = Group::findOrFail($new_group_id);
		            $new_group->account_balance = $new_group->account_balance + $user_account_balance;
		            $new_group->save();

		        }

                //update the user 
                $phone_number = formatPhoneNumber($data->phone_number);

                $user = User::findOrFail($id);

		        $user->first_name = $data->first_name;
		        $user->last_name = $data->last_name;
		        $user->email = $data->email;
		        
		        $user->phone_number = $phone_number;
		        $user->account_number = $data->account_number;
		        $user->gender = $data->gender;

		        //only superadmin can alter group id
		        if (($auth_user->hasRole('superadministrator')) && $group_change) {
		        	$user->group_id = $data->group_id;
		        }

		        //dont edit account balance when changing groups
		        if (($auth_user->hasRole('superadministrator')) && !$group_change) {
		        	$user->account_balance = $data->account_balance;
		        }

		        if ($data->password_option == 'auto'){
		            /*auto generate new password*/
		            $password = generateCode(6);
		            $user->password = bcrypt($password);
		            //send the user a link to change password

		        } else if ($data->password_option == 'manual'){
		            /*set to entered password*/
		            $user->password = bcrypt($data->password);
		        }

		        if ($user->save()) {

		            if ($data->rolesSelected) {
		                //sync roles
		                $user->syncRoles(explode(',', $data->rolesSelected));
		            }
		            if ($data->groupsSelected) {
		                //sync groups
		                $groups = explode(',', $data->groupsSelected);
		                $user->groups()->sync($groups);
		            }
		            
		        } 

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
