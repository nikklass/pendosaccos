<?php

namespace App;


use App\Company;
use App\User;
use Illuminate\Database\Eloquent\Model;

class SmsOutbox extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'message', 'phone_number', 'user_id', 'user_agent', 'src_ip', 'src_host', 'status_id', 'sms_type_id', 'created_by', 'updated_by'
    ];

    /*one to many relationship*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*one to many relationship*/
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /*one to many relationship*/
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /*one to one relationship*/
    public function schedulesmsoutbox()
    {
        return $this->belongsTo(ScheduleSmsOutbox::class);
    }

}
