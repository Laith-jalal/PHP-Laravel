<?php

namespace App\Listeners;

use App\Events\QuestionAnsweredEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class addAnswer
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
     * @param  QuestionAnsweredEvent  $event
     * @return void
     */
    public function handle(QuestionAnsweredEvent $event)
    {
       $event->question->answer()->save($event->answer) ;
    }
}
