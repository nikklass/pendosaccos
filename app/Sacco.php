<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Sacco extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'name', 'description', 'physical_address', 'box', 'phone', 'email', 'latitude', 'longitude'
    ];

	/*many to many relationship*/
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimeStamps();
    }
}
