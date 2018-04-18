<!DOCTYPE html>
<html lang="en">
<head>
    <title>HealthShoppe Website Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="{{'loginterface/images/icons/favicon.ico'}}"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{'loginterface/vendor/bootstrap/css/bootstrap.min.css'}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{'loginterface/fonts/font-awesome-4.7.0/css/font-awesome.min.css'}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{'loginterface/vendor/animate/animate.css'}}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{'loginterface/vendor/css-hamburgers/hamburgers.min.css'}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{'loginterface/vendor/select2/select2.min.css'}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{'loginterface/css/util.css'}}">
    <link rel="stylesheet" type="text/css" href="{{'loginterface/css/main.css'}}">
<!--===============================================================================================-->
</head>
<body>
    
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="loginterface/images/logo.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                @csrf
                    <span class="login100-form-title">
                        Login
                    </span>

                    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                         <input class="input100" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate = "Password is required">
                        <input class="input100" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                             {{ __('Login') }}
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <a class="txt2" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    

    
<!--===============================================================================================-->  
    <script src="{{ 'loginterface/vendor/jquery/jquery-3.2.1.min.js'}}"></script>
<!--===============================================================================================-->
    <script src="{{ 'loginterface/vendor/bootstrap/js/popper.js' }}"></script>
    <script src="{{ 'loginterface/vendor/bootstrap/js/bootstrap.min.js' }}"></script>
<!--===============================================================================================-->
    <script src="{{ 'loginterface/vendor/select2/select2.min.js' }}"></script>
<!--===============================================================================================-->
    <script src="{{ 'loginterface/vendor/tilt/tilt.jquery.min.js' }}"></script>
    <script >
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
<!--===============================================================================================-->
    <script src="{{ 'loginterface/js/main.js' }}"></script>

</body>
</html>
