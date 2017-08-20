<?php

namespace App;

use App\Group;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Mpesac2b extends Model
{
    /*object events*/
    /*protected $events = [
        'created' => Events\Mpesac2bCreated::class,
        'updated' => Events\Mpesac2bCreated::class,
    ];*/

    protected $fillable = [
        'amount', 'phone_number', 'CommandID', 'BillRefNumber', 'ShortCode', 'src_ip', 'src_host'
    ];

}
