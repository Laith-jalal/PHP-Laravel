@extends('layouts.app')
@section('content')
<table border = "2">
@foreach ($notifications as $notification)

        <tr>
            <td>
                <p> The user <a href="{{url('showProfile' , $notification->data['sender_id'])}}" >{{ (\App\User::find($notification->data['sender_id'])) -> name }}</a> </p>
                <strong> {{\App\Question::find($notification->data['question_id']) -> question  }} </strong>
            </td>
            <td>
                Date : {{\Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}
            </td>
            <td>
            <a href = "/answerQuestion/{{ $notification->data['question_id'] }}"> answer </a>
            </td>
        </tr>

@endforeach
</table>
@endsection