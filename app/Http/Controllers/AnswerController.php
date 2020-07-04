<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use \App\Answer ;
use App\Events\QuestionAnsweredEvent;
use App\Events\AnswerLikedEvent ;

class AnswerController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $question = \App\Question::find($id) ;
        if(empty($question))
            abort(404) ;
        if(\Auth::user()->can('answer' , $question ))
            return view('question.answer' , ['question' => $question]) ;
        else
            abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnswerRequest $request)
    {
        $question = \App\Question::find($request->input('question_id'));
        if(empty($question))
            return response()->json(['error' => 'question NOT found'] , 403);

        if(\Auth::user()->can('answer' , $question)){

            event(new QuestionAnsweredEvent($question , new Answer(['answer' => $request->input('answer')]))) ;

            return response()->redirectTo('/notifications/QuestionNotification') ;
        }

        return response()->json(['error' => 'You are not authorized to answer'] , 403);
    }




}
