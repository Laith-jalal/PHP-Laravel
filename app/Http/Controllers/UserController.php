<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use \App\User ;
use App\Notifications\SendFollowRequestNotification;
use App\Events\SendFollowRequestEvent;
use App\Events\FollowApprovedEvent;
use App\Http\Resources\QuestionResource;

class UserController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\User::find($id);
        if(empty($user))
            abort(404);
        if(\Auth::user()->isFollowing($id)){


            return view('user.profile' , ['user' => $user]);
        }
        return view('user.notFollowingProfile' , ['user' => $user , 'hasFollowRequest' => \Auth::user()->hasFollowRequest($id)]);

    }


    public function searchUser(Request $request){

        $validator  = Validator::make($request->all() , [
            'name' => 'required' ,
            'page' => 'required|integer' ,
        ]);
        if($validator->fails())
            return response()->json(['error' => 'invalid data'] , '403');

        $result = User::searchUser($request->input('name') , $request->input('page'));
        return response()->json($result , '200');

    }

    public function sendFollowRequest(Request $request){
        $userId = $request->input('userId');
        $user = \App\User::find($userId) ;

        if(empty($user))
             return response()->json(['error' => 'user not found'] , '403');

        if(\Auth::user()->isFollowing($userId) || \Auth::user()->hasFollowRequest($userId))
            return response()->json(['error' => 'You are already following the user, or the follow request have been sent'] , '403');


        event( new SendFollowRequestEvent($user));

       return \response()->json(['OK' => true] , '200');

    }

    public function approveFollowRequest(Request $request){

        $userId = $request->input('userId');
        $follower = \App\User::find($userId);

        if( ! \Auth::user()->can('approveFollowRequest' , $follower))
            return \response()->json(['error' => 'No follow request '] , 403);


        event(new FollowApprovedEvent($follower));

        return \response()->json(['OK' => true] , '200');
    }

    public function unfollow(Request $request){

        $userId = $request->input('userId');
        if(\Auth::user()->isFollowing($userId))
        {
            \Auth::user()->unfollow($userId);
            return \response()->json(['OK' => true] , '200');
        }

        return  \response()->json(['error' => 'You are NOT following this user'] , 403);
    }

    public function declineSentFollowRequest(Request $request){

        if(\Auth::user()->hasFollowRequest($request->input('userId'))){

            \Auth::user()->declineSentFollowRequest($request->input('userId'));
            return \response()->json(['OK' => true] , '200');
        }

        return  \response()->json(['error' => 'There\'s NO follow request'] , 403);
    }

    public function declineReceivedFollowRequest(Request $request){

        $user = \App\User::find($request->input('userId'));
        if(empty($user))
            if(empty($user))
                return response()->json(['error' => 'user not found'] , '403');
        if ($user->hasFollowRequest(\Auth::id())){

            $user->declineSentFollowRequest(\Auth::id());
            return \response()->json(['OK' => true] , '200');
        }
        return  \response()->json(['error' => 'There\'s NO follow request'] , 403);

    }






}
