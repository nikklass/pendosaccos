<?php

namespace App;

use App\Account;
use App\AccountType;
use App\Deposit;
use App\Image;
use App\Loan;
use App\Repayment;
use App\RepaymentArchive;
use App\RoleUser;
use App\Sacco;
use App\SmsOutbox;
use App\Team;
use App\Withdrawal;
use App\WithdrawalArchive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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
        'first_name', 'last_name','email', 'password', 'gender', 'phone_number', 'api_token', 'status_id','created_by', 'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    //override 'isInSameTeam' method in LaratrustUserTrait
    public function isInSameTeam($rolePermission, $team)
    {
        if (config('laratrust.use_teams') || is_null($team)) {
            return true;
        }

        $teamForeignKey = $this->teamForeignKey();
        return $rolePermission->pivot->$teamForeignKey == $team;
    }

    /*user accounts*/
    public function accounts() {

        //get user accounts, with user roles only
        $user_role_id = Role::where('name', 'user')->pluck('id');
        return $this->hasMany(RoleUser::class, 'user_id', 'id')
                    ->where('role_id', $user_role_id);
        //class, foreign key, local key
    }


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
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'role_user', 'user_id', 'team_id')
            ->withPivot('account_balance', 'account_number', 'account_type_id', 'created_by', 'updated_by', 'created_at', 'updated_at')
            ->withTimestamps();
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
        $userGroup = User::where('id', auth()->user()->id)->with('roles')->first();
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
