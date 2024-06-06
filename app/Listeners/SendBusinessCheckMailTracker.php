<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Carbon\Carbon;

class SendBusinessCheckMailTracker
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
     * Handle the event by updating the businessCheckMailSentAt field.
     *
     * @param  Illuminate\Mail\Events\MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        if (isset($event->data['business'])) {
            /* @var $business \TheRestartProject\RepairDirectory\Domain\Models\Business */
            $business = $event->data['business'];
            // This will store a GMT date time
            $business->setBusinessCheckMailSentAt(Carbon::now());
            $event->data['em']->flush();
        }
    }
}
