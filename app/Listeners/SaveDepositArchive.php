<?php

namespace App\Listeners;

use App\Events\DepositCreated;
use App\DepositArchive;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveDepositArchive
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DepositCreated $event)
    {
        //store archive data
        if ($event->deposit) {
            
            $deposit_archive = DepositArchive::create([
                'parent_id' => $event->deposit->id,
                'user_id' => $event->deposit->user_id,
                'team_id' => $event->deposit->team_id,
                'amount' => $event->deposit->amount,
                'before_balance' => $event->deposit->before_balance,
                'after_balance' => $event->deposit->after_balance,
                'comment' => $event->deposit->comment,
                'created_by' => $event->deposit->created_by,
                'status_id' => $event->deposit->status_id,
                'src_host' => $event->deposit->src_host,
                'src_ip' => $event->deposit->src_ip
            ]);

            $deposit_archive->save();

        }
    }
}
