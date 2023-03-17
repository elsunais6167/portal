<!DOCTYPE html>
<html lang="en">
    
@if(! request()->uid )
<?php //echo "<script> window.location.href = 'http://app.schoolportal360.local/' </script>" ; ?>
@endif

<head>
    <title> Verify Account Login </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name='description' content="School Portal 360 ( Sp360 ) classroom - Best Nigeria School management system and Online classroom portal">
    <meta name='keyword' content="sp360 Classroom, Nigeria Online Classroom portal for schools ">
    <!--===============================================================================================-->
    <link rel="shortcut icon" href="{{asset('dist/img/logo.jpg')}}" sizes='any' type="image/x-icon">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/vendor/bootstrap/css/bootstrap.min.css ')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/fonts/font-awesome-4.7.0/css/font-awesome.min.css ')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/fonts/iconic/css/material-design-iconic-font.min.css ')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/vendor/animate/animate.css ')}}">
    <!--==============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/vendor/animsition/css/animsition.min.css ')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/vendor/select2/select2.min.css ')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('login/css/util.css ')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('login/css/main.css ')}}">
    <!--===============================================================================================-->
</head>

<style>
    .hide { display: none;}
    body{ zoom:85%;}
</style>

<body oncontextmenu="return " class='bg_img'>
    <section class='toggle-login'>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-t-10">
                    <form action="{{route('login_user')}}" method="POST">
                        @csrf()
                
                        <h5 class='m-t-10 text-center text-muted'> Let's Confirm it's You... </h5> <br>
                        @include('messages')

                        <div class=" wrap-input100 validate-input m-t-15 m-b-20" data-validate="Enter User ID">
                        <label> User ID </label>
                            <input required value="{{request()->uid }}" class="input100" autofocus type="text" name="id" placeholder="User ID">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-20" data-validate="Enter password">
                        <label for=""> Password </label>
                            <input autocomplete="off" required class="input100" placeholder='Your Password' type="password" name="password">
                            <span class="focus-input100"></span>
                        </div>        

                        <div class="container-login100-form-btn">
                            <button type='submit' class="login100-form-btn"> Continue  <i class="fa ml-2 fa-arrow-right"></i> </button>
                        </div>
                        
                    </form>

                    <p class="mt-4 text-center text-muted"><a href="{{ route('home_page') }}"> GO TO HOMEPAGE </a></p>
                </div>
                
                
            </div>
            
        </div> 

    </section>
    


    <section class="toggle-login hide">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-t-10 p-b-20">
                    <form action="#" method='post' class="pwd_reset_form login100-form validate-form">
                        @csrf()
            
                        <h5 class="text-center text-muted"> <b> Password Reset </b> </h5>
                        <p class="reset_helper text-primary"></p>

                        <div class="wrap-input100 validate-input m-t-60 m-b-35" data-validate="username">
                        <label for="">Username </label>
                            <input class="input100" placeholder='Your Username' type="text" required name="username">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="container-login100-form-btn">
                            <button type='submit' class="login100-form-btn">
                                <i class="fa fa-spin fa-spinner reset_loader fa-2x hide"> </i> Send Password Reset Link
                            </button>
                        </div>
                
                        <ul class="login-more p-t-15 pwd_reset">
                            <li class="m-b-8">
                                <a href='#' class="txt1 text-info"> <i class="fa fa-sign-in"></i> Back to Login </a>
                            </li>
                        </ul>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <div id="dropDownSelect1"></div>
    <!--===============================================================================================-->
    <script src="{{asset('login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('login/vendor/animsition/js/animsition.min.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('login/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{asset('login/vendor/bootstrap/js/bootstrap.min.js ')}}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('login/vendor/select2/select2.min.js ')}}"></script>
    <!--===============================================================================================-->
    <script src="{{asset('login/js/main.js')}}"></script>
    
    <script>
        $(function() {
            var pwd_reset = $('.pwd_reset');
            pwd_reset.click(function() { $('.toggle-login').toggle(); })
        });
    </script>

</body>

</html>
