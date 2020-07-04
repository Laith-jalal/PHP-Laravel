<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question' , 'receiver_id'] ;

    //Relationships
    public function sender(){
        return $this->belongsTo('App\User' , 'sender_id');
    }

    public function receiver(){
        return $this->belongsTo('App\User' , 'receiver_id');
    }

    public function answer(){
        return $this->hasOne('App\Answer' ) ;
    }

    public function likedBy(){
        return $this->belongsToMany('App\User' , 'question_likes' );
    }


    public function like($userId){

        $this->likedBy()->attach($userId) ;
    }

    public function unlike($userId){

        $this->likedBy()->detach($userId) ;
    }
    public function isLikedByUser($userId){
        return \DB::table('question_likes')->where('question_id' , $this->id)->where('user_id' , $userId)->count();
    }


    public static function questionsForUser($userId){

       $questions = (self::where('receiver_id' , $userId)
           ->latest()
           ->has('answer')
           ->paginate(10));

       return $questions ;
    }

    public static function index($userId){

        $followingsDB = \DB::table('following_followers')
            ->where('follower_id' , $userId)
            ->get('following_id');

        $following = [] ;
        foreach ($followingsDB as $followingDB)
            $following[] = $followingDB->following_id ;


        $questions = (self::whereIn('receiver_id' , $following)
            ->latest()
            ->has('answer')
            ->paginate(10));

        return $questions ;
    }



}
