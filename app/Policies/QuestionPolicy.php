<?php

namespace App\Policies;

use App\User;
use App\Question;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function ask(User $user , Question $question){

        return $user->isFollowing($question->receiver_id) ;

    }

    public function answer(User $user , Question $question){

        if (($question->answer) )
            return false ;

        return $question->receiver_id === $user->id ;

    }

    public function like(User $user , Question $question){

        $receiverId = $question->receiver->id  ;

        $like = \DB::table('Question_likes')->where('user_id' , $user->id)->where('question_id' , $question->id)->count();
        if($like)
            return false ;
        if($user->isFollowing($receiverId))
            return true ;
        return false ;
    }

    public function unlike(User $user , Question $question){

        return $question->isLikedByUser($user->id) ;
    }

    public function see (User $user , Question $question){

        if( $question->receiver_id == $user->id) return true;
        return $user->isFollowing($question->receiver_id) ;

    }


}
