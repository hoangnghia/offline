@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.products.update', $product->id) }}" method="post" class="form"
                  enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist" id="tablist">
                                <li role="presentation" @if(!request()->has('combination')) class="active" @endif><a
                                            href="#info" aria-controls="home" role="tab" data-toggle="tab">Thông tin sản
                                        phẩm</a></li>
                                {{--<li role="presentation" @if(request()->has('combination')) class="active" @endif><a href="#combinations" aria-controls="profile" role="tab" data-toggle="tab">Combinations</a></li>--}}
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content" id="tabcontent">
                                <div role="tabpanel" class="tab-pane @if(!request()->has('combination')) active @endif"
                                     id="info">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h2 class="text-center">{{ ucfirst($product->name) }}</h2>
                                            <div class="form-group">
                                                <label for="sku">Mã SP <span class="text-danger">*</span></label>
                                                <input readonly type="text" name="sku" id="sku" placeholder="xxxxx"
                                                       class="form-control" value="{!! $product->sku !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Tên sản phẩm <span
                                                            class="text-danger">*</span></label>
                                                <input onkeyup="ChangeToSlug();" type="text" name="name" id="name" placeholder="Tên sản phẩm"
                                                       class="form-control" value="{!! $product->name !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Mô tả ngắn </label>
                                                <textarea class="form-control" name="description_short"
                                                          id="description-short" rows="3"
                                                          placeholder="Mô tả ngắn">{!! $product->description_short  !!}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Mô tả sản phẩm </label>
                                                <textarea class="form-control ckeditor" name="description"
                                                          id="description" rows="5"
                                                          placeholder="Mô tả chi tiết sản phẩm">{!! $product->description  !!}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <img src="{{ $product->cover }}" alt=""
                                                             class="img-responsive img-thumbnail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"></div>
                                            <div class="form-group">
                                                <label for="cover">Hình đại diện </label>
                                                <input type="file" name="cover" id="cover" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                @foreach($images as $image)
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <img src="{{ asset("storage/$image->src") }}" alt=""
                                                                 class="img-responsive img-thumbnail"> <br/> <br>
                                                            <a style="    width: 50%;margin-left: 35px;"
                                                               onclick="return confirm('Bạn có chắc xóa hình?')"
                                                               href="{{ route('admin.product.remove.thumb', ['src' => $image->src]) }}"
                                                               class="btn btn-danger btn-sm btn-block">Gỡ bỏ?</a><br/>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row"></div>
                                            <div class="form-group">
                                                <label for="image">Hình ảnh </label>
                                                <input type="file" name="image[]" id="image" class="form-control"
                                                       multiple>
                                                <span class="text-warning">Bạn có thể sử dụng Ctr (cmd) để chọn nhiều hình ảnh</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity">Số lượng <span
                                                            class="text-danger">*</span></label>
                                                @if($productAttributes->isEmpty())
                                                    <input
                                                            type="text"
                                                            name="quantity"
                                                            id="quantity"
                                                            placeholder="Quantity"
                                                            class="form-control"
                                                            value="{!! $product->quantity  !!}"
                                                    >
                                                @else
                                                    <input type="hidden" name="quantity" value="{{ $qty }}">
                                                    <input type="text" value="{{ $qty }}" class="form-control" disabled>
                                                @endif
                                                @if(!$productAttributes->isEmpty())<span class="text-danger">Lưu ý: Số lượng bị vô hiệu hóa.</span> @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity">Số lượng mua tối đa</label>
                                                <input type="text" name="quantity_buy" id="quantity-buy"
                                                       placeholder="Số lượng mua tối đa"
                                                       class="form-control" value="{!! $product->quantity_buy  !!}">
                                                <small class="text-warning">Số lượng tối đa khách hàng được phép mua
                                                    trên một sản phẩm
                                                </small>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity">Thời gian có thể mua lại</label>
                                                <input type="number" name="timer_buy" id="timer-buy"
                                                       placeholder="Thời gian tối đa có thể mua (đơn vị tính trên ngày)"
                                                       class="form-control" value="{!! $product->timer_buy  !!}">
                                                <small class="text-warning">Khoảng thời gian tối đa mà khách hàng có thể
                                                    mua lại dịch vụ
                                                </small>
                                            </div>
                                            <div class="form-group">
                                                <label for="price">Giá sản phẩm</label>
                                                @if($productAttributes->isEmpty())
                                                    <div class="input-group">
                                                        <span class="input-group-addon">{{ config('cart.currency') }}</span>
                                                        <input type="text" name="price" id="price"
                                                               placeholder="Giá sản phẩm" class="form-control"
                                                               value="{!! $product->price !!}">
                                                    </div>
                                                @else
                                                    <input type="hidden" name="price" value="{!! $product->price !!}">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">{{ config('cart.currency') }}</span>
                                                        <input type="text" id="price" placeholder="Giá sản phẩm"
                                                               class="form-control" value="{!! $product->price !!}"
                                                               disabled>
                                                    </div>
                                                @endif
                                                @if(!$productAttributes->isEmpty())<span class="text-danger">Lưu ý: Giá bị vô hiệu hóa.</span> @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="sale_price">Giá khuyến mãi</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{ config('cart.currency') }}</span>
                                                    <input type="text" name="sale_price" id="sale_price"
                                                           placeholder="Giá khuyến mãi" class="form-control"
                                                           value="{{ $product->sale_price }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="date_sale">Thời gian khuyến mãi</label>
                                                <div class="input-group">
                                                    <input type="datetime-local" name="date_sale" id="date_sale"
                                                           placeholder="Giá khuyến mãi" class="form-control"
                                                           value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($product->date_sale))}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                @include('admin.shared.status-select', ['status' => $product->status])
                                            </div>
                                            <div class="form-group">
                                                <label for="best_sale">Dịch vụ bán chạy </label>
                                                <select name="best_sale" id="best_sale" class="form-control select2">
                                                    <option value="0"
                                                            @if($product->best_sale == 0) selected="selected" @endif>No
                                                    </option>
                                                    <option value="1"
                                                            @if($product->best_sale == 1) selected="selected" @endif>Yes
                                                    </option>
                                                </select>
                                            </div>
                                        {{--@include('admin.shared.attribute-select', [compact('default_weight')])--}}
                                        <!-- /.box-body -->
                                        </div>
                                        <div class="col-md-4">
                                            <div id="postimagediv" class="postbox ">
                                                <h3>Danh mục sản phẩm</h3>
                                                @include('admin.shared.categories', ['categories' => $categories, 'ids' => $product])
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
                                                    <a href="{{ route('admin.products.index') }}"
                                                       class="btn btn-default">Quay lại danh sách</a>
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div role="tabpanel" class="tab-pane @if(request()->has('combination')) active @endif" id="combinations">--}}
                                {{--<div class="row">--}}
                                {{--<div class="col-md-4">--}}
                                {{--@include('admin.products.create-attributes', compact('attributes'))--}}
                                {{--</div>--}}
                                {{--<div class="col-md-8">--}}
                                {{--@include('admin.products.attributes', compact('productAttributes'))--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
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
            font-size: 18px;
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
@endsection
@section('css')
    <style type="text/css">
        label.checkbox-inline {
            padding: 10px 5px;
            display: block;
            margin-bottom: 5px;
        }

        label.checkbox-inline > input[type="checkbox"] {
            margin-left: 10px;
        }

        ul.attribute-lists > li > label:hover {
            background: #3c8dbc;
            color: #fff;
        }

        ul.attribute-lists > li {
            background: #eee;
        }

        ul.attribute-lists > li:hover {
            background: #ccc;
        }

        ul.attribute-lists > li {
            margin-bottom: 15px;
            padding: 15px;
        }
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        function backToInfoTab() {
            $('#tablist > li:first-child').addClass('active');
            $('#tablist > li:last-child').removeClass('active');

            $('#tabcontent > div:first-child').addClass('active');
            $('#tabcontent > div:last-child').removeClass('active');
        }

        $(document).ready(function () {
            const checkbox = $('input.attribute');
            $(checkbox).on('change', function () {
                const attributeId = $(this).val();
                if ($(this).is(':checked')) {
                    $('#attributeValue' + attributeId).attr('disabled', false);
                } else {
                    $('#attributeValue' + attributeId).attr('disabled', true);
                }
                const count = checkbox.filter(':checked').length;
                if (count > 0) {
                    $('#productAttributeQuantity').attr('disabled', false);
                    $('#productAttributePrice').attr('disabled', false);
                    $('#salePrice').attr('disabled', false);
                    $('#default').attr('disabled', false);
                    $('#createCombinationBtn').attr('disabled', false);
                    $('#combination').attr('disabled', false);
                } else {
                    $('#productAttributeQuantity').attr('disabled', true);
                    $('#productAttributePrice').attr('disabled', true);
                    $('#salePrice').attr('disabled', true);
                    $('#default').attr('disabled', true);
                    $('#createCombinationBtn').attr('disabled', true);
                    $('#combination').attr('disabled', true);
                }
            });
        });
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