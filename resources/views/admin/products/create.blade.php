@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.products.store') }}" method="post" class="form" enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="col-md-8">
                        <h2 class="text-center">
                            Thêm sản phẩm mới</h2>
                        <div class="form-group">
                            <label for="sku">Mã SP <span class="text-danger">*</span></label>
                            <input type="text" name="sku" readonly id="sku" placeholder="xxxxx" class="form-control"
                                   value="{{ old('sku') }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" onkeyup="ChangeToSlug();" name="name" id="name" placeholder="Tên sản phẩm" class="form-control"
                                   value="{{ old('name') }}">
                        </div>
                        {{--<div class="form-group">--}}
                        {{--<label for="name">Danh mục sản phẩm<span class="text-danger">*</span></label>--}}
                        {{--@include('admin.shared.categories', ['categories' => $categories, 'selectedIds' => []])--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label for="description">Mô tả </label>
                            <textarea class="form-control" name="description" id="description" rows="5"
                                      placeholder="Mô tả chi tiết sản phẩm">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="cover">Hình đại diện </label>
                            <input type="file" name="cover" id="cover" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="image">Hình ảnh</label>
                            <input type="file" name="image[]" id="image" class="form-control" multiple>
                            <small class="text-warning">Bạn có thể sử dụng Ctr (cmd) để chọn nhiều hình ảnh</small>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Số lượng <span class="text-danger">*</span></label>
                            <input type="text" name="quantity" id="quantity" placeholder="Số lượng tồn kho"
                                   class="form-control" value="{{ old('quantity') }}">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Số lượng mua tối đa</label>
                            <input type="text" name="quantity_buy" id="quantity-buy" placeholder="Số lượng mua tối đa"
                                   class="form-control" value="{{ old('quantity_buy') }}">
                            <small class="text-warning">Số lượng tối đa khách hàng được phép mua trên một sản phẩm
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Thời gian có thể mua lại</label>
                            <input type="number" name="timer_buy" id="timer-buy"
                                   placeholder="Thời gian tối đa có thể mua (đơn vị tính trên ngày)"
                                   class="form-control" value="{{ old('timer_buy') }}">
                            <small class="text-warning">Khoảng thời gian tối đa mà khách hàng có thể mua lại dịch vụ
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="price">Giá sản phẩm <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon">VNĐ</span>
                                <input type="text" name="price" id="price" placeholder="Giá sản phẩm"
                                       class="form-control" value="{{ old('price') }}">
                            </div>
                        </div>
                        {{--@if(!$brands->isEmpty())--}}
                        {{--<div class="form-group">--}}
                        {{--<label for="brand_id">Brand </label>--}}
                        {{--<select name="brand_id" id="brand_id" class="form-control select2">--}}
                        {{--<option value=""></option>--}}
                        {{--@foreach($brands as $brand)--}}
                        {{--<option @if(old('brand_id') == $brand->id) selected="selected" @endif value="{{ $brand->id }}">{{ $brand->name }}</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        {{--@endif--}}
                        <div class="form-group">
                            @include('admin.shared.status-select', ['status' => 0])
                        </div>

                        <div class="form-group">
                            <label for="best_sale">Dịch vụ bán chạy </label>
                            <select name="best_sale" id="best_sale" class="form-control select2">
                                <option value="0"
                                        @if(old('status') == 0) selected="selected" @endif>No
                                </option>
                                <option value="1"
                                        @if(old('status') == 1) selected="selected" @endif>Yes
                                </option>
                            </select>
                        </div>
                        {{--                        @include('admin.shared.attribute-select', [compact('default_weight')])--}}
                    </div>
                    <div class="col-md-4">
                        <div id="postimagediv" class="postbox ">
                            <h3>Danh mục sản phẩm</h3>
                            @include('admin.shared.categories', ['categories' => $categories, 'selectedIds' => []])
                        </div>
                        <div id="postimagediv" style="margin-top: 10px;" class="postbox ">
                            <h3>Đồng bộ sản phẩm lên Social</h3>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="shop[]" value="facebook">
                                    Facebook Shop
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="shop[]" value="instagram">
                                    Instagram Shop
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="shop[]" value="zalo">
                                    Zalo Shop
                                </label>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="btn-group">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-default">Quay lại danh
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
    <style>
        @media only screen and (min-width: 767px) {
            #postimagediv {
                margin-top: 78px;
            }
        }

        .postbox {
            position: relative;
            border: 1px solid #e5e5e5;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
            background: #fff;
            margin-top: 10px;
        }

        .postbox h3 {
            font-weight: bold;
            font-size: 17px;
            color: #29328a;
            margin: 0 0 14px 0;
            padding: 8px 12px;
            line-height: 1.4;
            border-bottom: 1px solid #eee;
        }

        .postbox .checkbox {
            padding: 8px 12px;
            margin: 0;
            line-height: 1.4;
        }
    </style>
    <script>
        function ChangeToSlug()
        {
            var title, slug;

            //Lấy text từ thẻ input title
            title = document.getElementById("name").value;

            //Đổi chữ hoa thành chữ thường
            slug = title.toLowerCase();

            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('sku').value = slug;
        }
    </script>
@endsection
