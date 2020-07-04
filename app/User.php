<?php

namespace App;
use DB;

use http\Env\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships

    public function likedAnswers(){

        return $this->belongsToMany('App\Question' , 'answer_likes' , 'user_id' , 'answer_id');
    }

    public function sentQuestions(){

        return $this->hasMany('App\Question' , 'sender_id');
    }

    public function receivedQuestions(){

        return $this->hasMany('App\Question' , 'receiver_id');
    }

    public function followers(){
        return $this->belongsToMany('App\User' , 'following_followers' , 'following_id' , 'follower_id');
    }

    public function followings(){
        return $this->belongsToMany('App\User' , 'following_followers' , 'follower_id' , 'following_id');
    }

    public function followRequestsSent(){
        return $this->belongsToMany('App\User' , 'send_follow_request' , 'follower_id' , 'following_id');
    }

    public function followRequestsReceived(){
        return $this->belongsToMany('App\User' , 'send_follow_request' , 'following_id' , 'follower_id');
    }


    public function getNameAttribute($value){
        $value[0] = strtoupper($value[0]);
        return $value;
    }


    public function isFollowing($id){

        return DB::table('following_followers')->where('follower_id' , $this->id)->where('following_id' , $id)->count() > 0 ;
    }

    public function hasFollowRequest($id){

        return count(DB::table('send_follow_request')->where('follower_id' , $this->id)->where('following_id' , $id)->get()) > 0 ;
    }

    public function sendFollowRequest($id){

        $this->followRequestsSent()->attach($id);

    }

    public function approveFollowRequest($followerId){


       $followRequest = DB::table('send_follow_request')->where('follower_id' , $followerId)
           ->where('following_id' , $this->id)
           ->get('id');
        if(!isset($followRequest[0]))
            return false;



        DB::beginTransaction();

        DB::table('send_follow_request')->where('id' , $followRequest[0]->id)->delete();
        $this->followers()->attach($followerId);

        DB::commit();
        return true ;

    }

    public function declineSentFollowRequest($userId){

        DB::table('notifications')->where('notifiable_id' , $userId)
            ->where('notifiable_type' , 'App\User') ->where('data' , 'LIKE' , '%userId":'.$this->id.'%')->delete() ;

        return DB::table('send_follow_request')->where('follower_id' , $this->id)
            ->where('following_id' , $userId)
            ->delete();
    }

    public function unfollow($userId){

        return DB::table('following_followers')->where('following_id' , $userId)
            ->where('follower_id' , $this->id)
            ->delete();

    }

    public static function searchUser($name ,$page , $limit = 5){

        $offset = ($page - 1 ) * $limit ;
        return DB::table('users')->where('name' , 'LIKE' , "%$name%")
            ->offset(0)
            ->limit(5)
            ->get(['id' , 'name']);

    }



}
