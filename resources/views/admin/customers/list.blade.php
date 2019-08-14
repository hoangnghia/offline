@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <h2>Brands</h2>
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
    </style>
    <script type="text/javascript">
        var oTableBranch = $('#list-customer').DataTable({
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
                }
            },
            columns: [
                {
                    "data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                // {data: 'name', name: 'name'},
                {
                    data: 'name', name: 'name', render: function (data, type, row) {
                        return '<a href="{{url('admin/customer/detail') .'/'}}' + row.id + '">' + data + '</a>';
                    }
                },
                {data: 'phone', name: 'phone'},
                {data: 'service_name', name: 'service_name'},
                {data: 'campaign_name', name: 'campaign_name'},
                {data: 'employees_name', name: 'employees_name'},
                {data: 'name_parent', name: 'name_parent'},
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
    </script>
    <!-- /.content -->
@endsection
