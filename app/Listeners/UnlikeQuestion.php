<?php

namespace App\Listeners;

use App\Events\QuestionUnlikedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnlikeQuestion
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
     * @param  QuestionUnlikedEvent  $event
     * @return void
     */
    public function handle(QuestionUnlikedEvent $event)
    {
        $event->question->unlike(\Auth::id());
    }
}
