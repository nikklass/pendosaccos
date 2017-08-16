<?php

namespace App;
use App\Group;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    /*object events*/
    protected $events = [
        'created' => Events\DepositCreated::class,
        'updated' => Events\DepositCreated::class,
    ];

    protected $fillable = [
        'user_id', 'group_id', 'amount', 'before_balance', 'after_balance', 'comment', 'src_ip', 'src_host', 'status_id', 'created_by', 'updated_by'
    ];

    /*one to many relationship*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*one to many relationship*/
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /*one to many relationship*/
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*one to many relationship*/
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
