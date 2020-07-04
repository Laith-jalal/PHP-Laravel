<?php

namespace App\Listeners;

use App\Events\QuestionLikedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LikeQuestion
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
     * @param  QuestionLikedEvent  $event
     * @return void
     */
    public function handle(QuestionLikedEvent $event)
    {
        $event->question->like(\Auth::id()) ;
    }
}
