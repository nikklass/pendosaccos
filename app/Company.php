<?php

namespace App;

use App\Group;
use App\SmsOutbox;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'name', 'description', 'physical_address', 'box', 'phone', 'email', 'latitude', 'longitude'
    ];

    /*one to many relationship*/
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    /*one to many relationship*/
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function smsoutboxes()
    {
        return $this->hasMany(SmsOutbox::class);
    }

}
