<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
        td  {
            padding :  0 20px 0 20px ;
        }
    </style>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
@csrf
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Question
                </a>

                <div>
                    <input name = 'search' placeholder = "search for user " oninput = "ajaxSearch()" id = "search">
                    <div id = "printDiv">  </div>

                </div>
                @if(\Auth::check())
                <div id = "notifications">
                <table>

                    <tr>
                        <td> <a href="/notifications/SendFollowRequestNotification"><i class="material-icons" style="color:#adadeb;font-size:50px" id="SendFollowRequestNotification">add</i> </a> </td>
                        <td><a href="/notifications/approveFollowRequestNotification"> <i class="material-icons" style="color:#adadeb;font-size:50px" id="approveFollowRequestNotification">check_circle</i> </a></td>
                        <td><a href="/notifications/QuestionLikedNotification"> <i class="material-icons" style="color:#adadeb;font-size:50px" id="QuestionLikedNotification">favorite</i> </a></td>
                        <td><a href="/notifications/QuestionNotification"> <i class="material-icons" style="color:#adadeb;font-size:50px" id ="QuestionNotification">question_answer</i></a> </td>
                        <td><a href="/notifications/QuestionAnsweredNotification"> <i class="material-icons" style="color:#adadeb;font-size:50px" id ="QuestionAnsweredNotification">record_voice_over</i></a> </td>
                    </tr>

                    <tr>
                        <td> <a href="/notifications/SendFollowRequestNotification"> Follow requests (<strong id="SendFollowRequestNotificationCount">0</strong>)</a></td>
                        <td><a href="/notifications/approveFollowRequestNotification"> Approved requests (<strong id="approveFollowRequestNotificationCount" >0</strong>) </a></td>
                        <td> <a href="/notifications/QuestionLikedNotification">Likes (<strong id = "QuestionLikedNotificationCount" >0</strong>)</a> </td>
                        <td><a href="/notifications/QuestionNotification"> Questions (<strong id ="QuestionNotificationCount" >0</strong>) </a></td>
                        <td><a href="/notifications/QuestionAnsweredNotification"> Answers Questions (<strong id ="QuestionAnsweredNotificationCount">0</strong>)</a></td>
                    </tr>
                </table>
                </div>
                @endif




                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script type="text/javascript">



    $(document).ready(function() {

        @if(\Auth::check())
        reloadNotifications();
        window.setInterval(function(){

            reloadNotifications();

        }, 5000);
        @endif

    }) ;

    function ajaxSearch(){
        var _token = $("input[name='_token']").val();
        var txt = $("input[name='search']").val();
        $.ajax({
            url : '/searchUser' ,
            type: 'POST' ,
            data : {_token : _token ,  name : txt , page : 1}  ,
            success : function(data) {

                var res = '<table border="1" width="160">' ;
                for (i in data){
                    res = res + '<tr><td> <a href="/showProfile/' + data[i]['id'] + '">'+ data[i]['name']+'</a></td> </tr>'

                }
                res = res+'</table>' ;
                document.getElementById('printDiv').innerHTML = res ;

            }
        });

    }

    function reloadNotifications(){
        var _token = $("input[name='_token']").val();
        $.ajax({
            url : '/newNotificationsStatus' ,
            type: 'get' ,
            data : {_token : _token ,}  ,
            success : function(data) {
                var notifications = {'SendFollowRequestNotification' : false , 'approveFollowRequestNotification'  : false , 'QuestionLikedNotification' : false, 'QuestionNotification' : false, 'QuestionAnsweredNotification' : false} ;
                for (i in data) {
                    $("#"+data[i]['type']).css('color' , '#3333cc');
                    $("#"+data[i]['type']+'Count').text(data[i]['count']);
                    notifications[data[i]['type']] = true ;
                }


                    for (i in notifications)
                    {
                        if(! notifications[i]){
                            $("#"+i).css('color' , '#adadeb');
                            $("#"+i+'Count').text('0');
                        }

                    }
            }

        });
    }




</script>
</html>
