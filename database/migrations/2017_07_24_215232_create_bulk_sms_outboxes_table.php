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
            $table->string('user_agent');
            $table->string('src_ip');
            $table->string('src_host');
            $table->integer('user_id');
            $table->integer('sms_type_id');
            $table->integer('company_id');
            $table->integer('group_id')->nullable();
            $table->string('phone_number', 13);
            $table->string('sms_schedule_date');
            $table->string('sms_schedule_status');
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
        Schema::dropIfExists('sms_outbox');
        Schema::dropIfExists('sms_types');
    }
}
