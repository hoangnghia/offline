@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.agencys.destroy') }}" method="post" class="form" id="myForm"
                  enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="col-md-8">
                        <h2 class="text-center">
                            Thêm đối tác mới</h2>
                        <div class="form-group">
                            <label for="name">Tên đối tác<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" placeholder="Tên đối tác" class="form-control"
                                   value="{{$agency->name}}">
                            <input type="text" name="id" id="id" placeholder="Tên đối tác" class="form-control"
                                   style="display: none"
                                   value="{{$agency->id}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Số điện thoại<span class="text-danger">*</span></label>
                            <input type="number" name="phone" id="phone" placeholder="Số điện thoại"
                                   class="form-control"
                                   value="{{$agency->phone}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" placeholder="Email" class="form-control"
                                   value="{{$agency->email}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Địa chỉ<span class="text-danger">*</span></label>
                            <input type="text" name="address" id="address" placeholder="Địa chỉ" class="form-control"
                                   value="{{$agency->address}}">
                        </div>
                        <div class="form-group" id="local-hide">
                            <label for="name">Danh sách Pg : </label>
                            <select class="form-control"
                                    id="agency-user" multiple="multiple"
                                    name="agency_user[]">
                                @foreach($user as $item)
                                    <option
                                            value="{{ $item->id }}"
                                            @foreach($employeesAgency as $employeesAgencyItem)
                                            @if($employeesAgencyItem->employees_id == $item->id) selected="selected" @endif
                                            @endforeach
                                    >{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Ghi chú</label>
                            <textarea class="form-control" name="description" id="description" rows="5"
                                      placeholder="Ghi chú chi tiết">{{$agency->note}}</textarea>
                        </div>

                        <div class="box-footer" style="    padding-left: 0px;">
                            <div class="btn-group">
                                <a href="{{ route('admin.agencys.index') }}" class="btn btn-default">Quay lại danh
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
