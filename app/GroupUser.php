<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;

class GroupUser extends Model
{
    use HasApiTokens, Notifiable;
    use LaratrustUserTrait; 

    protected $table = "group_user";

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'user_id', 'group_id','account_number', 'account_balance', 'account_type_id','created_by', 'updated_by'
    ];

}
