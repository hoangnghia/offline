@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div id="filter-lead-verified" class="panel mb25 mt5">
                    <a href="javascript:void(0)" class="btn btn-success right customer-crm" role="button"
                       style="float: right;margin-right: 10px">Gửi CRM</a>
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
                                                           placeholder="Số điện thoại KH">
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
                                        {{--<div class="col-md-2">--}}
                                            {{--<select class="form-control change-filter-room-id" id="status-sms">--}}
                                                {{--<option value="">Trạng thái</option>--}}
                                                {{--<option value="999">Chưa chuyển</option>--}}
                                                {{--<option value="888">Đã chuyển</option>--}}
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
                <div style="float: right">
                    <label class="option block mn"
                           style="display: block;    width: 115px; color: red;    font-size: 15px;"><input
                                type="checkbox" id="checkAll"
                                style="float: left;width: 18px;margin-right: 5px; margin-top: 2px;height: 18px;"/><span
                                class="checkbox mn"></span> Chọn Tất Cả</label>
                </div>
                <table id="list-customer" class="table">
                    <thead>
                    <tr>
                        <th >STT</th>
                        <th>Chi nhánh</th>
                        <th>Tên người giới thiệu</th>
                        <th>SĐT Người giới thiệu</th>
                        <th>Tên KH Mới</th>
                        <th>SĐT KH Mới</th>
                        <th>Năm sinh</th>
                        <th>Nội Dung</th>
                        <th>NV CSKH</th>
                        <th>NV Offline</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái Moon</th>
                        <th>Tình Trạng</th>
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
        $(".customer-crm").on("click", function () {
            var arrIds = []
            var checkboxes = document.querySelectorAll('#list-customer input[type=checkbox]:checked')
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].value == 'on')
                    continue;
                arrIds.push(checkboxes[i].value)
            }
            if (arrIds.length == 0) {
                alert('Oh ! Không có phiếu ghi nào được chọn, bạn hay chọn it nhất 1 phiếu nhé !');
                return false;
            }
            var urlCS = "{{url('/admin/cskh/crm')}}?list=" + arrIds.join();
            window.open(urlCS);
            return false;
        });
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
                url: '{!! url('/admin/customer/getListDataIntroduceOffline') !!}',
                data: function (d) {
                    d.name = $('#search-form-customer #customer-name').val();
                    d.phone = $('#search-form-customer #customer-phone').val();
                    d.phone_introduce = $('#search-form-customer #introduce-phone').val();
                    // d.campaign = $('#search-form-customer #campaign-id').val();
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
            ]
        });
    </script>
    <!-- /.content -->
@endsection

