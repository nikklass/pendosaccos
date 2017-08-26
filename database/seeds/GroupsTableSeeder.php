<?php

use App\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncating teams table');
        $this->truncateGroupTables();
        
        //create admin company group
        $main_group = new \App\Team([
            'id' => '1',
            'name' => 'pendomedia',
            'display_name' => 'PendoMedia Admin',
            'description' => 'PendoMedia Admin Group',
            'physical_address' => 'Mombasa Plaza',
            'email' => 'info@pendo.co.ke',
            'box' => '123 Mombasa',
            'phone_number' => "254721735369",
            'created_by' => "1",
            'updated_by' => "1"
        ]);
        $main_group->save();

        factory(App\Team::class, 5)->create();

    }

    public function truncateGroupTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('teams')->truncate();
        //DB::table('group_user')->truncate();
        \App\Team::truncate();
        //\App\GroupUser::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
