@extends('layouts.app')
@section('content')
    <table border = "2">

        @foreach($notifications as $notification)

            <tr>

                <td>
                    The user <a href = {{url('/showProfile' , $notification->data['user_id'])}}> {{ (\App\User::find($notification->data['user_id'])) -> name }} </a>
                    has answered <a href="{{url('showQuestion' , $notification->data['question_id'])}}"> you question </a>
                </td>
                <td>
                    at : {{\Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}
                </td>
            </tr>

        @endforeach

    </table>

    <script>
        $(window).ready(function(){

            var _token = $("input[name='_token']").val();
            $.ajax({
                url : '/readQuestionAnsweredNotifications' ,
                type: 'POST' ,
                data : {_token : _token }  ,
                success : function(data) {
                    reloadNotifications()
                }


            });
        });
    </script>

@endsection