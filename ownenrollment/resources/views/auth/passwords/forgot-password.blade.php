<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot password</title>
    <link rel="stylesheet" href="{{ asset('light-bootstrap/css/passwordstyle.css') }}">
    <script src="{{asset('light-bootstrap/js/core/jquery.3.2.1.min.js')}}"></script>
  </head>
<body>
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center
            min-vh-100">
            <div class="card width">
                <div class="text-center">
                  <div class="card-body">
                    <a type="button" id="question"><i class="fa fa-question"></i></a>
                    <h3><i class="fa fa-lock fa-4x"></i></h3>
                    <h2 class="text-center">Forgot Password?</h2>
                    <p>Enter your email address and we will send you a password reset link.</p>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('password.email') }}" method="post">
                      @csrf
                      <div class="form-group">
                        <div class="input-group has-validation">
                          <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                          <input id="email" value="{{ old('email') }}" name="email" autofocus placeholder="email address" class="form-control @error('email') is-invalid @enderror" type="email">
                          @error('email')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group">
                        <input name="recover-submit" class="btn btn-warning mt-3" style="width: 100%;" value="Send Password Reset Link" type="submit">
                      </div>
                      
                      <input type="hidden" class="hide" name="token" id="token" value=""> 
                    </form>
      
                  </div>
                </div>
            </div>
        </div>
      </div>

      
    <div class="modal display">
        <div class="wrap">
            <div class="modal-content show">
                <div class="card">
                  <div class="card-header justify">
                    <h3>Instruction for the student users</h3>
                    <span class="close">&times;</span>
                  </div>
                  <div class="card-body">
                    
                    <p style="font-weight: 600">Username is a combination of the following:</p>
                    <img class="wp-image-3076 alignnone" src="https://dorsu.edu.ph/wp-content/uploads/2022/08/user-300x143.png" alt="" width="313" height="149" />
                    <ol type="A">
                      <li>2<sup>nd</sup> group of characters or numbers of your ID number after the ‘-‘</li>
                      <li>1<sup>st</sup> letter of your firstname in UPPERCASE</li>
                      <li>1<sup>st</sup> letter of your lastname in UPPERCASE</li>
                      <li>A one or two (2) digit(s) number that corresponds to the total count of all characters of your
                    firstname, lastname, and extension name EXCLUDING space characters</li>
                      <li>1<sup>st</sup> group of characters or numbers of your ID number</li>
                    </ol>
                    <div style="overflow-y: auto;">
                        <table class="table-striped">
                          <thead>
                            <tr>
                              <th>Student IDNo.</th>
                              <th>FirstName</th>
                              <th>Lastname</th>
                              <th>Extension Name</th>
                              <th>USERNAME</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                            <td>MA12-999x
                            </td>
                            <td>Juan
                            </td>
                            <td>Tamad
                            </td>
                            <td>Jr
                            </td>
                            <td>999xJT11MA12
                            </td>
                          </tr>
                          <tr>
                            <td>2090-0054
                            </td>
                            <td>Juana
                            </td>
                            <td>Bones
                            </td>
                            <td>
                            </td>
                            <td>0054JB102090
                            </td>
                          </tr>
                          </tbody>
                        </table>
                    </div>  
                    
                    &nbsp;
                    <p style="font-weight: 600">Pass Phrase/password is a combination of the following:</p>
                    <img class="alignnone size-medium wp-image-3078" src="https://dorsu.edu.ph/wp-content/uploads/2022/08/pass-2-300x134.png" alt="" width="300" height="134" />
      
                    &nbsp;
                    <ol start="F" type="A">
                      <li>One (1) or two (2) digits whole number that is equivalent of your birth month.
                      If birth month is January, then the value is 1,
                      if birth month is December, then the value is 12.</li>
                      <li>1<sup>st</sup> letter of your firstname in UPPERCASE</li>
                      <li>1<sup>st</sup> letter of your lastname in UPPERCASE</li>
                      <li>I.	A one (1) or two (2) digits total count of all VOWELS in your
                      firstname, lastname and extension name. EXCLUDED are the middle initial 
                      and space characters.
                      </li>
                      <li>J.	A one(1) or two (2) digits total count of all CONSONANTS in your 
                      firstname and lastname. EXCLUDED are the middle initial 
                      and space characters.
                      </li>
                    </ol>
                    <div style="overflow-y: auto;">
                        <table class="table-striped">
                          <thead>
                            <tr>
                              <th>FirstName</th>
                              <th>Lastname</th>
                              <th>Extension Name</th>
                              <th>BirthMonth</th>
                              <th>PASSWORD</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                            <td>Juan
                            </td>
                            <td>Tamad
                            </td>
                            <td>Jr
                            </td>
                            <td>January
                            </td>
                            <td>1JT@ra11033(4-7)
                            </td>
                          </tr>
                          <tr>
                            <td>Juana
                            </td>
                            <td>Bones
                            </td>
                            <td>
                            </td>
                            <td>December
                            </td>
                            <td>12JB@ra11033(5-5)
                            </td>
                          </tr>
                          </tbody>
                        </table>  
                    </div>
                    There should be no spaces in your username and password respectively.
                  </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(function(){

          $("#question").click(function(){
            $(".modal").show();
            $(".modal-content").attr('class',"modal-content show");
          })
          if(!sessionStorage.getItem('show')){
            setTimeout(()=>{
              $(".modal").show();
            }, 500);
            sessionStorage.setItem('show', true);
          }

          $(".close").click(function(){
            $(".modal-content").attr('class',"modal-content hide");
            $(".modal").attr('class',"modal hidestyle");
            setTimeout(() => {
              $(".modal").hide();
            }, 1950);
          });
        })
        
      </script>
</body>
</html>