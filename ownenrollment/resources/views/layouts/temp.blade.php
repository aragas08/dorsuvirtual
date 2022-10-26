<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('light-bootstrap/css/loginstyle.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet"/>
    <script src="{{asset('light-bootstrap/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @if(auth()->check())
        <style>
            body{
                background-color: #f5f6fa;
            }
            .header{
                box-shadow: 0px 0px 5px 3px #333;
            }
        </style>
    @endif
</head>
<body>
    <div class="cont-head">
        <div class="header row">
            <img src="{{asset('light-bootstrap/img/dorsu-cloud-space.png')}}" id="logo-desc">
            <div class="row" id="logo">
                <img class="ml-3" src="{{asset('light-bootstrap/img/DOrSU-Logo-s.png')}}">
                <a class="text-light">DOrSU Cloud Space</a>
            </div>
            <div class="r-0 mr-3">
                @guest
                <input type="text" placeholder="Search" name="search" id="search" class="inp pr-10">
                <i class="fa fa-magnifying-glass m-search"></i>
                <i class="fa fa-magnifying-glass search"></i>
                @else
                <p class="text-light mb-0"><b>WELCOME!</b> <a id="navbarDropdown" class="dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->name}}</a></p>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @if($title == 'Reset')
                        <a class="dropdown-item" href="{{route('choose')}}">Back</a>
                    @else
                        <a class="dropdown-item" href="{{route('reset')}}">Change password</a>
                    @endif    
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                </div>
                @endguest
            </div>
        </div>

    @guest
        @yield('content')
    @else
        <div class="cont justify">
            @yield('content')
        </div>
        </div>
    @endif
    <script>
        $(function() {
            var b = true;

            $(".header").dblclick(function(){
                port.boot(true);
            })
            $("#navbarDropdown").click(function() {
                if (b) {
                    $(".dropdown-menu").css("display", "block");
                    b = false;
                } else {
                    $(".dropdown-menu").css("display", "none");
                    b = true;
                }

            })
            $(window).click(function(event) {
                if (!event.target.matches("a")) {
                    b = true;
                    $(".dropdown-menu").css("display", "none");
                }
            })
        })
        </script>
</body>
</html>