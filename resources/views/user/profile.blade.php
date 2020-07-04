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

        <button onclick="unfollowAjax()" id="unfollowBtn">  Unfollow {{$user->name}}  </button>

    @csrf
    <br><br>
    <div class="form-group">
        <label>Ask {{$user->name}} a question here</label>
        <textarea  class="form-control"  name = "question">

        </textarea>

        <div class="form-group">
            <button class="btn btn-success btn-submit">Send question</button>
        </div>
        <div id="sendQuestionResult"> </div>
    </div>
    <br>
    <div id = "questions">
    </div>

    <br><br><br><br><br><br><br><br><br>

    <script>

        var load = true ;
        var page = 1 ;

        $(document).ready(function() {

            $(".btn-submit").click(function(e){

                var q = $("textarea[name='question']").val();
                var _token = $("input[name='_token']").val();

                $.ajax({
                    url : '/askQuestion' ,
                    type: 'POST' ,
                    data : {_token : _token , question : q  , receiver_id : {{$user->id}} } ,
                    success : function(data) {
                        if(data['OK'])
                        {
                            $('#sendQuestionResult').text('Your question was sent to {{$user->name}}, When the question answered you will receiver a notification') ;
                        }

                    }

                });
            });

            $(window).scroll(function () {

                if (($(window).scrollTop() + $(window).height() > $(document).height() - 10) && load) {

                    var _token = $("input[name='_token']").val();
                    $.ajax({
                        url: '/questionsForUser',
                        type: 'GET',
                        data: {_token: _token, userId: {{$user->id}} , page: page++},
                        success: function (data) {
                            var res = '';
                            var questions = data;

                            for (i in questions) {
                                res += '<div id="' + questions[i]['id'] + '">';
                                res += '<h1>'+ questions[i]['created_at'] +'</h1>' ;
                                res += '<h5>' + questions[i]['question'] + '</h5>';
                                res += '<h6> sent by <a href = "/showProfile/' + questions[i]['sender']['id'] + '">' + questions[i]['sender']['name'] + '</a> </h6>';
                                res += '<p>' + questions[i]['answer']['answer'] + '</p>';
                                res += '<h6 id="likes' + questions[i]['id'] + '">' + questions[i]['liked_by_count'] + ' Like</h6>';
                                if(questions[i]['isLiked'] >= 1)
                                res += '<button id = "likeQuestion' + questions[i]['id'] + '" onclick="unlikeQuestion(' + questions[i]['id'] + ')"> <i class="material-icons">favorite</i> </button>';
                                else
                                res += '<button id = "likeQuestion' + questions[i]['id'] + '" onclick="likeQuestion(' + questions[i]['id'] + ')"> <i class="material-icons">favorite_border</i> </button>';
                                res += '<br><br><br><br>';
                                res += '</div>';

                            }

                            $("#questions").append(res);


                        }

                    });

                }


            });

        });

        function unfollowAjax() {
            var _token = $("input[name='_token']").val();
            $.ajax({
                url : '/unfollow' ,
                type: 'POST' ,
                data : {_token : _token , userId : {{$user->id}} }  ,
                success : function(data) {
                    if(data['OK'])
                    {
                        $(location).attr('href' , '/showProfile/{{$user->id}}')
                    }

                }
            });

        }

        function likeQuestion (id){

           //
            var _token = $("input[name='_token']").val();
            $.ajax({
                url : '/likeQuestion' ,
                type: 'POST' ,
                data : {_token : _token , questionId : id }  ,
                success : function(data) {
                    if(data['error'])
                        $('#'+id).hide();
                    if(data['OK'])
                    {
                        $('#likeQuestion'+id).html('<i class="material-icons">favorite</i>') ;
                        $('#likeQuestion'+id).attr('onclick' , 'unlikeQuestion('+ id +')') ;
                        $('#likes'+id).text(data['liked_by_count'] + 'Like');
                    }

                }
            });
        }

        function unlikeQuestion (id){

            //
            var _token = $("input[name='_token']").val();
            $.ajax({
                url : '/unlikeQuestion' ,
                type: 'POST' ,
                data : {_token : _token , questionId : id }  ,
                success : function(data) {
                    if(data['error'])
                        $('#'+id).hide();
                    if(data['OK'])
                    {
                        $('#likeQuestion'+id).html('<i class="material-icons">favorite_border</i>') ;
                        $('#likeQuestion'+id).attr('onclick' , 'likeQuestion('+ id +')') ;
                        $('#likes'+id).text(data['liked_by_count'] + 'Like');
                    }

                }
            });
        }



    </script>


@endsection
