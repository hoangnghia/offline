<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://ngocdunggroup.com:8889/Ngocdung/images/logo.png" type="image/x-icon" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.min.css') }}">
</head>
<body class="hold-transition skin-purple login-page" style="background-image: url(https://pub.masoffer.com/assets/auth/img/paper-3.png);
    background-size: cover;
    background-repeat: no-repeat;">
<div class="login-box">
    {{--<div class="login-logo">--}}
        {{--<a href="{{ url('admin') }}">Ngọc Dung Beauty</a>--}}
    {{--</div>--}}
    <!-- /.login-logo -->
    {{--@include('layouts.errors-and-messages')--}}
    <div class="login-box-body" style="background: #ffffff36;
    padding: 20px;
    border-top: 0;
    color: #666;">

        <form action="{{ route('admin.login') }}" method="post">
            {{ csrf_field() }}
            <div class="form_login_new__bg__logo text-center">
                <img src="https://ngocdunggroup.com:8889/Ngocdung/images/logo_login.png" alt="">
            </div>
            <p class="login-box-msg" style="    color: #dcaf26;
    font-weight: bold;
    font-size: 21px;
    margin-top: 0;
    text-transform: uppercase;">Đăng nhập</p>
            <div class="form-group has-feedback">
                <input name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                <span class="fa fa-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="password" type="password" class="form-control" placeholder="Password">
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">

                </div>
                <!-- /.col -->
                <div class="col-xs-12">
                    <button style="background: #29328a;
    border-radius: 25px;
    text-align: center;
    height: 50px;
    width: 100%;
    display: inline-block;" type="submit" class="btn btn-primary btn-block btn-flat"><img
                                src="https://ngocdunggroup.com/Common/images/login_button_action.png" alt=""></button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        {{--<div class="social-auth-links text-center">--}}
        {{--<p>- OR -</p>--}}
        {{--<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using--}}
        {{--Facebook</a>--}}
        {{--<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using--}}
        {{--Google+</a>--}}
        {{--</div>--}}
        {{--<!-- /.social-auth-links -->--}}

        {{--<a href="#">I forgot my password</a><br>--}}
        {{--<a href="{{ url('/') }}" class="text-center">Register a new membership</a>--}}

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<script src="{{ asset('js/admin.min.js') }}"></script>
</body>
</html>