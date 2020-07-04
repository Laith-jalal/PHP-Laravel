@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id = 'questions'></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var page = 1 ;
    $(document).ready(function() {

        loadQuestions(page++);
    });

    $(window).scroll(function () {

        if (($(window).scrollTop() + $(window).height() > $(document).height() - 10)) {
            loadQuestions(page++);
        }
        });

        function loadQuestions(page){
        var _token = $("input[name='_token']").val();
        $.ajax({
            url: '/questions',
            type: 'GET',
            data: {_token: _token , page: page},
            success: function (data) {
              //  console.log(data['data'])
                var res = '';
                var questions = data['data'];

                for (i in questions) {
                    res += '<div id="' + questions[i]['id'] + '">';
                    res += '<h1>'+ questions[i]['created_at'] +'</h1>' ;
                    res += '<h5>' + questions[i]['question'] + '</h5>';
                    res += '<h6> sent by <a href = "/showProfile/' + questions[i]['sender']['id'] + '">' + questions[i]['sender']['name'] + '</a> </h6>';
                    res += '<h6> sent to <a href = "/showProfile/' + questions[i]['receiver']['id'] + '">' + questions[i]['receiver']['name'] + '</a> </h6>';
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

    /////////////////////////////

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
