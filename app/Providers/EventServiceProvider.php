<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Registered' => [
            'App\Listeners\SendWelcomeEmail',
            'App\Listeners\SaveUserArchive',
        ],
        'App\Events\WithdrawalCreated' => [
            'App\Listeners\SaveWithdrawalArchive',
        ],
        'App\Events\DepositCreated' => [
            'App\Listeners\SaveDepositArchive',
        ],
        'App\Events\LoanCreated' => [
            'App\Listeners\SaveLoanArchive',
        ],
        'App\Events\RepaymentCreated' => [
            'App\Listeners\SaveRepaymentArchive',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
