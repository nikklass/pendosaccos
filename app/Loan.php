<?php

namespace App;
use App\LoanArchive;
use App\LoanType;
use App\Repayment;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id', 'group_id', 'loan_amount', 'loan_balance', 'loan_type_id', 'paid_amount','comment', 'interest', 'period', 'src_ip', 'src_host', 'status_id', 'created_by', 'updated_by'
    ];

    /*one to many relationship*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*one to many relationship*/
    public function repayments()
    {
        return $this->hasMany(Repayment::class);
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

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }

    /*one to many relationship*/
    public function loanArchives()
    {
        return $this->hasMany(LoanArchive::class, 'parent_id');
    }

}
