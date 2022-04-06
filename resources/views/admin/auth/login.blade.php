@extends('admin.layout.master')

@push('css')
    <style>
        body{
            background-color: #e9ecef !important;
        }
        .center-login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translateX(-50%) translateY(-50%);
            -webkit-transform: translate(-50%,-50%);
            transform: translate(-50%,-50%);
        }
        html{
            background-color: #0c8998;
            overflow: hidden;
        }
        .login-card-body, .register-card-body{
            box-shadow: 0 0 10px #00000038;
        }
        .card,
        .login-card-body, .register-card-body{
            background-color: transparent!important;
        }
        .login-card-body .input-group-text span, .register-card-body .input-group-text span{
            color: #fff;
        }
        .login-logo{
            color: #fff;
        }
        .affect-page span{
            display: block;
            position: absolute;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            background-color: #fff;
            box-shadow: 0 0 10px #ffffff94;
        }
        .affect-page span:first-of-type{
            width: 500px;
            height: 500px;
            opacity: .2;
            top: 10%;
            left: 200px;
            animation: animation_login 5s infinite;
        }
        .affect-page span:nth-of-type(2){
            width: 300px;
            height: 300px;
            opacity: .1;
            top: 60%;
            right: 30%;
            animation: animation_login 4s infinite;
        }
        .affect-page span:nth-of-type(3){
            width: 200px;
            height: 200px;
            opacity: .15;
            top: 70%;
            left: 10%;
            animation: animation_login 10s infinite;
        }
        .affect-page span:nth-of-type(4){
            width: 250px;
            height: 250px;
            opacity: .2;
            bottom: 60%;
            right: 20%;
            animation: animation_login 8s infinite;
        }
        .affect-page span:nth-of-type(5){
            width: 100px;
            height: 100px;
            opacity: .1;
            top: 54%;
            left: 89%;
            animation: animation_login 6s infinite;
        }
        @keyframes animation_login {
            0%, 100%{
                transform: scale(1, 1);
            }
            50%{
                transform: scale(1.5, 1.5);
            }
        }
    </style>
@endpush

@section('content')

    <div class="login-box center-login-form">
        <div class="affect-page">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="login-logo">
            <span>{{ awtTrans('تسجيل الدخول') }}</span>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg"></p>
                <form action="{{route('admin.login')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                        <input type="email" name="email" class="form-control" placeholder="{{ __('email') }}">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="{{ __('password') }}">
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember" value="1">
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('log_in') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
