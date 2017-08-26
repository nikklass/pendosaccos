<?php

use App\Deposit;
use App\DepositArchive;
use App\Repayment;
use App\Withdrawal;
use App\WithdrawalArchive;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WithdrawalsSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void 
     */
    public function run()
    {

        $this->command->info('Truncating withdrawals, deposits, loans and repayments tables');
        $this->truncateWithdrawalsTables();

        factory(App\Deposit::class, 20)->create();

        //factory(App\Withdrawal::class, 50)->create();

        //factory(App\Loan::class, 10)->create();

        //factory(App\Repayment::class, 100)->create();

    }

    public function truncateWithdrawalsTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('withdrawals')->truncate();
        DB::table('withdrawal_archives')->truncate();
        DB::table('deposits')->truncate();
        DB::table('deposit_archives')->truncate();
        /*DB::table('loans')->truncate();
        DB::table('loan_archives')->truncate();
        DB::table('repayments')->truncate();
        DB::table('repayment_archives')->truncate();*/
        \App\Withdrawal::truncate();
        \App\WithdrawalArchive::truncate();
        \App\Deposit::truncate();
        \App\DepositArchive::truncate();
        /*\App\Loan::truncate();
        \App\LoanArchive::truncate();
        \App\Repayment::truncate();
        \App\RepaymentArchive::truncate();*/
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}