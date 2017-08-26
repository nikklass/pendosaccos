<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LaratrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::defaultStringLength(191);
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for storing permissions
        Schema::defaultStringLength(191);
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });


        // Create table for associating permissions to roles (Many-to-Many)
        Schema::defaultStringLength(191);
        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });


        // Create table for storing teams
        Schema::defaultStringLength(191);
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();

            $table->decimal('account_balance', 14, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('box', 50)->nullable();
            $table->string('phone_number', 13)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->string('user_agent')->nullable();
            $table->decimal('latitude', 13, 3)->nullable();
            $table->decimal('longitude', 13, 3)->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();           

            $table->timestamps();
        });


        Schema::defaultStringLength(191);
        Schema::create('role_user', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('user_id');
            $table->string('user_type')->nullable();
            $table->decimal('account_balance', 14, 2)->default(0);       
            $table->string('account_number', 50)->nullable();
            $table->integer('account_type_id')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable(); 
            $table->unsignedInteger('team_id')->nullable();
            $table->timestamps();

            // Create foreign keys
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')
                ->onUpdate('cascade')->onDelete('cascade');

            // Create a unique key
            $table->unique(['user_id', 'role_id', 'user_type', 'team_id']);
            
        });


        Schema::defaultStringLength(191);
        Schema::create('permission_user', function (Blueprint $table) {

            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('user_id');
            $table->string('user_type')->nullable();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');

            // Add team_id column
            $table->unsignedInteger('team_id')->nullable();

            $table->foreign('team_id')->references('id')->on('teams')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['user_id', 'permission_id', 'user_type', 'team_id']);
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('teams');
    }
}
