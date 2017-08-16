<?php

namespace App;

use App\Account;
use App\AccountType;
use App\Deposit;
use App\Image;
use App\Loan;
use App\Repayment;
use App\RepaymentArchive;
use App\Sacco;
use App\SmsOutbox;
use App\Withdrawal;
use App\WithdrawalArchive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use LaratrustUserTrait; 

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'first_name', 'last_name', 'account_number', 'account_balance', 'email', 'group_id', 'password', 'gender', 'phone_number', 'api_token', 'status_id','created_by', 'updated_by'
    ];

    /*object events*/
    /*protected $events = [
        'updated' => Events\AccountAdded::class,
    ];*/

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

    /*one to many relationship*/
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function smsOutboxes()
    {
        return $this->hasMany(SmsOutbox::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function withdrawalArchives()
    {
        return $this->hasMany(WithdrawalArchive::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }

    public function repaymentArchives()
    {
        return $this->hasMany(RepaymentArchive::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function createdWithdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'id');
    }

    public function updatedWithdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'id');
    }

    public function createdDeposits()
    {
        return $this->hasMany(Deposit::class, 'id');
    }

    public function updatedDeposits()
    {
        return $this->hasMany(Deposit::class, 'id');
    }

    public static function getUser()
    {
        $user_id = auth()->user();
        $userGroup = User::where('id', auth()->user()->id)->with('group')->first();
        return $userGroup;
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
