<?php

namespace App\Services\User;

use App\Group;
use App\Loan;
use App\Role;
use App\RoleUser;
use App\User;
use Illuminate\Support\Facades\DB;

class UserUpdate 
{
	protected $errors = [];
	protected $valid = true;
	protected $pagePermission = 'edit-user';

	public function checkData($data, $id)
	{

        $error = false;

        //check perms
	    $roles_data = explode(',', $data->rolesSelected);
	    
	    foreach ($roles_data as $role) {

	    	//split value to get roles - 2nd param
	    	$role_data = explode('-', $role);

	    	$team_id = $role_data[0];
	    	
	    	//get team ids
        	if (isAdminGroupIdsError($team_id, $this->pagePermission)) {
        		$error = true;
        		break;
        	}

	    }

        if (!$error) {

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
        $user_valid = false;

        //init arrays
        $team_ids = [];
        $role_ids = [];

        if ($auth_user->hasRole('superadministrator')) {

        	$user_valid = true;

        } else {

	        //get user roles and team ids	        
	        $roles_data = explode(',', $data->rolesSelected);

	        foreach ($roles_data as $role) {

	        	//split value to get roles - 2nd param
	        	$role_data = explode('-', $role);

	        	$team_id = $role_data[0];
	        	$role_id = $role_data[1];

	        	//get role name
	        	$role_name_data = Role::findOrFail($role_id);
	        	$role_name = $role_name_data->name;
	        	
	        	//check user permissions
	        	if ((!isAdminGroupIdsError($team_id, $this->pagePermission)) && ($role_name != 'user')) {
	        		$team_ids[] = $team_id;
	        		$role_ids[] = $role_id;
	        		//$role_names[] = $role_name;
	        	}

	        }

	        if (count($team_ids)) { 
	        	$user_valid = true;
	        }

	    }

		//if user is valid, proceed
        if ($user_valid) { 

            //get the user record to edit                                               
            $user = User::findOrFail($id);

            DB::beginTransaction();

                //format phone number 
                $phone_number = formatPhoneNumber($data->phone_number);

		        //update user
		        $user->first_name = $data->first_name;
		        $user->last_name = $data->last_name;
		        $user->email = $data->email;
		        $user->phone_number = $phone_number;
		        $user->gender = $data->gender;

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

		            if (count($role_ids)) {

		                //get all role ids except user role
		                $all_admin_role_ids = Role::where('name', '!=', 'user')->pluck('id');

		                //detach all previous admin roles - Pass along an array of role IDs
						$user->roles()->detach($all_admin_role_ids);

						//current date
						$now = date('Y-m-d H:i:s');
		                
		                //attach new admin roles
		                $i = 0;

		                foreach ($role_ids as $role_id) {
			                // create role user
					        $roleUserData = [
					            'team_id' => $team_ids[$i],
			                	'user_id' => $user->id,
			                	'role_id' => $role_id,
			                	'user_type' => 'App\User',
			                	'created_by' => $user_id,
			                	'updated_by' => $user_id,
					            'updated_at' => $now,
			                	'created_at' => $now
					        ];

					        $roleUser = RoleUser::create($roleUserData);

					        $i++;

					    }
					    //end attach new roles

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
