<?php

namespace App\Services\User;

use App\TempTable;
use App\User;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class UserImport 
{
	protected $users = [];
	protected $valid = true;
	protected $errorRows = [];
	protected $rows = [];
	protected $errorRowId;
	protected $validRowId;

	public function checkImportData($data, $group_id)
	{
		
		$emails = [];
		$phone_numbers = [];
		$account_numbers = [];

		foreach ($data as $key => $row) {

			$this->rows[] = $row;
			//check for valid email
			if (!validateEmail($row['email'])) {
				$row['messageemail'] = 'Invalid email';
				$this->errorRows[$key] = $row;
				$this->valid = false;
			} else {
				$emails[] = $row['email'];
			}

			//check for valid phone number
			if (!isValidPhoneNumber($row['phone_number'])) {
				$row['messagephone'] = 'Invalid phone number';
				$this->errorRows[$key] = $row;
				$this->valid = false;
			} else {
				$phone_numbers[] = $row['phone_number'];
			}

			$account_numbers[] = $row['account_number'];

		}

		//check existing email
		$emailexist = $this->checkEmailUserExist($emails, $group_id);

		if (count($emailexist) > 0) {
			$this->valid = false;
			$this->addEmailUserExistErrorMessage($emailexist, $data);
		}

		//check existing phone number
		$phonenumberexist = $this->checkPhoneNumberUserExist($phone_numbers, $group_id);

		if (count($phonenumberexist) > 0) {
			$this->valid = false;
			$this->addPhoneNumberUserExistErrorMessage($phonenumberexist, $data);
		}

		//check existing account number
		$accountnumberexist = $this->checkAccountNumberUserExist($account_numbers, $group_id);
		
		if (count($accountnumberexist) > 0) {
			$this->valid = false;
			$this->addAccountNumberUserExistErrorMessage($accountnumberexist, $data);
		}

		//is user admin or superadmin
		if ((($auth_user->hasRole('administrator')) 
                && ($auth_user->group->id == $user_group_id))
                || ($auth_user->hasRole('superadministrator'))) {

        } else {

            $message = config('constants.error.invalid_access');
            $this->errors = $message;
            $this->valid = false;

        }

		return $this->valid;

	}

	public function createUsers($data, $group_id) {

		//get logged in user
		$auth_user = auth()->user();
        $user_id = $auth_user->id;

        //get user data
        $user_group_id = Group::findOrFail($group_id);

        //if user is admin, and users and created user groups are same, proceed
        if ((($auth_user->hasRole('administrator')) 
                && ($auth_user->group->id == $user_group_id))
                || ($auth_user->hasRole('superadministrator'))) {
            
            //get group details
            if ($auth_user->hasRole('administrator')) {
                $current_group_id = $auth_user->group->id;
            } else {
               //get user group data
                $current_group_id = $group_id;
            }

            DB::beginTransaction();
                
	            //update group new balance
	            $account_balance = $data->account_balance;

				if ($account_balance > 0) {

					//calculate and update new account balance for group
					$new_group = Group::findOrFail($current_group_id);
		            $new_group->account_balance = $new_group->account_balance + $account_balance;
		            $new_group->save();

		        }

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
		            'group_id' => $data->group_id,
		            'account_number' => $data->account_number,
		            'account_balance' => $account_balance,
		            'gender' => $data->gender,
		            'phone_number' => $phone_number,
		            'password' => bcrypt($password),
		            'api_token' => str_random(60),
		            'created_by' => $user_id,
		            'updated_by' => $user_id
		        ];

		        $user = User::create($userData);

            DB::commit();  

            return $user;           

        }

	}

	public function getErrorRowId()
	{
		 if (count($this->errorRows)) {

			ksort($this->errorRows);

			//store row data in db
			$row = TempTable::create([
				'uuid' => Uuid::generate(),
				'user_id' => auth()->user()->id,
				'data' => serialize($this->errorRows),
			]);

			$this->errorRowId = $row->uuid->string;

			return $row->uuid->string;

		} else {
			return [];
		}

	}

	private function checkEmailUserExist($emails, $group_id)
	{
		return User::whereIn('email', $emails)
			->where('group_id', $group_id)
		    ->get()
		    ->pluck('email')
		    ->toArray();
	}

	private function checkPhoneNumberUserExist($phone_numbers, $group_id)
	{
		return User::whereIn('phone_number', $phone_numbers)
			->where('group_id', $group_id)
		    ->get()
		    ->pluck('phone_number')
		    ->toArray();
	}

	private function checkAccountNumberUserExist($account_numbers, $group_id)
	{
		return User::whereIn('account_number', $account_numbers)
			->where('group_id', $group_id)
		    ->get()
		    ->pluck('account_number')
		    ->toArray();
	}

	/*email exists message*/
	private function addEmailUserExistErrorMessage($emailexist, $rows)
	{
		foreach ($rows as $key => $row) {
			if (in_array($row['email'], $emailexist)) {
				$row['messageemail'] = 'Email exists';
				$this->errorRows[$key] = $row;
			} 
		}
		//dump("email exist - ");
		//dd($rows);
		return $rows;
	}

	/*phone number exists message*/
	private function addPhoneNumberUserExistErrorMessage($phonenumberexist, $rows)
	{
		foreach ($rows as $key => $row) {
			if (in_array($row['phone_number'], $phonenumberexist)) {
				$row['messagephone'] = 'Phone number exists';
				$this->errorRows[$key] = $row;
			} 
		}
		//dump("phone exist - ");
		//dd($rows);
		return $rows;
	}

	/*account number exists message*/
	private function addAccountNumberUserExistErrorMessage($accountnumberexist, $rows)
	{
		foreach ($rows as $key => $row) {
			if (in_array($row['account_number'], $accountnumberexist)) {
				$row['messageaccount'] = 'Account number exists';
				$this->errorRows[$key] = $row;
			} 
		}
		//dump("acct exist - ");
		//dd($rows);
		return $rows;
	}


	/*get valid users*/
	public function getValidRowId()
	{
		//$errorRows = $this->getErrorRows();
		$errorRows = TempTable::where('uuid', $this->errorRowId)->first();
		$errorRows = unserialize($errorRows->data);

		$validUsers = [];

		$emails = array_column($errorRows, 'email');
		$account_numbers = array_column($errorRows, 'account_number');
		$phone_numbers = array_column($errorRows, 'phone_number');

		foreach ($this->rows as $row) {
			if 	(
					(!in_array($row['email'], $emails)) 
					&& (!in_array($row['account_number'], $account_numbers)) 
					&& (!in_array($row['phone_number'], $phone_numbers))
				) 
			{
				$validUsers[] = $row;
			}
		}

		if (count($validUsers))  {
			//store row data in db
			$row = TempTable::create([
				'uuid' => Uuid::generate(),
				'user_id' => auth()->user()->id,
				'data' => serialize($validUsers),
			]);

			return $row->uuid->string;

		} else {

			return [];

		}

	}

}