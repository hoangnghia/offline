@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('layouts.errors-and-messages')
        <!-- Default box -->
        <div class="box">
            <form action="{{ route('admin.commerce.update', 1) }}" method="post">
            <div class="box-body">
                <h3>Cấu hình mua hàng</h3>
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                <div class="form-group">
                    <label for="name">Số lượng mua tối đa</label>
                    <input class="form-control" type="text" name="quantity_buy" id="quantity-buy" value="{!! $quantityBuy->value ?: old('quantity_buy')  !!}" placeholder="Số lượng mua tối đa">
                    <small class="text-warning">Số lượng tối đa khách hàng được phép mua trên một sản phẩm</small>
                </div>
                <div class="form-group">
                    <label for="color">Thời gian có thể mua lại</label>
                    <input class="form-control" type="text" name="timer_buy" id="timer-buy" placeholder="Thời gian có thể mua lại" value="{!! $timerBuy->value ?: old('timer_buy')  !!}">
                    <small class="text-warning">Khoảng thời gian tối đa mà khách hàng có thể mua lại sản phẩm (ngày) </small>
                </div>
            </div>
            <!-- /.box-body -->
                <div class="box-footer btn-group">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
