<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet"/>
    <link href="{{ asset('light-bootstrap/css/webapp.css') }}" rel="stylesheet"/>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="float-left">
                <img src="{{asset('light-bootstrap/img/dorsu-cloud-space.png')}}" class="logo">
            </div>
            <div class="float-right">
                <input type="text" name="" placeholder="Search" id="">
            </div>
        </div>
    </div>
    <div class="container pt-5">
        @yield('content')
    </div>
</body>
</html>