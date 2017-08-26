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
        'user_id', 'team_id', 'amount', 'before_balance', 'after_balance', 'comment', 'src_ip', 'src_host', 'status_id', 'created_by', 'updated_by'
    ];

    /*user accounts*/
    public function user() 
    {
        return $this->belongsTo(RoleUser::class, 'user_id', 'id');
        //class, foreign key, local key
    }

    /*one to many relationship*/
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /*one to many relationship*/
    public function creator()
    {
        return $this->belongsTo(RoleUser::class, 'created_by');
    }

    /*one to many relationship*/
    public function updater()
    {
        return $this->belongsTo(RoleUser::class, 'updated_by');
    }

}
