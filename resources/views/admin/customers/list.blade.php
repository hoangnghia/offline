@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($customers)
            <div class="box">
                <div class="box-body">
                    <h2>Danh sách khách hàng</h2>
                    <div class="col-md-4">
                        @include('layouts.search', ['route' => route('admin.customers.index')])
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="col-md-1">ID</td>
                                <td class="col-md-2">Tên khách hàng</td>
                                <td class="col-md-2">Số điện thoại</td>
                                <td class="col-md-2">Email</td>
                                <td class="col-md-2">Tình trạng</td>
                                <td class="col-md-3">Hành động</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer['id'] }}</td>
                                <td>{{ $customer['name'] }}</td>
                                <td>{{ $customer['phone'] }}</td>
                                <td>{{ $customer['email'] }}</td>
                                <td>@include('layouts.status', ['status' => $customer['status']])</td>
                                <td>
                                    <form action="{{ route('admin.customers.destroy', $customer['id']) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            {{--<a href="{{ route('admin.customers.show', $customer['id']) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Show</a>--}}
                                            <a href="{{ route('admin.customers.edit', $customer['id']) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Cập nhật</a>
                                            <button onclick="return confirm('Bạn chắc chắn thực hiện thành động này?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Xóa</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $customers->links() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection