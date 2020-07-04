<?php

namespace App\Listeners;

use App\Events\FollowApprovedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class approveFollowRequest
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
     * @param  SendFollowApprovedEvent  $event
     * @return void
     */
    public function handle(FollowApprovedEvent $event)
    {
        \Auth::user()->approveFollowRequest($event->follower->id);
    }
}
