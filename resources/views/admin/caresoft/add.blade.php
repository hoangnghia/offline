@extends('layouts.admin.app')
@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h2 class="title">Thêm Phiếu Ghi Trên Care Soft</h2>
                            </div>
                            <div class="contentt">
                                <form enctype="multipart/form-data" method="post"
                                      action="{{ route('admin.customer.careSoftSent') }}"
                                      id="import-form">
                                    {{ csrf_field() }}
                                    <fieldset>
                                        <div class="col-lg-12">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="scrollbar" id="style-default">
                                                        <div class="force-overflow">
                                                            <h2 style="text-align: center;font-weight: bold">Danh Sách Khách Hàng</h2>
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th>Tên Khách Hàng</th>
                                                                    <th>Số Điện Thoại</th>
                                                                    <th>Dịch vụ</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($data as $item)
                                                                    <tr>
                                                                        <td style="display: none"><input name="customer_id[]"
                                                                                                         value="{{$item->id}}"></td>
                                                                        <td>{{$item->name}}</td>
                                                                        <td>{{$item->phone}}</td>
                                                                        <td>{{$item->service_name}}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Form Name -->
                                        <legend>Vui lòng điền các thông tin cần thiết</legend>
                                        <!-- File Button -->
                                        <div class="form-group">
                                            <label class=" control-label" for="title_phieu">Tên chiến dịch</label>
                                            <div class="">
                                                <input class="form-control" type="text" name="title_phieu" value="" placeholder="Tên chiến dịch" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="chi_nhanh">Chi Nhánh</label>
                                            <div class="">
                                                <select id="chi_nhanh" name="chi_nhanh" class="form-control">
                                                    <option value="">Vui lòng chọn chi nhánh</option>
                                                    @foreach($branch as $item)
                                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="loai_phieu">Loại Phiếu</label>
                                            <div class="">
                                                <select id="loai_phieu" name="loai_phieu" class="form-control">
                                                    <option value="">Vui lòng chọn loại phiếu ghi</option>
                                                    <option value="41875">Lead</option>
                                                    <option value="41887">Khác</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="vung_mien">Vùng miền</label>
                                            <div class="">
                                                <select id="vung_mien" name="vung_mien" class="form-control">
                                                    <option value="42112">Chưa phân loại</option>
                                                    <option value="42115">MB</option>
                                                    <option value="42118">MT</option>
                                                    <option value="42121">MN</option>
                                                    <option value="42124">HCM</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label" for="chi_tiet_nguon_phieu">Chi tiết nguồn
                                                Phiếu</label>
                                            <div class="">
                                                <select id="chi_tiet_nguon_phieu" name="chi_tiet_nguon_phieu"
                                                        class="form-control">
                                                    <option value="">Vui lòng chọn chi tiết Nguồn phiếu ghi</option>
                                                    <option value="42112">Chưa phân loại</option>
                                                    <option value="44119">Khác</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="field-chuyen-vien">
                                            <label class="control-label" for="chuyen_vien">Chọn chuyên viên</label>
                                            <div class="chuyen-vien">
                                                <select id="chi_tiet_nguon_phieu" name="chuyen_vien"
                                                        class="form-control">
                                                    <option value="">Vui lòng chọn chuyên viên</option>
                                                    <option value="29128598">OFF 01 - Sen</option>
                                                    <option value="27921668">OFF 02 - Tuấn</option>
                                                    <option value="19193307">OFF 03 - Dung</option>
                                                    <option value="22109397">OFF 04 - My</option>
                                                    <option value="35559324">OFF 05 - Bảo</option>
                                                    <option value="27745625">OFF 06 - VĂN</option>
                                                    <option value="58968877">OFF 07 - Như</option>
                                                    <option value="41534947">OFF 08 - Thảo</option>
                                                    <option value="75811663">OFF 09 - Hòa</option>
                                                    <option value="76243845">OFF 10 - Phượng</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="text-align: center;">
                                            <input style="border-color: #d7baa5;" type="submit" class="btn btn-success"
                                                   value="Sent CareSoft">
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <style type="text/css">
        .form-group {
            padding: 15px;
            margin-bottom: 0px;
        }
        .scrollbar
        {
            height: 300px;
            background: #F5F5F5;
            overflow-y: scroll;
            margin-bottom: 25px;
        }
        .btn-success {
            color: #fff;
            background-color: #5cb85c;
            border-color: #4cae4c;
        }

        .btn {
            display: inline-block;
            margin-bottom: 0;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            border-radius: 4px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .margin-top-20 {
            margin-top: 20px;
        }

        body {
            background: url('https://ngocdunggroup.com:8889/Ngocdung/images/wallpaper__login.jpg');
            background-size: 100% 100%;
            background-attachment: fixed;
            background-repeat: no-repeat;
            font-family: 'Open Sans', sans-serif;
            padding-bottom: 40px;
        }

        .auth h1 {
            color: #fff !important;
            font-weight: 300;
            font-family: 'Open Sans', sans-serif;
        }

        .auth h1 span {
            font-size: 21px;
            display: block;
            padding-top: 20px;
        }

        .auth .auth-box legend {
            color: #fff;
            border: none;
            font-weight: 300;
            font-size: 24px;
        }

        .auth .auth-box {
            background-color: #fff;
            max-width: 460px;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background-color: rgb(16, 37, 93);
            background: rgba(14, 43, 113, 0.73);
            margin-top: 40px;
            -webkit-box-shadow: 0px 0px 30px 0px rgba(50, 50, 50, 0.32);
            -moz-box-shadow: 0px 0px 30px 0px rgba(50, 50, 50, 0.32);
            box-shadow: 0px 0px 30px 0px rgba(50, 50, 50, 0.32);
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            -webkit-transition: background 1s ease-in-out;
            -moz-transition: background 1s ease-in-out;
            -ms-transition: background 1s ease-in-out;
            -o-transition: background 1s ease-in-out;
            transition: background 1s ease-in-out;
        }

        @media (max-width: 460px) {
            .auth .auth-box {
                margin: 0 10px;
            }
        }

        .auth .auth-box input::-webkit-input-placeholder { /* WebKit browsers */
            color: #fff;
            font-weight: 300;
        }

        .auth .auth-box input:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
            color: #fff;
            font-weight: 300;
        }

        .auth .auth-box input::-moz-placeholder { /* Mozilla Firefox 19+ */
            color: #fff;
            font-weight: 300;
        }

        .auth .auth-box input:-ms-input-placeholder { /* Internet Explorer 10+ */
            color: #fff;
            font-weight: 300;
        }

        .auth span.input-group-addon,
        .input-group-btn button {
            border: none;
            background: #fff !important;
            color: #000 !important;
        }

        .auth form {
            font-weight: 300 !important;
        }

        .auth form input[type="text"],
        .auth form input[type="password"],
        .auth form input[type="email"],
        .auth form input[type="search"] {
            border: none;
            padding: 10px 0 10px 0;
            background-color: rgba(255, 255, 255, 0) !important;
            background: rgba(255, 255, 255, 0);
            color: #fff;
            font-size: 16px;
            border-bottom: 1px dotted #fff;
            border-radius: 0;
            box-shadow: none !important;
            height: auto;
        }

        .auth textarea {
            background-color: rgba(255, 255, 255, 0) !important;
            color: #fff !important;
        }

        .auth input[type="file"] {
            color: #fff;
        }

        .auth form label {
            color: #fff;
            font-size: 15px;
            font-weight: 300;
        }

        /*for radios & checkbox labels*/
        .auth .radio label,
        .auth label.radio-inline,
        .auth .checkbox label,
        .auth label.checkbox-inline {
            font-size: 14px;
        }

        .auth form .help-block {
            color: #fff;
        }

        .auth form select {
            background-color: rgba(255, 255, 255, 0) !important;
            background: rgba(255, 255, 255, 0);
            color: #fff !important;
            border-bottom: 1px solid #fff !important;
            border-radius: 0;
            box-shadow: none;
        }

        .auth form select option {
            color: #000;
        }

        /*multiple select*/
        .auth select[multiple] option,
        .auth select[size] {
            color: #fff !important;
        }

        /*Form buttons*/
        .auth form .btn {
            background: none;
            -webkit-transition: background 0.2s ease-in-out;
            -moz-transition: background 0.2s ease-in-out;
            -ms-transition: background 0.2s ease-in-out;
            -o-transition: background 0.2s ease-in-out;
            transition: background 0.2s ease-in-out;
        }

        .auth form .btn-default {
            color: #fff;
            border-color: #fff;
        }

        .auth form .btn-default:hover {
            background: rgba(225, 225, 225, 0.3);
            color: #fff;
            border-color: #fff;
        }

        .auth form .btn-primary:hover {
            background: rgba(66, 139, 202, 0.3);
        }

        .auth form .btn-success:hover {
            background: rgba(92, 184, 92, 0.3);
        }

        .auth form .btn-info :hover {
            background: rgba(91, 192, 222, 0.3);
        }

        .auth form .btn-warning:hover {
            background: rgba(240, 173, 78, 0.3);
        }

        .auth form .btn-danger:hover {
            background: rgba(217, 83, 79, 0.3);
        }

        .auth form .btn-link {
            border: none;
            color: #fff;
            padding-left: 0;
        }

        .auth form .btn-link:hover {
            background: none;
        }

        .auth label.label-floatlabel {
            font-weight: 300;
            font-size: 11px;
            color: #fff;
            left: 0 !important;
            top: 1px !important;
        }
    </style>
@endsection
