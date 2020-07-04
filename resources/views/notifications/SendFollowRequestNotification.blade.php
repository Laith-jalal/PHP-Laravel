@extends('layouts.app')

@section('content')
@csrf
    <table border = "1">
    @foreach( $notifications as $notification)
        <tr>
           <td> The user <a href="{{url('showProfile' , $notification->data['userId'])}}" >{{ (\App\User::find($notification->data['userId'])) -> name }} </a>
           Asked to follow you
           </td>
            <td>
                Date : {{\Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}
            </td>
            <td> <a onclick="declineReceivedFollowRequest({{$notification->data['userId']}})" href="#"><i class="material-icons"> cancel </i> </a></td>
            <td> <a onclick="approveFollowRequest({{$notification->data['userId']}})" href="#"> <i class="material-icons"> check_circle </i></a> </td>
        </tr>
    @endforeach
    </table>
    {{$notifications -> links()}}

    <script>

        function declineReceivedFollowRequest(userId) {

            var _token = $("input[name='_token']").val();
            $.ajax({
                url : '/declineReceivedFollowRequest' ,
                type: 'POST' ,
                data : {_token : _token , userId : userId }  ,
                success : function(data) {
                    location.reload();
                }
            });

        }

        function approveFollowRequest(userId){

            var _token = $("input[name='_token']").val();
            $.ajax({
                url : '/approveFollowRequest' ,
                type: 'POST' ,
                data : {_token : _token , userId : userId }  ,
                success : function(data) {
                    location.reload() ;
                }
            });
        }

    </script>

@endsection