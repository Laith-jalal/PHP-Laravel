<?php

namespace App\Listeners;

use App\Events\QuestionAnsweredEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteQuestionNotification
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
        $notification = \Auth::user()->unreadNotifications()
            ->where('type' , 'App\Notifications\QuestionNotification')
            ->where('data' , '=' , '{"question_id":'.$event->question->id.',"sender_id":'.$event->question->sender_id.'}')
            ->delete();

    }
}
