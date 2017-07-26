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

    /*many to many relationship*/
    public function groups()
    {
        return $this->hasMany(Group::class)->withTimeStamps();
    }

    /*many to many relationship*/
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimeStamps();
    }

    public function smsoutboxes()
    {
        return $this->hasMany(SmsOutbox::class);
    }

}
