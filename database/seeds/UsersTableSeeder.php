<?php

use App\Role;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\User::class, 20)->create()->each(function($user)
        {

            $faker = Faker::create();

            $team_id = $faker->numberBetween(2, 6);
            $amount = $faker->numberBetween(500,99999);
            $account_number = $faker->numberBetween(10000,99999);
            $user_id = $user->id;

            //get user role
            $user_role = Role::where('name', 'user')->first();
            $now = date("Y-m-d H:i:s");

            //assign user to role in team/group

            //insert the record
            DB::table('role_user')
            ->insert([
                        'user_id' => $user_id,
                        'role_id' => $user_role->id,
                        'team_id' => $team_id,
                        'user_type' => 'App\User',
                        'account_number' => $account_number,
                        'account_type_id' => '1',
                        'created_by' => $user_id,
                        'updated_by' => $user_id,
                        'created_at' => $now,
                        'updated_at' => $now
                     ]);


        });

    }

    public function truncateUserTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('users')->truncate();
        
        \App\User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
