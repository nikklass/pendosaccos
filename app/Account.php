<?php

namespace App;
use App\AccountType;
use App\Status;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'account_number', 'user_id', 'group_id', 'account_balance', 'account_type_id', 'comment', 'status_id', 'created_by', 'updated_by'
    ];

    /*one to one relationship*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

}
