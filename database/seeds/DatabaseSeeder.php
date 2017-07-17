<?php

use App\User;
use App\Sacco;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(UsersTableSeeder::class);
        $this->call(SaccosTableSeeder::class);
        /*$this->call(PermissionTableSeeder::class);
        */
        
    }
}
