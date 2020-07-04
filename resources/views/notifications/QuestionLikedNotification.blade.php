@extends('layouts.app')

@section('content')
    <table border="2">
        @foreach($notifications as $notification)
            <tr>
                <td> The user <a href="{{url('showProfile' , $notification->data['user_id'])}}" >{{ (\App\User::find($notification->data['user_id'])) -> name }} </a>
                    liked your question <strong> {{ substr( \App\Question::find($notification->data['question_id'])->question , 0 , 10) }} </strong>
                    <a href = "/showQuestion/{{$notification->data['question_id']}}"> see question </a>
                </td>
                <td>
                    Date : {{\Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}
                </td>
            </tr>
        @endforeach
    </table>
    {{$notifications -> links()}}

    <script>
        $(window).ready(function(){

            var _token = $("input[name='_token']").val();
            $.ajax({
                url : '/readQuestionLikedNotifications' ,
                type: 'POST' ,
                data : {_token : _token }  ,
                success : function(data) {
                    reloadNotifications()
                }


            });
        });
    </script>

@endsection