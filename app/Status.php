<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'name', 'section'
    ];

    public function smsoutboxes()
    {
        return $this->hasMany(SmsOutbox::class);
    }

    public function schedulesmsoutboxes()
    {
        return $this->hasMany(ScheduleSmsOutbox::class);
    }

}
