<?php

namespace App\Listeners;

use App\Events\WithdrawalCreated;
use App\WithdrawalArchive;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveWithdrawalArchive
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
     * @param  WithdrawalCreated  $event
     * @return void
     */
    public function handle(WithdrawalCreated $event)
    {
        //store archive data
        if ($event->withdrawal) {
            
            $withdrawal_archive = WithdrawalArchive::create([
                'parent_id' => $event->withdrawal->id,
                'user_id' => $event->withdrawal->user_id,
                'group_id' => $event->withdrawal->group_id,
                'amount' => $event->withdrawal->amount,
                'comment' => $event->withdrawal->comment,
                'created_by' => $event->withdrawal->created_by,
                'status_id' => $event->withdrawal->status_id,
                'src_host' => $event->withdrawal->src_host,
                'src_ip' => $event->withdrawal->src_ip
            ]);
            //dd($withdrawal_archive);

            $withdrawal_archive->save();

        }
    }

}
