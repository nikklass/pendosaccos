<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->enum('gender', ['m', 'f']);
            $table->string('email', 50)->unique()->nullable();
            $table->string('phone_number', 13)->unique();
            $table->string('password')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->string('api_token', 60)->unique()->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        
        /*create groups table*/
        Schema::defaultStringLength(191);
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('box', 50)->nullable();
            $table->string('phone_number', 13)->nullable();
            $table->string('email', 50)->unique()->nullable();
            $table->decimal('latitude', 13, 3)->nullable();
            $table->decimal('longitude', 13, 3)->nullable();
            $table->integer('company_id')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();           
            $table->timestamps();
        });

        // Create companies table
        Schema::defaultStringLength(191);
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('box', 50)->nullable();
            $table->string('phone_number', 13)->nullable();
            $table->string('email', 50)->unique()->nullable();
            $table->decimal('latitude', 13, 3)->nullable();
            $table->decimal('longitude', 13, 3)->nullable(); 
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();           
            $table->timestamps();
        });

        // Create table for associating companies to users (Many-to-Many)
        Schema::defaultStringLength(191);
        Schema::create('company_user', function (Blueprint $table) {
            $table->integer('company_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'company_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('company_user');
    }
}
