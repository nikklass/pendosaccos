<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleSmsOutbox extends Model
{
    
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'message', 'short_message', 'phone_number', 'user_id', 'user_agent', 'src_ip', 'src_host', 'status_id', 'sms_type_id', 'created_by', 'updated_by'
    ];

    /*one to many relationship*/
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function smsoutbox()
    {
        return $this->hasOne(SmsOutbox::class);
    }

}
