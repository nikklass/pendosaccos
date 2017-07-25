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
        'message', 'phone_number', 'user_id', 'user_agent', 'src_ip', 'src_host', 'sms_type_id', 'created_by', 'created_at'
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
}
