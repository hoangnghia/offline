@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <h2>Danh sách đối tác</h2>
                <table id="list-branchs" class="table">
                    <thead>
                    <tr>
                        <td>STT</td>
                        <td>Tên đối tác</td>
                        <td>Số điện thoại</td>
                        <td>Email</td>
                        <td>Địa chỉ</td>
                        <td>Ghi chú</td>
                        <td>Pg</td>
                        <td>Trạng thái</td>
                        <td>Ngày tạo</td>
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
        var oTableBranch = $('#list-branchs').DataTable({
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
                url: '{!! url('/admin/agencys/getListData') !!}',
                data: function (d) {
                }
            },
            columns: [
                {
                    data: 'id', name: 'id', render: function (data) {
                        return '<label class="option block mn"> <input type="checkbox" class="sub_chk" data-id="' + data + '" name="checkbox[]" value="' + data + '"> <span class="checkbox mn"></span> </label>'
                    }
                },
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'note', name: 'note'},
                {data: 'list_user', name: 'list_user'},
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
                        return '<a href="{{url('admin/agencys/status') .'/'}}' + row.id + '" class="btn ' + css + '">' + name + '</a>';
                    }
                },
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'id', name: 'id', render: function (data, type, row) {
                        return '<a href="{{url('admin/agencys/edit') .'/'}}' + row.id +'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> || <a href="{{url('admin/agencys/delete') .'/'}}' + row.id + '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    }
                },
            ]
        });
    </script>
    <!-- /.content -->
@endsection
