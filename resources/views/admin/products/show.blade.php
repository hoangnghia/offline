@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($product)
            <div class="box">
                <div class="box-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <td class="col-md-2">Tên</td>
                            <td class="col-md-3">Mô tả</td>
                            <td class="col-md-3">Hình đại diện</td>
                            <td class="col-md-2">Số lượng</td>
                            <td class="col-md-2">Giá</td>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    @if(isset($product->cover))
                                        <img style="width: 150px" src="{{ $product->cover }}" class="img-responsive" alt="">
                                    @endif
                                </td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ config('cart.currency') }} {{ $product->price }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default btn-sm">Quay lại danh sách</a>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
