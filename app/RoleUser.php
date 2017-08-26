<?php

namespace App;

use App\Account;
use App\Deposit;
use App\Image;
use App\Loan;
use App\Repayment;
use App\Role;
use App\Team;
use App\User;
use App\Withdrawal;
use App\WithdrawalArchive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleUser extends Model
{

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'user_id', 'role_id','team_id', 'account_number', 'account_balance', 'user_type', 'account_type_id', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    //protected $appends = ['team', 'user', 'role'];

    /**
     * Set Model table
     */
    protected $table = 'role_user';


    /*one to many relationship*/
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /*one to many relationship*/
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id')->orderBy('display_name');
    }

    /*one to many relationship*/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->orderBy('first_name');
        //class, foreign key, local key
    }

    /*one to many relationship*/
    public function loans()
    {
        return $this->hasMany(Loan::class, 'user_id', 'id');
        //class, foreign key, local key
    }

    /*user deposits*/
    public function deposits() {
        return $this->hasMany(Deposit::class, 'user_id', 'id')->orderBy('id', 'desc');
        //class, foreign key, local key
    }

 
    //start attributes
    /*public function getTeamAttribute()
    {
        return Team::findOrFail($this->team_id);
    }

    public function getRoleAttribute()
    {
        return Role::findOrFail($this->role_id);
    }

    public function getUserAttribute()
    {
        return User::findOrFail($this->user_id);
    }*/
    //end attributes



}
