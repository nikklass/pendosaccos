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
            $table->string('message');
            $table->string('short_message');
            $table->string('user_agent');
            $table->string('src_ip');
            $table->string('src_host');
            $table->integer('user_id');
            $table->integer('status_id')->default(1);
            $table->integer('schedule_sms_outbox_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->string('phone_number', 13);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        /*schedule sms outbox table*/
        Schema::defaultStringLength(191);
        Schema::create('schedule_sms_outboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message');
            $table->string('user_agent');
            $table->string('src_ip');
            $table->string('src_host');
            $table->integer('user_id');
            $table->integer('company_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->string('phone_number', 13);
            $table->string('sms_schedule_date')->nullable();
            $table->integer('sms_schedule_status')->default(99)->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        /*sms types table*/
        Schema::defaultStringLength(191);
        Schema::create('sms_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
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
    }
}
