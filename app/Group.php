<?php

namespace App;
use App\Deposit;
use App\User;
use App\Loan;
use App\Withdrawal;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name', 'description', 'physical_address', 'box', 'phone', 'email', 'latitude', 'longitude'
    ];

    /*one to many relationship*/
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /*withdrawals relationship*/
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    /*deposits relationship*/
    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    /*deposits relationship*/
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

}
