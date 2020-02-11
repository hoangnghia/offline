@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <h2>Thêm khách hàng</h2>
                <div id="filter-lead-verified" class="panel mb25 mt5">
                    <div class="panel-heading" style=" border: 1px solid #b5aeae8c; padding: 14px;border-radius: 5px;">
                        {{--<form method="post" action="{{url('customer/postListIntroduce')}}">--}}
                        {{--{{ csrf_field() }}--}}
                        <form enctype="multipart/form-data" method="post"
                              action="{{ route('admin.customer.postListIntroduce') }}"
                              id="import-form">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label class="control-label col-sm-2" for="pwd">Tên Lead:<b
                                            style="color: red">(*)</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" placeholder="Họ tên" name="name"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-2" for="pwd">SĐT Lead:<b
                                            style="color: red">(*)</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control change-phone" id="phone"
                                           placeholder="Số điện thoại "
                                           name="phone" value="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-2" for="pwd">Chi nhánh:<b style="color: red">(*)</b></label>
                                <div class="col-sm-10">
                                    <input list="brow" class="form-control" name="branch" required>
                                    <datalist id="brow">
                                        <option value="Đà Nẵng"></option>
                                        <option value="Nha Trang">
                                        <option value="Buôn Ma Thuột">
                                        <option value="Phan Thiết">
                                        <option value="Vinh">
                                        <option value="Quảng Ninh">
                                        <option value="Hải Phòng">
                                        <option value="Hà Nội">
                                        <option value="Hà Nội Trần Duy Hưng">
                                        <option value="Biên Hòa">
                                        <option value="Vũng Tàu">
                                        <option value="Cần Thơ">
                                        <option value="Bình Dương">
                                        <option value="Hồ Chí Minh 3/2">
                                        <option value="Trần Hưng Đạo">
                                        <option value="Đinh Tiên Hoàng">
                                        <option value="Nguyễn Thị Minh Khai">
                                        <option value="Nguyễn Thị Thập">
                                    </datalist>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-2" for="pwd">Tên người giới thiệu:<b
                                            style="color: red">(*)</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name-introduce" placeholder="Họ tên "
                                           name="name_introduce" required value="{{ session()->get('name') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-2" for="pwd">SĐT người giới thiệu:<b
                                            style="color: red">(*)</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone-introduce"
                                           placeholder="Số điện thoại " name="phone_introduce" required
                                           value="{{ session()->get('phone') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-2" for="pwd">Năm sinh:</label>
                                {{--<div class="col-sm-10">--}}
                                {{--<input type="text" class="form-control" id="birthday" placeholder="Năm sinh "--}}
                                {{--name="birthday">--}}
                                {{--</div>--}}
                                <div class="col-sm-10">
                                    <input list="brow_birthday" class="form-control" name="birthday">
                                    <datalist id="brow_birthday">
                                        <option value="Khác"></option>
                                        <option value="> 28">
                                        <option value="< 28">
                                    </datalist>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-2" for="pwd">Nội dung:</label>
                                {{--<div class="col-sm-10">--}}
                                {{--<input type="text" class="form-control" id="note" placeholder="Nội dung "--}}
                                {{--name="note">--}}
                                {{--</div>--}}
                                <div class="col-sm-10">
                                    <input list="brow_dv" class="form-control" name="note">
                                    <datalist id="brow_dv">
                                        <option value="Laser Mặt"></option>
                                        <option value="Làm Ốm">
                                        <option value="Laser TQM">
                                        <option value="Laser Môi Thâm">
                                        <option value="Chưa Chọn Dịch Vụ">
                                    </datalist>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-2" for="pwd">Nhân viên:<b
                                            style="color: red">(*)</b></label>
                                <div class="col-sm-10">
                                    <select name="user_cskh" class="form-control" id="user_cskh"
                                            style="background-color: transparent !important;  border-color: #d2d6de; color: black !important;"
                                            required>
                                        <option>Chọn nhân viên</option>
                                        @foreach(\App\Shop\Customer\CustomerIntroduce::USER_TEXT as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{--<input list="brow_user" class="form-control" name="branch" required>--}}
                                {{--<datalist id="brow_user">--}}
                                {{--@foreach(\App\Shop\Customer\CustomerIntroduce::USER_TEXT as $key => $value)--}}
                                {{--<option value="{{ $key }}">{{ $value }}</option>--}}
                                {{--@endforeach--}}
                                {{--</datalist>--}}
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="status-check"
                                       name="status_check">
                                <label class="form-check-label" for="status-check">
                                    Chuyển trực tiếp
                                </label>
                            </div>
                            <div style="text-align: center">
                                <button class="btn btn-success" type="submit">Thêm mới</button>
                            </div>
                        </form>
                    </div>
                    <div class="panel-body p20 pb10">
                        <div class="tab-content pn br-n">
                            <h2>Tìm Kiếm</h2>
                            <div class="tab-pane active"
                                 style=" border: 1px solid #b5aeae8c; padding: 14px;border-radius: 5px;">
                                <form method="get" id="search-form-customer">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="section mb10" id="date-sent-field">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar">
                                                        </i>
                                                    </div>
                                                    <input readonly="" type="text" placeholder="Thời gian tạo"
                                                           value=""
                                                           class="form-control change-filter-room-id pull-right"
                                                           name="created_at" id="created_at">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="section mb10" id="date-sent-field">
                                                <label style="width: 100%" for="customer-name"
                                                       class="field prepend-icon">
                                                    <input style="width: 100%"
                                                           value=""
                                                           type="text"
                                                           name="name" id="customer-name"
                                                           class="form-control change-filter-room-id gui-input"
                                                           placeholder="Họ tên Lead">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="section mb10" id="date-sent-field">
                                                <label style="width: 100%" for="customer-phone"
                                                       class="field prepend-icon">
                                                    <input style="width: 100%"
                                                           value=""
                                                           type="number"
                                                           name="phone" id="customer-phone"
                                                           class="form-control change-filter-room-id gui-input"
                                                           placeholder="SĐT Lead">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="section mb10" id="date-sent-field">
                                                <label style="width: 100%" for="introduce-phone"
                                                       class="field prepend-icon">
                                                    <input style="width: 100%"
                                                           value=""
                                                           type="number"
                                                           name="phone" id="introduce-phone"
                                                           class="form-control change-filter-room-id gui-input"
                                                           placeholder="SĐT giới thiệu">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="section mb10" id="date-sent-field">
                                                <label style="width: 100%" for="introduce-phone"
                                                       class="field prepend-icon">
                                                    <select class="form-control change-filter-room-id"
                                                            id="filter_user_cskh">
                                                        <option value="">Chọn nhân viên</option>
                                                        @foreach(\App\Shop\Customer\CustomerIntroduce::USER_TEXT as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        {{--<div class="col-md-2">--}}
                                        {{--<select class="form-control change-filter-room-id" id="status-sms">--}}
                                        {{--<option value="">KH gửi SMS</option>--}}
                                        {{--<option value="1">Gửi SMS</option>--}}
                                        {{--<option value="2">Chưa gửi SMS</option>--}}
                                        {{--</select>--}}
                                        {{--</div>--}}
                                        <div class="col-md-2">
                                            <select class="form-control change-filter-room-id" id="status-cs">
                                                <option value="">Moon</option>
                                                <option value="1">Ko tồn tại</option>
                                                <option value="2">Tồn tại</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <form enctype="multipart/form-data" method="post"
                      action="{{ route('admin.cskh.crmCheckStatusCustomer') }}" style="float: right">
                    {{ csrf_field() }}
                    <button class="btn btn-success" type="submit">Check trạng thái</button>
                </form>
                <table id="list-customer" class="table">
                    <thead>
                    <tr>
                        <th class=""></th>
                        <th>Chi nhánh</th>
                        <th>Tên người giới thiệu</th>
                        <th>SĐT Người giới thiệu</th>
                        <th>Tên Lead</th>
                        <th>SĐT Lead</th>
                        <th>Năm sinh</th>
                        <th>Nội Dung</th>
                        <th>NV CSKH</th>
                        <th>NV Offline</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái Moon</th>
                        <th>Tình Trạng</th>
                        <th>Trạng Thái Tư Vấn</th>
                        <th>Option</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <style type="text/css">
        td {
            text-align: center
        }

        .tab-content > .tab-pane {
            border: 0px solid #ddd;
        }

        .tab-content > .tab-pane {
            padding: 0px;
        }

        .popup-basic {
            position: relative;
            background: #FFF;
            width: auto;
            max-width: 450px;
            margin: 40px auto;
        }

        #date-sent-field label {
            display: block
        }

        .not-sent {
            color: red;
            font-weight: bold
        }

        .sent {
            color: blue;
            font-weight: bold
        }

        #page_id .btn-group {
            display: grid
        }

        select.form-control {
            background-color: #dcaf26 !important;
            border-color: #dcaf26;
            transition: all .2s ease-in;
            color: #FFF !important;
        }

        .care_soft {
            background: #00a65a;
            color: #fff;
            padding: 2px 10px 2px 10px;
            border-radius: 15px;
        }
    </style>
    <script type="text/javascript">
        $("#checkAll").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
        cb = moment().subtract(18, 'days'), moment();
        $('#created_at').daterangepicker({
            "startDate": moment(),
            "endDate": moment(),
            "autoApply": true,
            "opens": "center",
            "buttonClasses": "btn-info",
            ranges: {
                'Hôm nay': [moment(), moment()],
                'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 ngày qua': [moment().subtract(6, 'days'), moment()],
                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                'Năm nay': [moment().startOf('year'), moment()]
            }
        }, cb);
        $('.change-filter-room-id').change(function (e) {
            oTableCustomer.draw(true);
        });
        $('.change-phone').change(function (e) {
            var phonenumber = $('#phone').val();
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': ' {{csrf_token()}}'
                },
                dataType: 'json',
                url: '{{url('/admin/cskh/crmCheck')}}',
                data: {
                    'phone': phonenumber
                },
            }).done(function (response) {
                if (response.result) {
                    if (response.check == true) {
                        window.open(response.link, '_blank');
                        alert(response.msg);
                    } else {
                        alert(response.msg);
                    }
                } else {
                    alert('WTF!!! Có lỗi trong quá trình, liên hệ IT ngay nhé.');
                }
            });
        });
        cbex = moment().subtract(18, 'days'), moment();
        var oTableCustomer = $('#list-customer').DataTable({
            "lengthMenu": [[100, 500, 1000, 2000], [100, 500, 1000, 2000]],
            processing: true,
            serverSide: true,
            'columnDefs': [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',

            }],
            order: [[0, "asc"]],
            "pageLength": 100,
            ajax: {
                url: '{!! url('/admin/customer/getListDataIntroduce') !!}',
                data: function (d) {
                    d.name = $('#search-form-customer #customer-name').val();
                    d.phone = $('#search-form-customer #customer-phone').val();
                    d.phone_introduce = $('#search-form-customer #introduce-phone').val();
                    d.user_cskh_filter = $('#search-form-customer #filter_user_cskh').val();
                    // d.user = $('#search-form-customer #user-id').val();
                    d.created_at = $('#search-form-customer #created_at').val();
                    // d.status_sms = $('#search-form-customer #status-sms').val();
                    d.status_moon = $('#search-form-customer #status-cs').val();

                }
            },
            "columns": [
                {
                    data: 'id', name: 'id', render: function (data) {
                        return '<label class="option block mn"> <input type="checkbox" class="sub_chk" data-id="' + data + '" name="checkbox[]" value="' + data + '"> <span class="checkbox mn"></span> </label>'
                    }
                },
                {data: 'branch_name', name: 'branch_name'},
                {data: 'name_introduce', name: 'name_introduce'},
                {data: 'phone_introduce', name: 'phone_introduce'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'birthday', name: 'birthday'},
                {data: 'note', name: 'note'},
                {data: 'cskh_name', name: 'cskh_name'},
                {data: 'offline_name', name: 'offline_name'},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'status_moon', name: 'status_moon', render: function (data) {
                        var css = '';
                        var text = '';
                        if (data == 1) {
                            css = '#0e3298';
                            text = 'Ko tồn tại';
                        } else {
                            css = '#d21414';
                            text = 'Tồn tại';
                        }
                        return '<b style="color:' + css + '">' + text + '</b>'
                    }
                },
                {
                    data: 'status', name: 'status', render: function (data) {
                        var css = '';
                        var text = '';
                        if (data == 999) {
                            css = '#0e3298';
                            text = 'Chưa chuyển';
                        } else {
                            css = '#d21414';
                            text = 'Đã chuyển';
                        }
                        return '<b style="color:' + css + '">' + text + '</b>'
                    }
                },
                {data: 'status_care_title', name: 'status_care_title'},
                {
                    data: 'id', name: 'id', render: function (data, type, row) {
                        return '<a href="{{url('admin/cskh/delete') .'/'}}' + row.id + '" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
                    }
                },
            ]
        });


    </script>
    <!-- /.content -->
@endsection

