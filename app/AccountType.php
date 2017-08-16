<?php

namespace App;

use App\Status;
use App\User;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'name', 'status_id'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

}
