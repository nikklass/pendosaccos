<?php

namespace App;
use App\Loan;
use App\RepaymentArchive;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    /*object events*/
    protected $events = [
        'created' => Events\RepaymentCreated::class,
        'updated' => Events\RepaymentCreated::class,
    ];

    protected $fillable = [
        'user_id', 'group_id', 'loan_id', 'amount','comment', 'before_balance', 'after_balance', 'src_ip', 'src_host', 'created_by', 'updated_by'
    ];

    /*one to many relationship*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*one to many relationship*/
    public function loan()
    {
        return $this->belongsTo(Loan::class);
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

    /*one to many relationship*/
    public function repaymentArchives()
    {
        return $this->hasMany(RepaymentArchive::class, 'parent_id');
    }

}
