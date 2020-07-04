<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;
use App\Question ;
use  App\Events\QuestionAskedEvent ;
use App\User ;
use App\Policies\UserPolicy;
use App\Events\QuestionLikedEvent ;
use App\Http\Resources\QuestionResource;
use App\Events\QuestionUnlikedEvent ;
class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  QuestionResource::collection(Question::index(\Auth::id()));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $question = new Question(
            ['question' => $request->input('question') ,
            'receiver_id' => $request->input('receiver_id')
        ]);

        if(\Auth::user()->can('ask' , $question)){

           event( new QuestionAskedEvent($question));

           return response()->json(['OK' => true] , 200);
        }
        return response()->json(['error' => 'You are NOT following this user'] , 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = \App\Question::find($id);
        if(empty($question))
            abort(404) ;

        if( \Auth::user()->can('see' , $question))
            return view('question.showQuestion' , ['question' => $question]) ;
        else
            abort(404);

    }


    public function questionsForUser(Request $request){

        $user = \App\User::find($request->input('userId')) ;
        if(empty($user))
            return response()->json(['error' => 'user NOT found']) ;
        if(\Auth::user()->can('viewQuestions' , $user)){

            $questions =  \App\Question::questionsForUser($request->input('userId'));
            return response(QuestionResource::collection($questions) , 200);
        }
        return response()->json(['error' => 'you are not following this user'] , 403) ;
    }

    public function like (Request $request){

        $question = \App\Question::find($request->input('questionId'));
        if(empty($question))
            return response()->json(['error' => 'NO question exist'] ) ;

        if(\Auth::user()->can('like' , $question)){

            event( new QuestionLikedEvent ($question));
            return response()->json(['OK' => true , 'liked_by_count' =>  $question->likedBy()->count()] , 200) ;
        }

        return response()->json(['error' => 'You are NOT authorized to like'] , 403) ;

    }

    public function unlike (Request $request){

        $question = \App\Question::find($request->input('questionId'));
        if(empty($question))
            return response()->json(['error' => 'NO question exist'] ) ;

        if(\Auth::user()->can('unlike' , $question)){

            event( new QuestionUnlikedEvent ($question));
            return response()->json(['OK' => true , 'liked_by_count' =>  $question->likedBy()->count()] , 200) ;
        }

        return response()->json(['error' => 'You are NOT authorized to like'] , 403) ;

    }



}
