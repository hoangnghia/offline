@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('layouts.errors-and-messages')
        <!-- Default box -->
        @if($employees)
        <div class="box">
            <div class="box-body">
                <h2>Nhân viên</h2>
                <table class="table hover">
                    <thead>
                        <tr>
                            <td class="col-md-1">ID</td>
                            <td class="col-md-4">Tên nhân viên</td>
                            <td class="col-md-3">Email</td>
                            <td class="col-md-2">Tình trạng</td>
                            <td class="col-md-2">Hành động</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                <form action="{{ route('admin.employee.status', $employee->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    @if($employee->status == 1)

                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                                    @else
                                        <span style="display: none; visibility: hidden">0</span>
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                    @endif
                                </form>
                            <td>
                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Cập nhật</a>
                                        <button onclick="return confirm('Bạn chắc chắn thực hiện thành động này?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Xóa</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $employees->links() }}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
