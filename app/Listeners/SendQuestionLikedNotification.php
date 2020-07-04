<?php

namespace App\Listeners;

use App\Events\QuestionLikedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\QuestionLikedNotification ;

class SendQuestionLikedNotification
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
        \Notification::send($event->question->receiver , new QuestionLikedNotification(\Auth::user() , $event->question));
    }
}
