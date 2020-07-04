@extends('layouts.app')

@section('content')

    <h4> sent by <a href="/showProfile/{{$question->sender->id}}">{{$question->sender->name}} </a></h4>
    <h5> at : {{\Carbon\Carbon::parse($question->created_at)->diffForHumans()}} </h5>
    <h3> question : {{$question->question}} </h3>
    <h2> answer : {{$question->answer->answer}}</h2>

@endsection