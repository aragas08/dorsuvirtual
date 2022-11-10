<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('light-bootstrap/css/loginstyle.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet"/>
    <script src="{{asset('light-bootstrap/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        .card-title>img{
            height: 55px;
        }

        #captcha{
            height: 70px;
            background-color: antiquewhite;
            border-radius: 4px;
        }

        .right{
            text-align: right;
        }

        #refresh{
            margin: 5px 10px;
        }

        .error{
            color: red;
        }

        .success{
            color: #0eea0e;
        }

        .popup {
            position: relative;
            display: inline-block;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .popup .popuptext {
            visibility: hidden;
            background-color: #555;
            width: 50%;
            min-width: 100px;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -80px;
        }

        .popup .popuptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .popup .show {
            visibility: visible;
            -webkit-animation: fadeIn 1s;
            animation: fadeIn 1s;
        }

        @-webkit-keyframes fadeIn {
            from {opacity: 0;} 
            to {opacity: 1;}
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity:1 ;}
        }

        .col-md-8>a{
            position: absolute;
            top: 7px;
            right: 17px;
        }

        #rcode{
            position: absolute;
            left: 30px;
            margin-top: 10px;
            opacity: 0.77;
        }

        .full-page{
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-group{
            margin-top: 15px;
        }
        body{
            background-color: #f5f6fa;
        }
    </style>
</head>
<body>
    <div class="full-page col-12">
                    <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">{{ __('Reset Password') }}</div>
                                <div class="card-body mv-left right">
                                    <form method="POST" action="{{ route('password.update') }}">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <input type="email" hidden name="email" value="{{ $email ?? old('email') }}">
                                        <div class="form-group row">
                                            <label class="col-md-4">New password:</label>
                                            <div class="col-md-8 popup">
                                                <input type="password" name="password" id="newpass" class="form-control @error('password') is-invalid @enderror">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4">Confirm password:</label>
                                            <div class="col-md-8">
                                                <input type="password" name="password_confirmation" id="confirm" class="form-control">
                                                <span id="cpspan" class="error"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0 justify-content-center">
                                                <button type="submit" class="btn btn-warning">
                                                    {{ __('Reset Password') }}
                                                </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                    </div>
    </div>
</body>
</html>

 