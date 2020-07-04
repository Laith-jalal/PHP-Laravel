<?php

namespace App\Listeners;

use App\Events\FollowApprovedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\approveFollowRequestNotification;

class sendApproveFollowRequestNotification
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
     * @param  FollowApprovedEvent  $event
     * @return void
     */
    public function handle(FollowApprovedEvent $event)
    {
        \Notification::send($event->follower , new approveFollowRequestNotification(\Auth::user() ) );
    }
}
