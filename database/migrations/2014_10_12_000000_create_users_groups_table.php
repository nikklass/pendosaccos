<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->decimal('account_balance', 14, 2)->default(0);
            $table->string('account_number', 50)->nullable();
            $table->integer('account_type_id')->unsigned()->default(1);
            $table->enum('gender', ['m', 'f']);
            $table->string('email', 50)->nullable();
            $table->string('phone_number', 13);
            $table->string('password')->nullable();
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->integer('status_id')->unsigned()->default(1);
            $table->integer('group_id')->unsigned()->nullable();
            $table->string('api_token', 60)->unique()->nullable();
            $table->boolean('active')->default(0);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->unique(array('email', 'group_id'));
            $table->unique(array('account_number', 'group_id'));
            $table->unique(array('phone_number', 'group_id'));
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::defaultStringLength(191);
        Schema::create('user_archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->decimal('account_balance', 14, 2)->default(0);
            $table->string('account_number', 50)->nullable();
            $table->integer('account_type_id')->unsigned()->default(1);
            $table->enum('gender', ['m', 'f']);
            $table->string('email', 50)->nullable();
            $table->string('phone_number', 13);
            $table->string('password')->nullable();
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->integer('status_id')->unsigned()->default(1);
            $table->integer('group_id')->unsigned()->nullable();
            $table->string('api_token', 60)->unique()->nullable();
            $table->boolean('active')->default(0);
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
        });

        
        /*create groups table*/
        Schema::defaultStringLength(191);
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('account_balance', 14, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('box', 50)->nullable();
            $table->string('phone_number', 13)->nullable();
            $table->string('email', 50)->nullable();
            $table->decimal('latitude', 13, 3)->nullable();
            $table->decimal('longitude', 13, 3)->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();           
            $table->timestamps();
        });

        /*create groups table*/
        Schema::defaultStringLength(191);
        Schema::create('group_archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->string('name');
            $table->decimal('account_balance', 14, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('box', 50)->nullable();
            $table->string('phone_number', 13)->nullable();
            $table->string('email', 50)->nullable();
            $table->decimal('latitude', 13, 3)->nullable();
            $table->decimal('longitude', 13, 3)->nullable();
            $table->integer('created_by')->unsigned()->nullable();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('user_archives');
        Schema::dropIfExists('group_archives');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    

}
