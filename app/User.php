<?php

namespace App;

use App\Company;
use App\Image;
use App\Sacco;
use App\SmsOutbox;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use LaratrustUserTrait; 
    
    //protected $appends = ['profile_image'];

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'sms_user_name',  'password', 'gender', 'company_id', 'phone_number', 'api_token', 'account_number', 'created_by', 'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
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
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    /*one to many relationship*/
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function smsoutboxes()
    {
        return $this->hasMany(SmsOutbox::class);
    }

    public static function getUser()
    {
        $user_id = auth()->user();
        return static::find($user_id);
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
