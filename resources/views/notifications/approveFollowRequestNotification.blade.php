@extends('layouts.app')
@section('content')

    <table border="2">
    @foreach($notifications as $notification)
            <tr>
                <td> The user <a href="{{url('showProfile' , $notification->data['userId'])}}" >{{ (\App\User::find($notification->data['userId'])) -> name }} </a> has
                    approved your follow request</td>
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
                url : '/readApproveFollowRequestNotifications' ,
                type: 'POST' ,
                data : {_token : _token }  ,
                success : function(data) {
                    reloadNotifications()
                }


                });
        });
    </script>
@endsection