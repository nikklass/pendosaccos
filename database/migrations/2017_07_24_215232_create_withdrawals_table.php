<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        /*withdrawals table*/
        Schema::defaultStringLength(191);
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->bigInteger('amount');
            $table->decimal('before_balance',14,2)->default(0);
            $table->decimal('after_balance',14,2)->default(0);
            $table->text('comment')->nullable();
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('status_id')->unsigned()->default(8);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::defaultStringLength(191);
        Schema::create('withdrawal_archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->decimal('amount',14,2);
            $table->decimal('before_balance',14,2)->default(0);
            $table->decimal('after_balance',14,2)->default(0);
            $table->text('comment')->nullable();
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
        });

        /*deposits table*/
        Schema::defaultStringLength(191);
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->decimal('amount',14,2);
            $table->decimal('before_balance',14,2)->default(0);
            $table->decimal('after_balance',14,2)->default(0);
            $table->text('comment')->nullable();
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('status_id')->unsigned()->default(8);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        /*deposit archives table*/
        Schema::defaultStringLength(191);
        Schema::create('deposit_archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->decimal('amount',14,2);
            $table->decimal('before_balance',14,2)->default(0);
            $table->decimal('after_balance',14,2)->default(0);
            $table->text('comment')->nullable();
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
        });

        /*repayments table*/
        Schema::defaultStringLength(191);
        Schema::create('repayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->integer('loan_id')->unsigned();
            $table->decimal('amount',14,2);
            $table->decimal('before_balance',14,2)->default(0);
            $table->decimal('after_balance',14,2)->default(0);
            $table->text('comment')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        /*repayment archives table*/
        Schema::defaultStringLength(191);
        Schema::create('repayment_archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->integer('loan_id')->unsigned();
            $table->decimal('amount',14,2);
            $table->decimal('before_balance',14,2)->default(0);
            $table->decimal('after_balance',14,2)->default(0);
            $table->text('comment')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
        });

        /*loans table*/
        Schema::defaultStringLength(191);
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->integer('loan_type_id')->unsigned()->default(1);
            $table->decimal('loan_amount',14,2);
            $table->decimal('paid_amount',14,2)->default(0);
            $table->decimal('loan_balance',14,2)->default(0);
            $table->decimal('interest',5,2)->default(0);
            $table->smallInteger('period')->unsigned();
            $table->text('comment')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        /*loans table*/
        Schema::defaultStringLength(191);
        Schema::create('loan_archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->integer('loan_type_id')->unsigned();
            $table->decimal('loan_amount',14,2);
            $table->decimal('paid_amount',14,2)->default(0);
            $table->decimal('loan_balance',14,2)->default(0);
            $table->decimal('interest',5,2)->default(0);
            $table->smallInteger('period')->unsigned();
            $table->text('comment')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
        });

        //account types table
        Schema::defaultStringLength(191);
        Schema::create('account_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        //loan types table
        Schema::defaultStringLength(191);
        Schema::create('loan_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('withdrawals');
        Schema::dropIfExists('withdrawal_archives');
        Schema::dropIfExists('deposits');
        Schema::dropIfExists('deposit_archives');
        Schema::dropIfExists('repayments');
        Schema::dropIfExists('repayment_archives');
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('loan_types');
        Schema::dropIfExists('account_types');
        Schema::dropIfExists('loans');
        Schema::dropIfExists('loan_archives');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
