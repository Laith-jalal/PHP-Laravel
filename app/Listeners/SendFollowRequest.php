<?php

namespace App\Listeners;

use App\Events\SendFollowRequestEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFollowRequest
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
     * @param  SendFollowRequestEvent  $event
     * @return void
     */
    public function handle(SendFollowRequestEvent $event)
    {
        \Auth::user()->sendFollowRequest($event->user->id);
    }
}
