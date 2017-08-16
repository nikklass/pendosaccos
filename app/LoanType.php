<?php

namespace App;

use App\Loan;
use App\LoanArchive;
use App\Status;
use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'name', 'status_id'
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function loanArchives()
    {
        return $this->hasMany(LoanArchive::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

}
