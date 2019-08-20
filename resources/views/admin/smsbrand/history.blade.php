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
                    </div>
                    <div class="panel-body p20 pb10">
                        <div class="tab-content pn br-n">
                            <div class="tab-pane active">
                                <form method="get" id="search-form-customer">
                                    <div class="row">

                                        {{--<div class="col-md-3">--}}
                                        {{--<div class="section mb10" id="date-sent-field">--}}
                                        {{--<label style="width: 100%" for="customer-name"--}}
                                        {{--class="field prepend-icon">--}}
                                        {{--<input style="width: 100%"--}}
                                        {{--value=""--}}
                                        {{--type="text"--}}
                                        {{--name="name" id="customer-name"--}}
                                        {{--class="form-control change-filter-room-id gui-input"--}}
                                        {{--placeholder="Họ tên khách hàng">--}}
                                        {{--</label>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-2">--}}
                                        {{--<div class="section mb10" id="date-sent-field">--}}
                                        {{--<label style="width: 100%" for="customer-phone"--}}
                                        {{--class="field prepend-icon">--}}
                                        {{--<input style="width: 100%"--}}
                                        {{--value=""--}}
                                        {{--type="number"--}}
                                        {{--name="phone" id="customer-phone"--}}
                                        {{--class="form-control change-filter-room-id gui-input"--}}
                                        {{--placeholder="Số điện thoại">--}}
                                        {{--</label>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-2">--}}
                                        {{--<div class="section mb10" id="page_id">--}}
                                        {{--<label style="width: 100%" for="select" class="field prepend-icon">--}}
                                        {{--<select id="campaign-id"--}}
                                        {{--class="change-filter-room-id form-control" name="agent-id[]"--}}
                                        {{--multiple="multiple">--}}
                                        {{--@foreach($campaign as $item)--}}
                                        {{--<option value="{{$item->id}}">{{ $item->name }}</option>--}}
                                        {{--@endforeach--}}
                                        {{--</select>--}}
                                        {{--<i class="arrow"></i>--}}
                                        {{--</label>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-2">--}}
                                        {{--<div class="section mb10" id="page_id">--}}
                                        {{--<label style="width: 100%" for="select" class="field prepend-icon">--}}
                                        {{--<select id="user-id"--}}
                                        {{--class="change-filter-room-id form-control" name="agent-id[]"--}}
                                        {{--multiple="multiple">--}}
                                        {{--@foreach($employees as $item)--}}
                                        {{--<option value="{{$item->id}}">{{ $item->name }}</option>--}}
                                        {{--@endforeach--}}
                                        {{--</select>--}}
                                        {{--<i class="arrow"></i>--}}
                                        {{--</label>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-3">--}}
                                        {{--<div class="section mb10" id="date-sent-field">--}}
                                        {{--<div class="input-group">--}}
                                        {{--<div class="input-group-addon">--}}
                                        {{--<i class="fa fa-calendar">--}}
                                        {{--</i>--}}
                                        {{--</div>--}}
                                        {{--<input readonly="" type="text" placeholder="Thời gian tạo"--}}
                                        {{--value=""--}}
                                        {{--class="form-control change-filter-room-id pull-right"--}}
                                        {{--name="created_at" id="created_at">--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{----}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="list-history" class="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Tên KH</th>
                        <th>Phone</th>
                        <th>Content SMS</th>
                        <th>Người gửi</th>
                        <th>Trạng thái</th>
                        <th>Ngày gửi</th>
                        <th>Thông báo lôi</th>
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
        var oTableHistory = $('#list-history').DataTable({
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
                url: '{!! url('/admin/customer/getHistory') !!}',
                data: function (d) {
                }
            },
            "columns": [

                {
                    data: 'id', name: 'id', render: function (data) {
                        return '<label class="option block mn"> <input type="checkbox" class="sub_chk" data-id="' + data + '" name="checkbox[]" value="' + data + '"> <span class="checkbox mn"></span> </label>'
                    }
                },
                {data: 'customer_name', name: 'customer_name'},
                {data: 'phone', name: 'phone'},
                {data: 'content', name: 'content'},
                {data: 'user_name', name: 'user_name'},
                {
                    data: 'message', name: 'message', render: function (data, type, row) {
                        var css = '';
                        var name = '';
                        if (data == null) {

                            css = "success";
                            name = "Thành công";
                        } else {
                            css = "fail";
                            name = "Thất bại";
                        }
                        return '<p class="' + css + '">' + name + '</p>';
                    }
                },
                {data: 'created_at', name: 'created_at'},
                {data: 'message', name: 'message'},
            ]
        });
    </script>
    <!-- /.content -->
@endsection
