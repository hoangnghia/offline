@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action=" @if(isset($services->id)){{ route('admin.services.destroy') }} @else {{ route('admin.services.store') }} @endif " method="post" class="form" id="myForm"
                  enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="col-md-8">
                        <h2 class="text-center">
                            @if(!isset($services->id))Thêm dịch vụ mới @else Cập nhật dịch vụ @endif
                        </h2>
                        <div class="form-group">
                            <label for="name">Tên dịch vụ<span class="text-danger">*</span></label>
                            @if(isset($services->id))
                            <input name="id" value="{{$services->id}}" hidden>
                            @endif
                            <input type="text" name="name" id="name" placeholder="Tên dịch vụ" class="form-control"
                                   value="@if(isset($services->name)) {{$services->name}} @endif" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Ghi chú</label>
                            <textarea class="form-control" name="description" id="description" rows="5"
                                      placeholder="Ghi chú chi tiết">@if(isset($services->descriptions)) {{$services->descriptions}} @endif</textarea>
                        </div>
                        <div class="box-footer" style="    padding-left: 0px;">
                            <div class="btn-group">
                                <a href="{{ route('admin.services.index') }}" class="btn btn-default">Quay lại danh
                                    sách</a>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
    <script type="text/javascript">
        $('#agency-user').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: '-- Danh sách Pg --',
        });
    </script>
@endsection
