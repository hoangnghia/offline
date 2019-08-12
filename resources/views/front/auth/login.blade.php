<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Quản lý khách hàng - Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="./css/custom.css">
</head>
<body>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <div class="fadeIn first">
            <img src="img/logo-1.png" id="icon" alt="User Icon" />
        </div>
        <form action="{{ route('front.login') }}" method="post" class="form-horizontal">
            {{ csrf_field() }}
            <input type="email" id="login" class="fadeIn second" name="email" placeholder="Tên đăng nhập">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="Mật khẩu">
            <input type="submit" class="fadeIn fourth" value="Đăng nhập">
        </form>
    </div>
</div>
</body>
</html>