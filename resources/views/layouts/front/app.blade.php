<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý khách hàng - Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" href="{{ asset('assets/css/style1.css') }}">
{{--    <link rel="stylesheet" href="http://code.jquery.com/qunit/qunit-1.11.0.css" type="text/css" media="all">--}}
    <link href="{{ asset('css/qunit-1.11.0.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
</head>
<body id="customer" >
<div class="wrapper">
    <div class="mo-menu">
        <menu class="menu">
            <ul>
                <li><a href="{{ url('employee/dashboard') }}"><img src="{{ asset('assets/img/insurance.png') }}"/>Chiến
                        dịch</a></li>
                {{--<li><a href="{{ url('employee/customer/0') }}"><img src="{{ asset('assets/img/friends.png') }}"/>Khách--}}
                        {{--hàng</a></li>--}}
                {{--<li><a href="{{ url('employee/add/0') }}"><img src="{{ asset('assets/img/add-friend.png') }}"/>Thêm--}}
                        {{--khách hàng</a></li>--}}
                <li><a href="{{ route('admin.logout') }}"><img src="{{ asset('assets/img/logout.png') }}"/>Đăng Xuất</a>
                </li>
            </ul>
        </menu>
        <div class="logo">
            <img src="{{ asset('assets/img/logo-1.png') }}" alt="User Icon"/>
        </div>
        <nav class="menu-btn">
            <ul>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </nav>
    </div>
    @yield('content')
</div>
</div>
<script type="text/javascript" src="{{ asset('assets/js/qlkh.js') }}"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/qunit/qunit-1.11.0.js"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.mask.js') }}"></script>
@yield('scripts')
</body>
</html>