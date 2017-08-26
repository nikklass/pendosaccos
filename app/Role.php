<?php 

namespace App;

use Laratrust\LaratrustRole;

class Role extends LaratrustRole
{

	/*many to many relationship*/
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'role_user', 'role_id', 'team_id')
            ->withPivot('account_balance', 'account_number', 'account_type_id', 'created_by', 'updated_by', 'created_at', 'updated_at')
            ->withTimestamps();
    }

    /*role users*/
    public function users() {
        return $this->hasMany(RoleUser::class, 'role_id', 'id');
        //class, foreign key, local key
    }

    public function role_teams()
	{
	   return $this->hasManyThrough(Team::class, Role::class);
	}

}