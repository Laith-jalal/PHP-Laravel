<?php

namespace App\Listeners;

use App\Events\FollowApprovedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteFollowRequestNotification
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
        \DB::table('notifications')->where('notifiable_id' , \Auth::id())
            ->where('type' , 'App\Notifications\SendFollowRequestNotification')
            ->where('notifiable_type' , 'App\User') ->where('data' , 'LIKE' , '%userId":'.$event->follower->id.'%')->delete() ;
    }
}
