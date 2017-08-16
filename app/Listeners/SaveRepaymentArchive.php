<?php

namespace App\Listeners;

use App\Events\RepaymentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveRepaymentArchive
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RepaymentCreated  $event
     * @return void
     */
    public function handle(RepaymentCreated $event)
    {
        //
    }
}
