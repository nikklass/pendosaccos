<?php

namespace App;
use App\User;
use App\Withdrawal;
use Illuminate\Database\Eloquent\Model;

class WithdrawalArchive extends Model
{

    protected $fillable = [
        'parent_id', 'user_id', 'group_id', 'amount',  'before_balance', 'after_balance', 'comment', 'src_ip', 'src_host', 'status_id', 'created_by'
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
    public function withdrawal()
    {
        return $this->belongsTo(Withdrawal::class, 'id');
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
