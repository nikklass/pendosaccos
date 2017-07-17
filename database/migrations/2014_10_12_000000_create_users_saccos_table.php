<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
            $table->string('email', 50)->unique();
            $table->string('password');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->rememberToken();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::defaultStringLength(191);
        Schema::create('sacco_user', function (Blueprint $table) {
            $table->integer('sacco_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();

            $table->foreign('sacco_id')->references('id')->on('saccos')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'sacco_id']);
        });
        
        /*create saccos table*/
        Schema::defaultStringLength(191);
        Schema::create('saccos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('physical_address');
            $table->string('box', 50);
            $table->string('phone', 100);
            $table->string('email', 50)->unique();
            $table->decimal('latitude', 13, 3);
            $table->decimal('longitude', 13, 3);            
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('saccos');
        Schema::dropIfExists('sacco_user');
    }
}
