@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($orders)
            <div class="box">
                <div class="box-body">
                    <h2>Danh sách đơn hàng</h2>
                    <div class="col-md-4">
                        @include('layouts.search', ['route' => route('admin.orders.index')])
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <td class="col-md-1">Order ID</td>
                            <td class="col-md-2">Thời gian tạo</td>
                            <td class="col-md-2">Khách hàng</td>
                            <td class="col-md-2">Loại thanh toán</td>
                            <td class="col-md-2">Tổng tiền</td>
                            <td class="col-md-2">Tình trạng</td>
                            <td class="col-md-1">Hành động</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td><a title="Show order"
                                       href="{{ route('admin.orders.show', $order->id) }}">{{ date('d-m-Y H:i:s', strtotime($order->created_at)) }}</a>
                                </td>
                                @if(!is_null($order->customer->url))
                                    <td><a target="_blank" href="{{$order->customer->url}}"
                                           title="Click để xem Khách hàng trên Moon">{{$order->customer->name}}</a></td>
                                @else
                                    <td>{{ $order->customer->name }}</td>
                                @endif
                                <?php
                                $logo = '';
                                if ($order->payment == 'momo')
                                    $logo = 'assets/img/momo_logo.png'
                                ?>
                                <td><img src="{{ asset($logo) }}" alt=""></td>
                                <td>
                                    <span class="">{{ number_format($order->total) }} đ</span>
                                </td>
                                <td>{{!is_null($order->orderPayment->local_message) ? $order->orderPayment->local_message : ''}}</td>
                                {{--<td><p class="text-center"--}}
                                {{--style="color: #ffffff; background-color: {{ $order->status->color }}">{{ $order->status->name }}</p>--}}
                                {{--</td>--}}
                                <td>
                                    <div class="input-group">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"> <span
                                                    class="input-group-btn"><button
                                                        class="btn btn-primary btn-sm">Chi tiết</button></span></a>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"> <span
                                                    class="input-group-btn"><button
                                                        class="btn btn-default btn-sm">Re-send SMS</button></span></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{ $orders->links() }}
                </div>
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection