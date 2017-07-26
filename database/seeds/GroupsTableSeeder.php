<?php

use Illuminate\Database\Seeder;

use App\Group;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Sacco::truncate();
        
        factory(App\Group::class, 20)->create();

    }
}
