<?php

use App\Company;

use Illuminate\Database\Seeder;
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
        //User::truncate();

        factory(App\Company::class, 20)->create();

    }
}
