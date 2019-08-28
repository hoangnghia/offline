@extends('layouts.admin.app')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- /.box -->
        <h1 class="title">Tổng</h1>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <p class="card-category">Chiến dịch</p>
                        <h3 class="card-title">{{$totalCampaign}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <p class="card-category">Khách hàng</p>
                        <h3 class="card-title">{{$totalCustomer}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-product-hunt"></i>
                        </div>
                        <p class="card-category">Tin nhắn</p>
                        <h3 class="card-title">{{$totalSms}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-code-fork"></i>
                        </div>
                        <p class="card-category">CareSoft</p>
                        <h3 class="card-title">{{$totalCS}}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
        <h1 class="title">Hôm nay</h1>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <p class="card-category">Chiến dịch</p>
                        <h3 class="card-title">{{$todayCampaign}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <p class="card-category">Khách hàng</p>
                        <h3 class="card-title">{{$todayCustomer}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-product-hunt"></i>
                        </div>
                        <p class="card-category">Tin nhắn</p>
                        <h3 class="card-title">{{$todaySms}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-code-fork"></i>
                        </div>
                        <p class="card-category">CareSoft</p>
                        <h3 class="card-title">{{$todayCS}}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 box-body">
                <h2>Danh sách chiến dịch</h2>
                <table id="list-canmpaign" class="table">
                    <thead>
                    <tr>
                        <td>Tên chiến dịch</td>
                        <td>Taget</td>
                        <td>Ngày bắt đầu</td>
                        <td>Kết thúc</td>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6 box-body">
                <h2>Danh sách nhân viên</h2>
                <table id="list-employees" class="table">
                    <thead>
                    <tr>
                        <td>Tên nhân viên</td>
                        <td>Taget</td>
                        <td>Tên chiến dịch</td>
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

        .top {
            display: none;
        }
    </style>
    <script type="text/javascript">
        var oTableCampaign = $('#list-canmpaign').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 100,
            columnDefs: [
                {
                    targets: [0],
                    orderable: false
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
                url: '{!! url('/admin/getListDatCampaign') !!}',
                data: function (d) {
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                {
                    data: 'taget', name: 'taget', render: function (data, type, row) {
                        return ' <span">' + row.count + '/' + data + '</span> '
                    }

                },
                {data: 'time_start', name: 'time_start'},
                {data: 'time_end', name: 'time_end'},

            ]
        });

        var oTableEmployees = $('#list-employees').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 100,
            columnDefs: [
                {
                    targets: [0],
                    orderable: false
                },
            ],
            sPaginationType: "full_numbers",
            dom: '<"top"i>lfrtip',
            ajax: {
                url: '{!! url('/admin/getListDataUser') !!}',
                data: function (d) {
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                {
                    data: 'taget', name: 'taget', render: function (data, type, row) {
                        return ' <span">' + row.count + '/' + data + '</span> '
                    }
                },

                {data: 'campaign_name', name: 'campaign_name'},
            ]
        });
    </script>
    <!-- /.content -->
@endsection
