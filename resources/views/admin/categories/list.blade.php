@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($categories)
            <div class="box">
                <div class="box-body">
                    <h2 style="display: inline-block">Danh mục sản phẩm</h2>
                    <a style="float: right" href="{{ route('admin.categories.sync.zalo') }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Đồng bộ zalo</a>
                    <table class="table hover">
                        <thead>
                            <tr>
                                <td class="col-md-3">Tên danh mục</td>
                                <td class="col-md-3">Hình đại diện</td>
                                <td class="col-md-3">Tình trạng</td>
                                <td class="col-md-3">Hành động</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.categories.show', $category->id) }}">{{ $category->name }}</a></td>
                                <td>
                                    @if(isset($category->cover))
                                        <img style="width: 100px" src="{{ asset("storage/$category->cover") }}" alt="" class="img-responsive">
                                    @endif
                                </td>
                                <td>@include('layouts.status', ['status' => $category->status])</td>
                                <td>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Cập nhật</a>
                                            <button onclick="return confirm('Bạn có chắc chắn xóa danh mục này')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Xóa</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
