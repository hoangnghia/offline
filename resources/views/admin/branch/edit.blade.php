@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.branch.updata') }}" method="post" class="form" id="myForm"
                  enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <h2 class="text-center">
                            Cập nhật chi nhánh</h2>
                        <div class="form-group">
                            <label for="name">Tên chi nhánh<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" placeholder="Tên chi nhánh" class="form-control"
                                   value="{{ $branch->name }}">
                            <input type="text" id="id" name="id" value="{{$branch->id}}" hidden>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả </label>
                            <textarea class="form-control" name="description" id="description" rows="5"
                                      placeholder="Mô tả chi tiết">{{ $branch->description }}</textarea>
                        </div>
                        {{--<div class="form-group">--}}
                        {{--<label for="type">Loại<span class="text-danger">*</span></label>--}}
                        {{--<select name="type" id="type" class="form-control select">--}}
                        {{--<option value="0"--}}
                        {{--@if($branch->type == 0) selected="selected" @endif>Siêu thị--}}
                        {{--</option>--}}
                        {{--<option value="1"--}}
                        {{--@if($branch->type == 1) selected="selected" @endif>Chợ--}}
                        {{--</option>--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        <div class="form-group" id="dynamicTable">
                            <label for="name" style="width: 100%;">Tên local</label>
                            @foreach($local as $localItem)
                                <div class="local">
                                    <input style="width: 30%;display: inline-block;  margin-bottom: 5px;margin-right: 4px;"
                                           type="text" name="addmore" placeholder="Tên local"
                                           value="{{$localItem->name}}" class="form-control"/>
                                    <input type="text"
                                           style="width: 30%;display: inline-block; margin-bottom: 5px;margin-right: 5px;"
                                           name="addmore-address" value="{{$localItem->address}}" placeholder="Địa chỉ"
                                           class="form-control"/>
                                    <select style="width: 30%;display: inline-block; margin-bottom: 5px" name="type"
                                            id="type" class="form-control select">
                                        <option value="0" @if($localItem->type == 0) selected @endif>Siêu thị</option>
                                        <option value="1" @if($localItem->type == 1) selected @endif>Chợ</option>
                                    </select>
                                    <button type="button" class="btn btn-danger remove-div">Xóa</button>
                                </div>
                            @endforeach
                        </div>
                        <button style="display: block" type="button" name="add" id="add" class="btn btn-success">Thêm
                            local
                        </button>
                        <div class="box-footer" style="padding-left: 0px;">
                            <div class="btn-group">
                                <a href="{{ route('admin.branch.index') }}" class="btn btn-default">Quay lại danh
                                    sách</a>
                                <button type="button" class="btn btn-primary" onclick="submitform(event)">Cập nhật
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
        var i = 0;
        $("#add").click(function () {
            ++i;
            $("#dynamicTable").append('<div class="local"><input style="width: 30%;display: inline-block;  margin-bottom: 5px;margin-right: 4px;" type="text" name="addmore" placeholder="Tên local" class="form-control"/><input type="text" style="width: 30%;display: inline-block; margin-bottom: 5px;margin-right: 5px;" name="addmore-address" placeholder="Địa chỉ" class="form-control"/><select style="width: 30%;display: inline-block; margin-bottom: 5px;margin-right: 5px;" name="type" id="type" class="form-control select"><option value="0">Siêu thị</option><option value="1">Chợ</option></select><button type="button" class="btn btn-danger remove-div">Xóa</button></div>');
            // $("#dynamicTable").append('<tr><td><input type="text" name="addmore[' + i + '][name]" placeholder="Enter your Name" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][qty]" placeholder="Enter your Qty" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][price]" placeholder="Enter your Price" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        });
        $(document).on('click', '.remove-div', function () {
            $(this).parents(".local").remove();
        });

        function submitform(e) {
            e.preventDefault(e)
            var localsData = [];
            $(".local").each(function () {
                var localData = {};
                localData.addmore = $(this).find("[name=addmore]").val()
                localData["addmore-address"] = $(this).find("[name=addmore-address]").val()
                localData["type"] = $(this).find("[name=type]").val()
                localsData.push(localData);
            })
            var name = $("#name").val();
            var id = $("#id").val();
            var description = $("#description").val();
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': ' {{csrf_token()}}'
                },
                dataType: 'json',
                url: '{{url('/admin/branchs/updata')}}',
                data: {
                    name: name,
                    local: localsData,
                    description: description,
                    id: id
                },
            }).done(function (response) {
                if (response.result) {
                    alert('Cập nhật chi nhánh thành công ! ');
                    window.location = '{{url('/admin/branch')}}';
                } else {
                    alert('WTF!!! Có lỗi trong quá trình, liên hệ IT ngay nhé.');
                }
            });
        }
    </script>
@endsection
