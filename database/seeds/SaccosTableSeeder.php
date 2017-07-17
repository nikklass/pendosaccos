<?php

use Illuminate\Database\Seeder;

use App\Sacco;

class SaccosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sacco::truncate();
        
        factory(App\Sacco::class, 20)->create();

    }
}
