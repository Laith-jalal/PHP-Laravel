<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\SendFollowRequestEvent' => [
            'App\Listeners\SendFollowRequest' ,
            'App\Listeners\SendFollowNotification' ,

        ],

        'App\Events\FollowApprovedEvent' => [
            'App\Listeners\approveFollowRequest' ,
            'App\Listeners\sendApproveFollowRequestNotification' ,
            'App\Listeners\DeleteFollowRequestNotification' ,

        ],

        'App\Events\QuestionAskedEvent' => [
            'App\Listeners\addQuestion' ,
            'App\Listeners\sendQuestionNotification' ,

        ],

        'App\Events\QuestionAnsweredEvent' => [
            'App\Listeners\addAnswer' ,
            'App\Listeners\sendAnswerNotification' ,
            'App\Listeners\DeleteQuestionNotification' ,

        ],

        'App\Events\QuestionLikedEvent' => [
            'App\Listeners\LikeQuestion' ,
            'App\Listeners\SendQuestionLikedNotification' ,

        ],

        'App\Events\QuestionUnlikedEvent' => [
            'App\Listeners\UnlikeQuestion' ,
            'App\Listeners\DeleteQuestionLikedNotification' ,

        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
