@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.categories.store') }}" method="post" class="form" enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="parent">Danh mục cha</label>
                        <select name="parent" id="parent" class="form-control select2">
                            <option value="">-- Chọn --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Tên danh mục" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả danh mục </label>
                        <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Mô tả danh mục">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="cover">Hình đại diện </label>
                        <input type="file" name="cover" id="cover" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="status">Tình trạng </label>
                        <select name="status" id="status" class="form-control">
                            <option value="0">Vô hiệu hóa</option>
                            <option value="1">Hiển thị</option>
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default">Quay lại danh sách</a>
                        <button type="submit" class="btn btn-primary">Tạo mới</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
