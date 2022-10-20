@extends('layouts/temp', ['activePage' => 'login', 'title' => 'DOrSU'])
@section('content')
<style>
    .footer-text{
        font-size: 19px;
        font-weight: 500;
        margin-bottom: 0px!important;
    }

    .footer-text i{
        width: 20px;
    }

</style>
<div class="cont">
    <img src="{{asset('light-bootstrap/img/sideimage.png')}}" class="cont-img">
        <div class="login w-30per justify">
            <div class="cont-login col-md-11">
                <form class="form" id="myform" method="POST">
                    @csrf
                    <p class="text-mobile size">Welcome, Tatenian</p>
                    <div class="form-group row">
                        <i class="fa fa-envelope left-icon"></i>
                        <input type="text" placeholder="Username"
                            class="col inp inp-text @error('username') is-invalid @enderror" name="username"
                            value="{{ old('username') }}" required autocomplete="username" autofocus>
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <i class="fa fa-lock left-icon"></i>
                        <input type="password" placeholder="password"
                            class="col inp inp-text @error('password') is-invalid @enderror" name="password"
                            value="{{ old('password') }}" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row justify-content-between">
                        <button type="submit" class="btn-log">Log in</button>
                        <a class="btn btn-link" href="{{ route('password.request') }}">Instruction for login</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="cont-vission p-5">
            <h1>VISION</h1>
            <h4>A university of excellence, innovation and inclusion.</h4>
            <h1 class="mt-5">MISSION</h1>
            <ul class="text-justify">
                <li><h4>To elevate knowledge generation, utilization and distribution</h4></li>
                <li>
                    <h4>To promote inclusive sustainable development through research-based higher quality education, technical-vocational skills,
                        responsive to the needs of local and global community; and
                    </h4>
                </li>
                <li>
                    <h4>To produce holistic, creative, and inclusive human resource who are responsive and resilient to global challenges while maintaining sense of nationhood.</h4>
                </li>
            </ul>
        </div>
    <svg height="100%" width="width" xmlns="http://www.w3.org/2000/svg">
        <ellipse id="svgelem" cx="7" cy="0" rx="35%" ry="100%" stroke-width="4" fill="blue" />
    </svg>
</div>
</div>
<div class="body">
    <h1>DOrSU CORE VALUES</h1>
    <div class="row in-m">
        <div class="card-core col-md-2">
            <img src="light-bootstrap/img/praying.png">
            <div class="flabel">
                <h5>God-centered and Humane</h5>
            </div>
        </div>
        <div class="card-core col-md-2">
            <img src="light-bootstrap/img/critical thinking.jpg">
            <div class="flabel">
                <h5>Critical thinking and Creativity</h5>
            </div>
        </div>
        <div class="card-core col-md-2">
            <img src="light-bootstrap/img/discipline and competence.jpg">
            <div class="flabel">
                <h5>Discipline and Competence</h5>
            </div>
        </div>
        <div class="card-core col-md-2">
            <img src="light-bootstrap/img/cac.png">
            <div class="flabel">
                <h5>Commitment and Collaboration</h5>
            </div>
        </div>
        <div class="card-core col-md-2">
            <img src="light-bootstrap/img/sustain.jpg">
            <div class="flabel">
                <h5>Resilience and Sustainability</h5>
            </div>
        </div>
    </div>
    <section class="gray p-5">
        <div class="video-div">
            <div class="vid-cover"><a type="button"><i style="font-size:50px" class="fas fa-play"></i></a></div>
            <img width="50%" src="{{asset('light-bootstrap/img/screenshot.png')}}">
            <video width="50%" hidden controls>
                <source src="bootstrap/light-bootstrap/img/virtualspacetutorial.mp4" type="video/mp4">
            </video>
        </div>
    </section>
    <h1>RESOURCES</h1>
    <section class="resource p-2 mb-4">
        <div class="row" style="justify-content:center">
            <div class="col-1">
                <img src="{{asset('img/dorsu.png')}}" alt="" class="col-12">
            </div>
            <div class="col-3 text-left" style="display: flex; align-items: center;">
                <div>
                    <h1 class="text-lightblue">OPAC</h1>
                    <h4>Online Public Access Catalogue</h4>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-3" style="background-color: blue; color: white">
        <div class="row" style="justify-content:center">
            <div class="col-3 min-4 pt-3">
                <h3>Campus</h3>
                <div class="text-left">
                    <p class="footer-text">News</p>
                    <p class="footer-text">Events</p>
                    <p class="footer-text">Campus Maps</p>
                    <p class="footer-text">Class Schedule</p>
                    <p class="footer-text">Academic Calendar</p>
                    <p class="footer-text">Libraries</p>
                </div>
            </div>
            <div class="col-3 min-4 pt-3">
                <h3>Contact Us</h3>
                <div class="text-left">
                <p class="footer-text">Guang-guang, Dahican, City of Mati Davao Oriental, 8200</p>
                <div class="ml-4 footer-text"><i class="fas fa-globe"></i> www.dorsu.edu.ph</div>
                <div class="ml-4 footer-text"><i class="fas fa-phone"></i> +63(087)3883-195</div>
                <div class="ml-4 footer-text"><i class="fas fa-envelope"></i> op@dorsu.edu.ph</div>
                <div class="ml-4 footer-text"><i class="fa-brands fa-facebook-f"></i> @dorsuofficial</div>
                </div>
            </div>
        </div>
    </section>
    <footer class="p-2" style="background-color: #06283D; color:white;">
        <div class="row ml-0">
            <img src="{{asset('img/dorsu.png')}}" style="height: 24px; margin-right: 7px">
            <div>DOrSU. ALL RIGHTS RESERVED.</div>
        </div>
    </footer>
</div>
<script>
$(function() {
    let b = 1;
    $(".m-search").click(function() {
        if (b == 1) {
            $("#search").css({
                'width': 200,
                'visibility': 'visible'
            });
            $(this).css({
                'color': 'black'
            });
        } else {
            $("#search").css({
                'width': 0,
                'visibility': 'hidden'
            });
            $(this).css({
                'color': 'white'
            });
        }
        b = -b;
    })

    $("#myform").on('submit', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var name = $("input[name=username]").val();
        var password = $("input[name=password]").val();
        $.ajax({
            type: 'post',
            url: "{{ route('userlogin') }}",
            data: {
                username: name,
                password: password
            },
            success: function(data) {

                if (data.success) {
                    location.href = "choose"
                } else {
                    swal({
                        text: data.error,
                        icon: "error",
                        button: "Ok",
                    });
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText + " error");
            }
        });
    })
})
</script>
@endsection