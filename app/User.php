<?php

namespace App;

use App\Image;
use App\Sacco;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use EntrustUserTrait;
    
    //protected $appends = ['profile_image'];

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'gender', 'created_by', 'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*relation between token and user*/
    public function token() {
        return $this->hasMany(Token::class);
    }

    /* polymorphic relationship \'*/
    public function images() {
        return $this->morphMany(Image::class, 'imagetable');
    }

    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')->withTimeStamps();
    }

    /*many to many relationship*/
    public function saccos()
    {
        return $this->belongsToMany(Sacco::class)->withTimeStamps();
    }


    /*public function getProfileImageAttribute()
    {
        $default_profile_image['img_url'] = "assets/images/no_image.jpg";
        $user_id = $this->id;

        $profile_image = Image::where('imagetable_id', $user_id)
                ->where('imagetable_type', 'user') 
                ->orderBy('created_at', 'desc')
                ->first();

        $profile_image = find::Image::where('imagetable_id', $user_id)
                ->where('imagetable_type', 'user') 
                ->orderBy('created_at', 'desc')
                ->first();

        if ($profile_image) {
            return $profile_image;
        } else {
            return $default_profile_image;
        }
        
        return $profile_image;
    }*/


}
