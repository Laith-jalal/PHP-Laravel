@extends('layouts.app')
@section('content')
    <h3> Question : </h3>
    <h5> from {{$question->sender->name}} </h5>
    <p> {{$question->question}} </p>


    <form action = "/answerQuestion" method = "POST">
        @csrf

        <input type="hidden" name = "question_id" value = "{{$question->id}}">
        <label>Write your answer here</label>
        <textarea  class="form-control"  name = "answer">

        </textarea>

        <div class="form-group">
            <input type = "submit" value ="send answer">
        </div>

    </form>
@endsection