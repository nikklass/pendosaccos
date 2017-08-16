<?php

namespace App;
use App\Repayment;
use App\User;
use Illuminate\Database\Eloquent\Model;

class RepaymentArchive extends Model
{

    protected $fillable = [
        'parent_id', 'loan_id', 'amount','comment', 'src_ip', 'src_host', 'created_by'
    ];

    /*one to many relationship*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*one to many relationship*/
    public function repayment()
    {
        return $this->belongsTo(Repayment::class, 'id');
    }

}
