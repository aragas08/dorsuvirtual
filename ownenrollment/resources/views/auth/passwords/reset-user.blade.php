@extends('layouts.temp', ['title' => 'Reset'])

@section('content')
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
    </style>
    <div class="full-page col-12" data-color="black" data-image="{{asset('light-bootstrap/img/dorsu-background.jpg')}}">
        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        @if(!$reset)
                            <div class="card">
                                <div class="card-header">{{ __('Reset Password') }}</div>

                                <div class="card-body mv-left right">
                                    <form method="POST" action="{{ route('changeinfo') }}">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-md-4">Username:</label>
                                            <div class="col-md-8">
                                                <input type="text" name="username" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4">Enter old password:</label>
                                            <div class="col-md-8">
                                                <input type="password" name="old_password" class="form-control">
                                                <a type="button"><i class="fa showpass fa-eye-slash"></i></a>
                                                <span id="oldpass" class="error" hidden>Wrong password</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4">New password:</label>
                                            <div class="col-md-8 popup">
                                                <span class="popuptext" id="myPopup">Enter atleast 8 character with combination of special character.</span>
                                                <input type="password" name="new_password" id="newpass" class="form-control">
                                                <span class="error"></span>
                                                <a type="button"><i class="fa showpass fa-eye-slash"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4">Confirm password:</label>
                                            <div class="col-md-8">
                                                <input type="password" name="password_confirmation" id="confirm" class="form-control">
                                                <span id="cpspan" class="error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <div id="captcha"></div>
                                            </div>
                                            <div class="col-md-6 row pr-0 mv-3">
                                                <a id="refresh" type="button"><i id="refresh-icon" class="fa fa-refresh"></i></a>
                                                <div class="col pr-0">
                                                    <input type="text" placeholder="Enter captcha code" id="textBox" autocomplete="off" class="form-control">
                                                    <span></span>
                                                </div>
                                                
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
                            <script>
                                $(document).ready(function() {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    })
                                    $(".showpass").each(function(i){
                                        $(this).click(function(){
                                            const text = $(".form-control").eq(i);
                                            if(text.attr('type') == 'password'){
                                                text.attr('type','text');
                                                $(this).attr('class','fa showpass fa-eye');
                                            }else{
                                                text.attr('type','password');
                                                $(this).attr('class','fa showpass fa-eye-slash');
                                            }
                                        })
                                    })

                                    function matched(){
                                        var boo = true;
                                        if(bool){
                                            if($("#confirm").val() == $("#newpass").val()){
                                                $("#cpspan").html("Matched!");
                                                $("#cpspan").attr('class','success');
                                            }else{
                                                $("#cpspan").html("The confirmation password does not match!");
                                                $("#cpspan").attr('class','error');
                                                boo = false;
                                            }
                                        }
                                        return boo;
                                    }

                                    $("#confirm").keyup(function(){
                                        if($(this).val().length > 5){
                                            matched();
                                        }
                                    })

                                    $("#newpass").keyup(function(){
                                        password($(this));
                                    })
                                    function codeAnimated(text){
                                        const animate = `<svg xmlns="http://www.w3.org/2000/svg" style="text-align:center" shape-rendering="geometricPrecision" width="100%" height="70">
                                                <defs>
                                                    <style type="text/css">
                                                        @import url('https://fonts.googleapis.com/css?family=Oswald:600');

                                                        #svg_7 {
                                                            filter: url(#waterTexture);
                                                            font-size: 43px;
                                                            font-family: 'Oswald', sans-serif;
                                                        }

                                                    </style>

                                                    <filter id="waterTexture" >
                                                        <feTurbulence result="undulation" numOctaves="1" baseFrequency="0" seed="0" type="turbulence">

                                                            <animate attributeName="baseFrequency" dur="15s" keySplines="0.7 0 0.5 1; 0.7 0 0.5 1" keyTimes="0;0.5;1" calcMode="spline" values="0.01,0.011; 0.014,0.007; 0.007,0.009" repeatCount="indefinite"/>
                                                        
                                                        </feTurbulence>
                                                            <feColorMatrix 
                                                                in="undulation"
                                                                type="hueRotate"
                                                                values="180">
                                                                <animate
                                                                    attributeName="values"
                                                                    dur="1s"
                                                                    from="0"
                                                                    to="360"
                                                                    repeatCount="indefinite"/>
                                                            
                                                            </feColorMatrix>
                                                    <feColorMatrix in="dist" result="circulation" type="matrix" 
                                                                        values="4 1 4 0 1
                                                                                4 0 3 0 1
                                                                                4 0 0 0 1
                                                                                1 0 0 0 0   
                                                                                "/>
                                                <feDisplacementMap in="SourceGraphic" in2="circulation" scale="2" result="dist" />
                                                        <feDisplacementMap in="dist" in2="undulation" scale="30" result="woah" />
                                                    </filter>
                                                </defs>
                                                <g id="svg_7">
                                                    <g>
                                                        <text x="45%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="blue" transform="translateX(-100%)">`+text+`</text>
                                                    </g>
                                                </g>

                                            </svg>`;
                                            
                                        return animate;
                                    }

                                    function password(text){
                                        var boo = true;
                                        if(text.val().length < 8 || /^[a-zA-Z0-9- ]*$/.test(text.val()) == true){
                                            text.next().attr('class','error');
                                            text.next().html("Weak password!");
                                            boo = false;
                                        }else{
                                            text.next().html("");
                                        }
                                        return boo;
                                    }

                                    function svgToPng(svg, callback) {
                                        const url = getSvgUrl(svg);
                                        svgUrlToPng(url, (imgData) => {
                                            callback(imgData);
                                            URL.revokeObjectURL(url);
                                        });
                                    }
                                    function getSvgUrl(svg) {
                                        return  URL.createObjectURL(new Blob([svg], { type: 'image/svg+xml' }));
                                    }
                                    function svgUrlToPng(svgUrl, callback) {
                                        $img = '<img src="'+svgUrl+'" style="width: 100%">';
                                        $("#captcha").html($img);
                                    }

                                    function generateCode(){
                                        let alphaNums = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                                        let code = [];
                                        for (let i = 1; i <= 7; i++) {
                                        code.push(alphaNums[Math.floor(Math.random() * alphaNums.length)]);
                                        }
                                        var c = code.join('');
                                        svgToPng(codeAnimated(c),(imgData)=>{});
                                        return c;
                                    }

                                    var code = generateCode();
                                    $("#refresh").click(function(){
                                        $("#refresh-icon").attr("class",'fa fa-refresh fa-spin');
                                        setTimeout(function(){
                                            code = generateCode();
                                        $("#refresh-icon").attr("class",'fa fa-refresh');
                                        },3035)
                                    })

                                    function captcha(b){
                                        var output = $("#textBox").next();
                                        if(b){
                                            if ($("#textBox").val() === code) {
                                                output.attr('class','success');
                                                output.html("Correct!");
                                            } else {
                                                output.attr('class','error');
                                                output.html("Incorrect, please try again");
                                                b = false;
                                            }
                                        }
                                        return b;
                                    }
                                    var bool = false;

                                    $("#textBox").keyup(function(e){
                                        captcha(bool);
                                    })
                                    
                                    $("form").on('submit', function(event){
                                        event.preventDefault();
                                        bool = true;
                                        if(captcha(bool) && matched() && password($("#newpass"))){
                                            $.ajax({
                                                url: $(this).attr('action'),
                                                type: 'post',
                                                data: new FormData(this),
                                                contentType:false,
                                                cache: false,
                                                processData: false,
                                                datatype:JSON,
                                                success: function(result){
                                                    console.log(result);
                                                    if(!result.success){
                                                        $("#oldpass").prop('hidden',false);
                                                    }else{
                                                        location.reload();
                                                    }
                                                }
                                            })
                                        }
                                    })  

                                    $(".popup").click(function(){
                                        $("#myPopup").toggleClass("show");
                                    })
                                });
                            </script>
                        @else
                            <form action="{{ route('password.verify') }}" method="post">
                                @csrf
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h1>Enter Verification Code</h1>
                                        <p>The verification code will be send to {{Auth::user()->email}}</p>
                                        <input type="text" id="otp" name="otp" class="form-control">
                                        <button class="btn btn-warning mt-3" id="submit">Submit</button>
                                        <a id="rcode" type="button">Resend code</a>
                                    </div>
                                </div>
                            </form>
                            <script>
                                $(function(){
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    })
                                    $("form").submit(function(e){
                                        e.preventDefault();
                                        $.ajax({
                                            url: $(this).attr("action"),
                                            method: 'POST',
                                            data: new FormData(this),
                                            contentType: false,
                                            cache: false,
                                            dataType: 'json',
                                            processData: false,
                                            success: function(result) {
                                                if(result.success){
                                                    location.href = "{{route('choose')}}";
                                                }else{
                                                    $("#otp").css("border-color","red");
                                                }
                                            }
                                        })
                                    })
                                })
                            </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection