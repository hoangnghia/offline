<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý khách hàng - Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" href="{{ asset('assets/css/style1.css') }}">
</head>
<body id="customer">
<div class="wrapper">
    <div class="mo-menu">
        <menu class="menu">
            <ul>
                <li><a href="{{ url('employee/dashboard') }}"><img src="{{ asset('assets/img/insurance.png') }}"/>Chiến
                        dịch</a></li>
                <li><a href="{{ url('employee/customer/0') }}"><img src="{{ asset('assets/img/friends.png') }}"/>Khách
                        hàng</a></li>
                <li><a href="{{ url('employee/add/0') }}"><img src="{{ asset('assets/img/add-friend.png') }}"/>Thêm
                        khách hàng</a></li>
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
<script type="text/javascript" src="{{ asset('assets/js/qlkh.js') }}">
</script>
@yield('scripts')
</body>
</html>