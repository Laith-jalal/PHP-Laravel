<?php

namespace App\Listeners;

use App\Events\QuestionAskedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\QuestionNotification ;

class sendQuestionNotification
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
     * @param  QuestionAskedEvent  $event
     * @return void
     */
    public function handle(QuestionAskedEvent $event)
    {

        \Notification::send($event->question->receiver , new QuestionNotification($event->question));
    }
}
