<?php

namespace App\Listeners;

use App\Events\QuestionAnsweredEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\QuestionAnsweredNotification;

class sendAnswerNotification
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
        \Notification::send($event->question->sender , new QuestionAnsweredNotification($event->question));
    }
}
