<?php

use App\Group;
use App\User;

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
        'group_id' => $faker->numberBetween(1,5),
        'password' => $password ?: $password = bcrypt('123'),
        'remember_token' => str_random(10),
        'account_balance' => $faker->numberBetween(1000,99999),
        'account_number' => $faker->numberBetween(1000,99999),
        'api_token' => str_random(60),
        'created_by' => 5,
        'updated_by' => 5,
    ];
});

$factory->define(App\Group::class, function (Faker\Generator $faker) {
    
    return [
        'name' => $faker->company,
        'description' => $faker->paragraph,
        'physical_address' => $faker->address,
        'email' => $faker->unique()->safeEmail,
        'box' => $faker->numberBetween(250, 5000),
        'phone_number' => "2547" . $faker->numberBetween(11,99) . $faker->numberBetween(100000,999999),
        'latitude' => $faker->latitude($min = -90, $max = 90),
        'longitude' => $faker->longitude($min = -180, $max = 180) 
    ];

});

$factory->define(App\Withdrawal::class, function (Faker\Generator $faker) {
    
    $user_id = $faker->numberBetween(1, 10);

    return [
        'user_id' => $user_id,
        'group_id' => $faker->numberBetween(1, 5),
        'amount' => $faker->numberBetween(500,9999),
        'comment' => $faker->paragraph,
        'src_ip' => $faker->numberBetween(2500, 5000),
        'src_host' => $faker->numberBetween(1000,99999),
        'created_by' => $user_id, 
        'updated_by' => $user_id
    ];

});

$factory->define(App\Deposit::class, function (Faker\Generator $faker) {
    
    $user_id = $faker->numberBetween(1, 10);
    $amount = (float)$faker->numberBetween(500,59999);
    
    //get user group id and account balance
    $user = User::findOrFail($user_id);
    $group_id = $user->group_id;
    $before_balance = (float)$user->account_balance;

    if ($before_balance > 0) {
        $after_balance = $before_balance + $amount;
    } else {
        $after_balance = $amount;
    }

    //update user account balance
    $user->account_balance = $user->account_balance + $amount;
    $user->save();

    //update group account balance
    $group = Group::findOrFail($group_id);
    $group->account_balance = $group->account_balance + $amount;
    $group->save();

    return [
        'user_id' => $user_id,
        'group_id' => $group_id,
        'amount' => $amount,
        'before_balance' => $before_balance,
        'after_balance' => $after_balance,
        'comment' => $faker->paragraph,
        'src_ip' => $faker->numberBetween(2500, 5000),
        'src_host' => $faker->numberBetween(1000,99999),
        'created_by' => $user_id, 
        'updated_by' => $user_id
    ];

});

$factory->define(App\Repayment::class, function (Faker\Generator $faker) {
    
    $user_id = $faker->numberBetween(1, 10);

    return [
        'user_id' => $user_id,
        'loan_id' => $faker->numberBetween(1, 10),
        'group_id' => $faker->numberBetween(1, 5),
        'amount' => $faker->numberBetween(500,9999),
        'comment' => $faker->paragraph,
        'src_ip' => $faker->numberBetween(2500, 5000),
        'src_host' => $faker->numberBetween(1000,99999),
        'created_by' => $user_id, 
        'updated_by' => $user_id
    ];

});


$factory->define(App\Loan::class, function (Faker\Generator $faker) {
    
    $user_id = $faker->numberBetween(1, 10);
    $amount = $faker->numberBetween(500,99999);
    
    //get user group id
    $user = User::findOrFail($user_id);
    $group_id = $user->group_id;

    return [
        'user_id' => $user_id,
        'group_id' => $group_id,
        'loan_type_id' => 1,
        'loan_amount' => $amount,
        'loan_balance' => $amount,
        'paid_amount' => 0,
        'interest' => $faker->numberBetween(12, 16),
        'period' => $faker->numberBetween(6, 40),
        'comment' => $faker->paragraph,
        'status_id' => 1,
        'src_ip' => $faker->numberBetween(2500, 5000),
        'src_host' => $faker->numberBetween(1000,99999),
        'created_by' => $user_id, 
        'updated_by' => $user_id
    ];

});


