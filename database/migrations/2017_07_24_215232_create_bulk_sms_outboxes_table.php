<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class CreateBulkSmsOutboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        /*sms outbox table*/
        Schema::defaultStringLength(191);
        Schema::create('sms_outboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->string('short_message', 50);
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->default(8);
            $table->integer('sms_type_id')->unsigned()->default(6);
            $table->integer('schedule_sms_outbox_id')->unsigned()->nullable();
            $table->integer('team_id')->unsigned()->nullable();
            $table->string('sms_user_name', 50)->nullable();
            $table->string('phone_number', 13);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        /*schedule sms outbox table*/
        Schema::defaultStringLength(191);
        Schema::create('schedule_sms_outboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->string('short_message', 50);
            $table->string('src_ip')->nullable();
            $table->string('src_host')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->default(5);
            $table->integer('sms_type_id')->unsigned()->default(6);
            $table->string('sms_user_name', 50)->nullable();
            $table->integer('team_id')->unsigned()->nullable();
            $table->string('phone_number', 13);
            $table->string('schedule_date')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        /*sms types table*/
        Schema::defaultStringLength(191);
        Schema::create('sms_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('description', 255);
            $table->timestamps();
        });

        //sms types table
        Schema::defaultStringLength(191);
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->text('section');
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
        Schema::dropIfExists('sms_outboxes');
        Schema::dropIfExists('schedule_sms_outboxes');
        Schema::dropIfExists('sms_types');
        Schema::dropIfExists('statuses');
    }
}
