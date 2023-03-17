<!DOCTYPE html>
<html lang="en">

<head>
    <title> Sign up  </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name='description' content="School Portal 360 ( Sp360 ) classroom - Best Nigeria School management system and Online classroom portal">
    <meta name='keyword' content="sp360 Classroom, register account, Nigeria Online Classroom portal for schools ">
    <!--===============================================================================================-->
    <link rel="shortcut icon" href="{{asset('dist/img/sp360_logo.jpg')}}" sizes='any' type="image/x-icon">
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
    body{
        zoom:75%;
        background: url('/dist/img/sp360_logo.jpg');
        background-position:center;
        background-attachment: fixed;
        background-repeat:no-repeat;
        opacity:0.96;
        z-index:-1; 
    }
</style>

<body class='bg-img'>
    <section class='toggle-login'>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-t-10 p-b-20">
                    <form action="{{route('register_user')}}" method="POST">
                        @csrf()
                    
                       <div class="d-flex justify-content-center">
                            <img style='width:auto; height:80px;' src="{{asset('dist/img/sp360_logo.png')}}" alt="logo">
                       </div>
                        <h4 class='m-t-10 text-center text-muted'> Classroom Sign up </h4> <br>
                        @include('messages')

                        <div class="wrap-input100 validate-input m-t-15 m-b-20">
                        <label> Surname </label>
                            <input required class="input100" autofocus type="text" name="surname" placeholder="Your Surname">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-t-15 m-b-20">
                        <label> Firstname </label>
                            <input required class="input100" type="text" name="first_name" placeholder="Your First name">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-t-15 m-b-20">
                        <label> Username </label> <br>
                        <small class='text-info'> This will be used both as your Login details and display ID </small>
                            <input required maxlength="16" class="input100" type="text" name="username" placeholder="Your username">
                        </div>

                        <div class="wrap-input100 validate-input m-t-15 m-b-20">
                        <label> Phone </label>
                            <input required class="input100" type="tel" name="phone" placeholder="Your Phone number">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-t-15 m-b-20">
                        <label> Email </label>
                            <input class="input100" type="text" name="email" placeholder="Your Email">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-20" data-validate="Enter password">
                        <label for=""> Password </label>
                            <input required minlength="6" class="input100" placeholder='Your Password' type="password" name="password">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-20" data-validate="Enter password">
                        <label for=""> School Code </label>
                            <input required minlength="6" class="input100" placeholder='Your school code' type="text" name="invite_code">
                            <span class="focus-input100"></span>
                        </div>
                    
                        <div class="container-login100-form-btn">
                            <button type='submit' class="login100-form-btn"> Register </button>
                        </div>

                        <ul class="login-more p-t-15">
                            <li class="m-b-8">
                                <span class="txt1">
                                    Have an account?
                                </span>

                                <a href="{{route('login')}}" class="txt2 text-info">
                                    Login here
                                </a>
                            </li>
                            <li class="m-b-8 pwd_reset">
                                <span class="txt1">
                                    Are you a school owner?
                                </span>

                                <a href="#" class="txt2 text-info">
                                    Get school Code
                                </a>
                            </li>
                        </ul>
                        
                    </form>
                </div>
            </div>
        </div> 
    </section>


    <section class="toggle-login hide">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-t-10 p-b-20">

                    <form action="#" method='post' class="register_school_form login100-form validate-form">
                        @csrf()
            
                        <h5 class="text-center text-muted"> <b> Register School </b> </h5>
                        <p class="reset_helper text-primary"></p>

                        <div class="wrap-input100 validate-input m-t-15 m-b-20" data-validate="School name">
                        <label for=""> Name </label>
                            <input class="input100" placeholder='School name' type="text" required name="name">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-t-15 m-b-20" data-validate="School address">
                        <label for=""> Address </label>
                            <input class="input100" placeholder='School address' type="text" required name="address">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-t-15 m-b-20">
                        <label> Phone </label>
                            <input required class="input100" type="tel" name="phone" placeholder="School Phone number">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-t-15 m-b-20">
                        <label> Email </label>
                            <input class="input100" type="email" name="email" placeholder="School Email">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-t-15 m-b-20" data-validate="School LGA">
                        <label for=""> LGA </label>
                            <input class="input100" placeholder='School LGA' type="text" required name="lga">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-t-15 m-b-20" data-validate="School State">
                        <label for=""> State </label>
                            <input class="input100" placeholder='State' type="text" required name="state">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-t-15 m-b-20" data-validate="School Country">
                        <label for=""> Country</label>
                            <input class="input100" placeholder='Country' type="text" value='Nigeria' required name="country">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="container-login100-form-btn">
                            <button type='submit' class="login100-form-btn">
                                <i class="fa fa-spin fa-spinner reset_loader fa-2x hide"> </i>  Get School code
                            </button>
                        </div>
            

                        <ul class="login-more p-t-15 pwd_reset">
                            <li class="m-b-8">
                                <a href='#' class="txt1 text-info"> <i class="fa fa-user-circle"></i> Continue with Account Registration... </a>
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

            $('.register_school_form').submit( (e) => {
                e.preventDefault();
                alert('submitted');
                return;
                var data = $(this).serialize();
                $.post('/register_school', data, (response) => {

                });
            })
        });
    </script>

</body>

</html>
