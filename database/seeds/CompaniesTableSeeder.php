<?php

use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncating companies table');
        $this->truncateCompaniesTables();

        factory(App\Company::class, 50)->create();

    }


    public function truncateCompaniesTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('companies')->truncate();
        \App\Company::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
