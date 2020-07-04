<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    public static function getNumberOfNewNotification($user){

        $unreadNotifications = \DB::table('notifications')
            ->where('notifiable_type' , 'App\User')
            ->where('notifiable_id' , $user->id)
            ->whereNull('read_at'
            )->groupBy('type')
            ->selectRaw('type')
            ->selectRaw('count(*) as count')
            ->get();

       // return $unreadNotifications ;

        foreach ($unreadNotifications as $key => $value ){

            $index = strrpos($value->type , '\\');
            $value->type = substr($value->type , $index +1 ) ;
        }

        return $unreadNotifications ;

}

    public static function notificationsFactory($user , $pageSize , $type){


        return \DB::table('notifications')->where('notifiable_id' , $user->id)
            ->where('notifiable_type' , 'App\User')
            ->where('type' , 'App\\Notifications\\'.$type) -> latest() -> paginate($pageSize)  ;
    }

    public static function readApproveFollowRequestNotifications($userId){

        $user = \App\User::find($userId);
        $notifications = $user->unreadNotifications()->where('type' ,'App\Notifications\approveFollowRequestNotification')->get();
        foreach ($notifications as $notification)
            $notification->markAsRead();

    }

    public static function readQuestionLikedNotifications($userId){

        $user = \App\User::find($userId);
        $notifications = $user->unreadNotifications()->where('type' ,'App\Notifications\QuestionLikedNotification')->get();
        foreach ($notifications as $notification)
            $notification->markAsRead();
    }

    public static function readQuestionAnsweredNotifications($userId){
        $user = \App\User::find($userId);
        $notifications = $user->unreadNotifications()->where('type' ,'App\Notifications\QuestionAnsweredNotification')->get();
        foreach ($notifications as $notification)
            $notification->markAsRead();
    }

}
