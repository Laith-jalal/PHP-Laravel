<?php

namespace App\Listeners;
use App\Notifications\SendFollowRequestNotification;
use App\Events\SendFollowRequestEvent;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFollowNotification
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
       \ Notification::send($event->user , new SendFollowRequestNotification(\Auth::user()) );
    }
}
