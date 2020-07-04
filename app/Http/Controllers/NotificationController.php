<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notification;

class NotificationController extends Controller
{
    public function getNumberOfNewNotification(){

       return notification::getNumberOfNewNotification(\Auth::user()) ;
    }

    public function notificationsPageFactory($type){

        $pageSize = 10 ;
        $notifications = notification::notificationsFactory(\Auth::user() , $pageSize , $type) ;

        foreach ($notifications as $notification)
            $notification->data = json_decode($notification->data , true) ;

        return view('notifications.'.$type , ['notifications' => $notifications]);
    }

    public function readApproveFollowRequestNotifications(){
        notification::readApproveFollowRequestNotifications(\Auth::id());
    }

    public function  readQuestionLikedNotifications(){
        notification::readQuestionLikedNotifications(\Auth::id());
    }

    public function readQuestionAnsweredNotifications(){
        notification::readQuestionAnsweredNotifications(\Auth::id());
    }
}
