<?php

namespace App;
use App\Loan;
use App\LoanType;
use App\User;
use Illuminate\Database\Eloquent\Model;

class LoanArchive extends Model
{

    protected $fillable = [
        'parent_id', 'user_id', 'group_id', 'loan_amount', 'loan_type_id', 'paid_amount','comment', 'src_ip', 'src_host', 'status_id', 'created_by', 'updated_by'
    ];

    /*one to many relationship*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*one to many relationship*/
    public function loan()
    {
        return $this->belongsTo(Loan::class, 'id');
    }

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }

}
