@extends('layouts.app')

@section('content')

    <h4> Follower : {{@count($user->followers)}} </h4>
    <h4> Following : {{@count($user->followings)}} </h4>
    <h4> Sent questions : {{@count($user->sentQuestions)}} </h4>
    <h4> Received questions : {{@count($user->receivedQuestions)}} </h4>
    <h2>
        {{$user->name}}
    </h2>

    <h6> email : {{$user->email}} </h6>

    @if($hasFollowRequest)
     <button onclick="cancelFollowAjax()" id="followBtn">  cancel follow request  </button>
    @else
    <button onclick="followAjax()" id="followBtn">  Follow {{$user->name}}  </button>
    @endif
    @csrf
    <br><br><br>
    <h5> Follow {{$user->name}} to see his/her questions and answers </h5>
    <script>


        function followAjax() {
            var _token = $("input[name='_token']").val();
            $.ajax({
                url : '/sendFollowRequest' ,
                type: 'POST' ,
                data : {_token : _token , userId : {{$user->id}} }  ,
                success : function(data) {
                    if(data['OK'])
                    {
                     //<p id = "followBtnTxt">
                        $("#followBtn").attr('onclick' , 'cancelFollowAjax()');
                        $("#followBtn").text('cancel follow request');
                    }

                }
            });

        }

        function cancelFollowAjax () {
            var _token = $("input[name='_token']").val();
            $.ajax({
                url : '/declineSentFollowRequest' ,
                type: 'POST' ,
                data : {_token : _token , userId : {{$user->id}} }  ,
                success : function(data) {
                    if(data['OK'])
                    {
                        $("#followBtn").attr('onclick' , 'followAjax()');
                        $("#followBtn").text(' Follow {{$user->name}}');
                    }

                }
            });
        }

    </script>

@endsection
