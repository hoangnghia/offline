@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <h2>Danh sách khách hàng</h2>
                <div id="filter-lead-verified" class="panel mb25 mt5">
                    <div class="panel-heading">
                        <span class="panel-title">Điều kiện lọc</span>
                        <a href="{!! url('/admin/customer/history') !!}" class="btn btn-warning" role="button"
                           style="float: right;margin-left: 10px">Lịch sử SMS</a>
                        <a href="javascript:void(0)" class="btn btn-info right customer-export" role="button"
                           style="float: right">Export</a>
                        <a href="javascript:void(0)" class="btn btn-success right customer-cs" role="button"
                           style="float: right;margin-right: 10px">Gửi CareSoft</a>
                        <a href="javascript:void(0)" class="btn btn-success right customer-sms" role="button"
                           style="float: right;margin-right: 10px">Gửi SMS</a>
                    </div>
                    <div class="panel-body p20 pb10">
                        <div class="tab-content pn br-n">
                            <div class="tab-pane active">
                                <form method="get" id="search-form-customer">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="section mb10" id="date-sent-field">
                                                <label style="width: 100%" for="customer-name"
                                                       class="field prepend-icon">
                                                    <input style="width: 100%"
                                                           value=""
                                                           type="text"
                                                           name="name" id="customer-name"
                                                           class="form-control change-filter-room-id gui-input"
                                                           placeholder="Họ tên khách hàng">
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
                                                           placeholder="Số điện thoại">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="section mb10" id="page_id">
                                                <label style="width: 100%" for="select" class="field prepend-icon">
                                                    <select id="campaign-id"
                                                            class="change-filter-room-id form-control" name="agent-id[]"
                                                            multiple="multiple">
                                                        @foreach($campaign as $item)
                                                            <option value="{{$item->id}}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <i class="arrow"></i>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="section mb10" id="page_id">
                                                <label style="width: 100%" for="select" class="field prepend-icon">
                                                    <select id="user-id"
                                                            class="change-filter-room-id form-control" name="agent-id[]"
                                                            multiple="multiple">
                                                        @foreach($employees as $item)
                                                            <option value="{{$item->id}}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <i class="arrow"></i>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="list-customer" class="table">
                    <thead>
                    <tr>
                        <th></th>
                        {{--<th class="no-sort"><label class="option block mn"> <input type="checkbox" class="check-all"--}}
                        {{--name="checkbox[]"> <span--}}
                        {{--class="checkbox mn" ></span> </label></th>--}}
                        <th>Tên KH</th>
                        <th>Phone</th>
                        <th>Năm sinh</th>
                        <th>Dịch vụ</th>
                        <th>Chiến dịch</th>
                        <th>Pg</th>
                        <th>Người thân</th>
                        <th>Ngày tạo</th>
                        <th>SMS</th>
                        <th>CareSoft</th>
                        <th>Tình Trạng</th>
                        <th>Option</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- Admin Form Popup -->
    {{--<div id="modal-form-assign-agent" class="popup-basic admin-form mfp-with-anim mfp-hide">--}}
    {{--<div class="panel">--}}
    {{--<div class="panel-heading">--}}
    {{--<span class="panel-title"><i class="fa fa-rocket"></i>Chọn chuyên viên chăm sóc</span>--}}
    {{--</div>--}}
    {{--<!-- end .panel-heading section -->--}}
    {{--<form method="post" id="comment">--}}
    {{--<div class="panel-body p25">--}}
    {{--<div class="section row">--}}
    {{--<div class="col-md-12 ">--}}
    {{--<div class="section mb10" id="date-sent-field">--}}
    {{--<label class="field select">--}}
    {{--<select id="user_id"--}}
    {{--class="form-control">--}}
    {{--<option value="">-- Chọn một chuyên viên --</option>--}}
    {{--<option value="29128598">OFF 01 - Sen</option>--}}
    {{--<option value="27921668">OFF 02 - Tuấn</option>--}}
    {{--<option value="19193307">OFF 03 - Dung</option>--}}
    {{--<option value="22109397">OFF 04 - My</option>--}}
    {{--<option value="35559324">OFF 05 - Bảo</option>--}}
    {{--<option value="27745625">OFF 06 - Văn</option>--}}
    {{--<option value="58968877">OFF 07 - Như</option>--}}
    {{--@foreach($users as $user)--}}
    {{--<option value="{{$user->id}}">{{$user->full_name}}--}}
    {{--</option>--}}
    {{--@endforeach--}}
    {{--</select>--}}
    {{--<i class="arrow"></i>--}}
    {{--</label>--}}
    {{--<input type="hidden" id="uid-classify-id-assign">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<!-- end section -->--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<!-- end .form-body section -->--}}
    {{--{!! csrf_field() !!}--}}
    {{--<div class="panel-footer text-center">--}}
    {{--<button id='assign-agent' class="button btn-primary">Cập nhật</button>--}}
    {{--</div>--}}
    {{--<!-- end .form-footer section -->--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--<!-- end: .panel -->--}}
    {{--</div>--}}
    <!-- end: .admin-form -->
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
    </style>
    <script type="text/javascript">
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
        cbex = moment().subtract(18, 'days'), moment();
        $('#created_at_export').daterangepicker({
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
        }, cbex);
        var oTableCustomer = $('#list-customer').DataTable({
            processing: true,
            serverSide: true,
            columnDefs: [
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
            "pageLength": 50,
            ajax: {
                url: '{!! url('/admin/customer/getListData') !!}',
                data: function (d) {
                    d.name = $('#search-form-customer #customer-name').val();
                    d.phone = $('#search-form-customer #customer-phone').val();
                    d.campaign = $('#search-form-customer #campaign-id').val();
                    d.user = $('#search-form-customer #user-id').val();
                    d.created_at = $('#search-form-customer #created_at').val();
                }
            },
            "columns": [
                // {
                //     "data": "id",
                //     render: function (data, type, row, meta) {
                //         return meta.row + meta.settings._iDisplayStart + 1;
                //     }
                // },
                {
                    data: 'id', name: 'id', render: function (data) {
                        return '<label class="option block mn"> <input type="checkbox" class="sub_chk" data-id="' + data + '" name="checkbox[]" value="' + data + '"> <span class="checkbox mn"></span> </label>'
                    }
                },
                {
                    data: 'name', name: 'name', render: function (data, type, row) {
                        return '<a href="{{url('admin/customer/detail') .'/'}}' + row.id + '">' + data + '</a>';
                    }
                },
                {data: 'phone', name: 'phone'},
                {data: 'birthday', name: 'birthday'},
                {data: 'service_name', name: 'service_name'},
                {data: 'campaign_name', name: 'campaign_name'},
                {data: 'employees_name', name: 'employees_name'},
                {data: 'name_parent', name: 'name_parent'},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'sms_log_id', name: 'sms_log_id', render: function (data, type, row) {
                        var css = '';
                        var name = '';
                        if (data != null) {
                            css = "sent";
                            name = "Đã gửi";
                        } else {
                            css = "not-sent";
                            name = "Chưa gửi";
                        }
                        return '<p class="' + css + '">' + name + '</p>';
                    }
                },
                {
                    data: 'care_soft_log_id', name: 'care_soft_log_id', render: function (data, type, row) {
                        var css = '';
                        var name = '';
                        if (data != null) {
                            css = "sent";
                            name = "Đã gửi";
                        } else {
                            css = "not-sent";
                            name = "Chưa gửi";
                        }
                        return '<p class="' + css + '">' + name + '</p>';
                    }
                },
                {
                    data: 'status', name: 'status', render: function (data, type, row) {
                        var css = '';
                        var name = '';
                        if (data == 1) {
                            var test = 'Active';
                            css = "btn-success";
                            name = "Active";
                        } else if (data == 0) {
                            var test = 'UnActive';
                            css = "btn-danger";
                            name = "Inactive";
                        }
                        return '<a href="{{url('admin/customer/status') .'/'}}' + row.id + '" class="btn ' + css + '">' + name + '</a>';
                    }
                },
                {
                    data: 'id', name: 'id', render: function (data, type, row) {
                        return '<a href="{{url('admin/customer/delete') .'/'}}' + row.id + '" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
                    }
                },
            ]
        });
        $('#campaign-id').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: '-- Chọn chiến dịch --',
        });
        $('#user-id').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: '-- Chọn Pg --',
        });
        $('.change-filter-room-id').change(function (e) {
            oTableCustomer.draw(true);
        });
        // $('.check-all').change(function () {
        //     var checkboxes = $('#list-customer').find(':checkbox');
        //     if ($(this).prop('checked')) {
        //         checkboxes.prop('checked', true);
        //     } else {
        //         checkboxes.prop('checked', false);
        //     }
        // });
        $(".customer-export").on("click", function () {
            var arrIds = []
            var checkboxes = document.querySelectorAll('#list-customer input[type=checkbox]:checked')
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].value == 'on')
                    continue;
                arrIds.push(checkboxes[i].value)
            }
            if (arrIds.length == 0) {
                alert('Hửh??', 'Chọn các phiếu UIDs đi bạn ơi', 'danger');
                return false;
            }
            var urlDOWLOAD = "{{url('/admin/customer/export')}}?list=" + arrIds.join();
            window.open(urlDOWLOAD, '_blank');
            return false;
        });
        $(".customer-sms").on("click", function () {
            var arrIds = []
            var checkboxes = document.querySelectorAll('#list-customer input[type=checkbox]:checked')
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].value == 'on')
                    continue;
                arrIds.push(checkboxes[i].value)
            }
            if (arrIds.length == 0) {
                alert('Hửh??', 'Chọn các phiếu UIDs đi bạn ơi', 'danger');
                return false;
            }
            var urlSMS = "{{url('/admin/customer/sms')}}?list=" + arrIds.join();
            window.open(urlSMS);
            return false;
        });

        $(".customer-cs").on("click", function () {
            var arrIds = []
            var checkboxes = document.querySelectorAll('#list-customer input[type=checkbox]:checked')
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].value == 'on')
                    continue;
                arrIds.push(checkboxes[i].value)
            }
            if (arrIds.length == 0) {
                alert('Hửh??', 'Chọn các phiếu UIDs đi bạn ơi', 'danger');
                return false;
            }
            var urlCS = "{{url('/admin/customer/careSoft')}}?list=" + arrIds.join();
            window.open(urlCS);
            return false;
        });
    </script>
    <!-- /.content -->
@endsection
