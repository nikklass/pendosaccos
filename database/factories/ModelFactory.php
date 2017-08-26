<?php

use App\Group;
use App\Role;
use App\Team;
use App\User;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'gender' => $faker->randomElement($array = array ('m','f')),
        'email' => $faker->unique()->safeEmail,
        'phone_number' => "2547" . $faker->numberBetween(11,99) . $faker->numberBetween(100000,999999),
        'password' => $password ?: $password = bcrypt('123'),
        'src_ip' => $faker->ipv4,
        'src_host' => $faker->ipv4,
        'user_agent' => $faker->userAgent,
        'remember_token' => str_random(10),
        'api_token' => str_random(60),
        'created_by' => 5,
        'updated_by' => 5,
    ];
});

$factory->define(App\Team::class, function (Faker\Generator $faker) {
    
    $company = $faker->company;
    return [
        'display_name' => $company,
        'name' => str_slug($company),
        'description' => $faker->paragraph,
        'physical_address' => $faker->address,
        'email' => $faker->unique()->safeEmail,
        'box' => $faker->numberBetween(250, 5000),
        'phone_number' => "2547" . $faker->numberBetween(11,99) . $faker->numberBetween(100000,999999),
        'src_ip' => $faker->ipv4,
        'src_host' => $faker->ipv4,
        'user_agent' => $faker->userAgent,
        'latitude' => $faker->latitude($min = -90, $max = 90),
        'longitude' => $faker->longitude($min = -180, $max = 180) 
    ];

});

$factory->define(App\Withdrawal::class, function (Faker\Generator $faker) {
    
    $user_id = $faker->numberBetween(6, 25);

    return [
        'user_id' => $user_id,
        'team_id' => $faker->numberBetween(2, 6),
        'amount' => $faker->numberBetween(500,9999),
        'comment' => '',
        'src_ip' => $faker->ipv4,
        'src_host' => $faker->ipv4,
        'user_agent' => $faker->userAgent,
        'created_by' => $user_id, 
        'updated_by' => $user_id
    ];

});

$factory->define(App\Deposit::class, function (Faker\Generator $faker) {
    
    $user_id = $faker->numberBetween(6, 25);
    //$team_id = $faker->numberBetween(2, 6);
    $amount = (float)$faker->numberBetween(500,59999);
    $before_balance = 0;
    
    //get user role
    $user_role = Role::where('name', 'user')->first();

    //get users first entry in role_user
    $user_pivot = DB::table('role_user')
                 ->where("role_user.user_id", "=",$user_id)
                 ->where("role_user.role_id", "=",$user_role->id)
                 ->first();
    
    $now = date("Y-m-d H:i:s");

    //if pivot table record exists, increment user account balance, else do nothing
    if ($user_pivot) {

        $current_account_balance = $user_pivot->account_balance;

        if ($current_account_balance) {
            $before_balance = (float)$current_account_balance;
            $new_account_balance = $current_account_balance + $amount;
        }

        //update pivot table user balance
        DB::table('role_user')
            ->where('id', $user_pivot->id)
            ->update([
                        'account_balance' => $new_account_balance,
                        'updated_by' => '1',
                        'updated_at' => $now
                     ]);


        if ($before_balance > 0) {
            $after_balance = $before_balance + $amount;
        } else {
            $after_balance = $amount;
        }

        //update group account balance
        $team = Team::findOrFail($user_pivot->team_id);
        $team->account_balance = $team->account_balance + $amount;
        $team->save();

        return [
            'user_id' => $user_pivot->id,
            'team_id' => $user_pivot->team_id,
            'amount' => $amount,
            'before_balance' => $before_balance,
            'after_balance' => $after_balance,
            'comment' => 'test data',
            'src_ip' => $faker->ipv4,
            'src_host' => $faker->ipv4,
            'user_agent' => $faker->userAgent,
            'created_by' => $user_id, 
            'updated_by' => $user_id
        ];
        
    }
    
});


$factory->define(App\Repayment::class, function (Faker\Generator $faker) {
    
    $user_id = $faker->numberBetween(6, 25);

    return [
        'user_id' => $user_id,
        'loan_id' => $faker->numberBetween(6, 15),
        'team_id' => $faker->numberBetween(2, 6),
        'amount' => $faker->numberBetween(500,9999),
        'comment' => '',
        'src_ip' => $faker->ipv4,
        'src_host' => $faker->ipv4,
        'user_agent' => $faker->userAgent,
        'created_by' => $user_id, 
        'updated_by' => $user_id
    ];

});


$factory->define(App\Loan::class, function (Faker\Generator $faker) {
    
    $user_id = $faker->numberBetween(6, 25);
    $amount = $faker->numberBetween(500,99999);
    
    //get user group id
    $user = User::findOrFail($user_id);
    //$team_id = $user->team_id;

    return [
        'user_id' => $user_id,
        'team_id' => $team_id,
        'loan_type_id' => 1,
        'loan_amount' => $amount,
        'loan_balance' => $amount,
        'paid_amount' => 0,
        'interest' => $faker->numberBetween(12, 16),
        'period' => $faker->numberBetween(6, 40),
        'comment' => '',
        'status_id' => 1,
        'src_ip' => $faker->ipv4,
        'src_host' => $faker->ipv4,
        'user_agent' => $faker->userAgent,
        'created_by' => $user_id, 
        'updated_by' => $user_id
    ];

});


