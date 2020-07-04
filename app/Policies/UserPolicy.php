<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function approveFollowRequest($user ,User $follower){
        
        return $follower->hasFollowRequest($user->id);
    }

    public function viewQuestions(User $user , User $userToView){

        return $user->isFollowing($userToView->id) ;
    }
}
