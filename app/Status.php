<?php

namespace App;

use App\Account;
use App\ScheduleSmsOutbox;
use App\SmsOutbox;
use App\User;
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

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function accountTypes()
    {
        return $this->hasMany(AccountType::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
