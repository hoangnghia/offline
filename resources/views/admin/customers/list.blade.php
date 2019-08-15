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
                        <td>STT</td>
                        <td>Tên KH</td>
                        <td>Phone</td>
                        <td>Dịch vụ</td>
                        <td>Chiến dịch</td>
                        <td>Pg</td>
                        <td>Người thân</td>
                        <td>Ngày tạo</td>
                        <td>Tình Trạng</td>
                        <td>Option</td>
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
            pageLength: 100,
            columnDefs: [
                {
                    targets: [0],
                    orderable: false
                },
                {
                    targets: 5,
                    visible: true
                },
            ],
            sPaginationType: "full_numbers",
            dom: '<"top"i>lfrtip',
            language: { // language settings
                "lengthMenu": "Hiển thị _MENU_ kết quả ",
                "info": "Tìm thấy _TOTAL_ kết quả ",
                "infoEmpty": "No records found to show",
                "emptyTable": "No data available in table",
                "zeroRecords": "No matching records found",
                "search": "<i class='fa fa-search'></i>",
                "paginate": {
                    "previous": "Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First",
                    "page": "Page",
                    "pageOf": "of"
                },
                "processing": "Đang xử lý, vui lòng chờ......." //add a loading image,simply putting <img src="loader.gif" /> tag.
            },

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
            columns: [
                {
                    "data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'name', name: 'name', render: function (data, type, row) {
                        return '<a href="{{url('admin/customer/detail') .'/'}}' + row.id + '">' + data + '</a>';
                    }
                },
                {data: 'phone', name: 'phone'},
                {data: 'service_name', name: 'service_name'},
                {data: 'campaign_name', name: 'campaign_name'},
                {data: 'employees_name', name: 'employees_name'},
                {data: 'employees_name', name: 'employees_name'},
                {data: 'created_at', name: 'created_at'},
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

    </script>
    <!-- /.content -->
@endsection
