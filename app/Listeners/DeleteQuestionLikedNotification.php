<?php

namespace App\Listeners;

use App\Events\QuestionUnlikedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteQuestionLikedNotification
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
        \DB::table('notifications')->where('notifiable_id' , $event->question->receiver_id)
            ->where('type' , 'App\Notifications\QuestionLikedNotification')
            ->where('notifiable_type' , 'App\User')
            ->where('data' , 'LIKE' , '%user_id":'.\Auth::id().'%')
            ->where('data' , 'LIKE' , '%question_id":'.$event->question->id.'%')
            ->delete() ;
    }
}
