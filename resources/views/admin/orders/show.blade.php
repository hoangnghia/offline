@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-6">
                        <h2>
                            <a href="{{ route('admin.customers.show', $customer->id) }}"><i class="fa fa-user"></i> {{$customer->name}}</a> <br/>
                            <small>{{$customer->phone}}</small>
                            <br/>
                            {{--<small>Reference: <strong>{{$order->reference}}</strong></small>--}}
                            {{--<br/>--}}
                            <small>Order: <strong>ODR_{{$order->id}}</strong></small>
                        </h2>
                    </div>
                    <div class="col-md-3 col-md-offset-3">
                        <h2><a href="{{route('admin.orders.invoice.generate', $order['id'])}}"
                               class="btn btn-primary btn-block"><i class="fa fa-inverse"></i> Tải xuống hóa
                                đơn</a></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <h4><i class="fa fa-shopping-bag"></i> Thông tin đơn hàng</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <td class="col-md-3">Thời gian tạo</td>
                        <td class="col-md-3">Khách hàng</td>
                        <td class="col-md-3">Loại thanh toán</td>
                        <td class="col-md-3">Tình trạng</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ date('d-m-Y H:i:s', strtotime($order->created_at)) }}</td>
                        <td><a href="{{ route('admin.customers.show', $customer->id) }}">{{ $customer->name }}</a></td>
                        <?php
                        $logo = '';
                        if ($order->payment == 'momo')
                            $logo = 'assets/img/momo_logo.png'
                        ?>
                        <td><strong><img src="{{ asset($logo) }}" alt=""></strong></td>
                        <td>{{!is_null($order->orderPayment->local_message) ? $order->orderPayment->local_message : ''}}</td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bg-warning">Thành tiền</td>
                        <td class="bg-warning">{{ number_format($order['total_products']) }} đ</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bg-success text-bold">Tổng tiền</td>
                        <td class="bg-success text-bold">{{ number_format($order['total']) }} đ</td>
                    </tr>
                    {{--@if($order['total_paid'] != $order['total'])--}}
                    {{--<tr>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td class="bg-danger text-bold">Total paid</td>--}}
                    {{--<td class="bg-danger text-bold">{{ $order['total_paid'] }}</td>--}}
                    {{--</tr>--}}
                    {{--@endif--}}
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        @if($order)
            {{--@if($order->total != $order->total_paid)--}}
            {{--<p class="alert alert-danger">--}}
            {{--Ooops, there is discrepancy in the total amount of the order and the amount paid. <br />--}}
            {{--Total order amount: <strong>{{ config('cart.currency') }} {{ $order->total }}</strong> <br>--}}
            {{--Total amount paid <strong>{{ config('cart.currency') }} {{ $order->total_paid }}</strong>--}}
            {{--</p>--}}

            {{--@endif--}}
            <div class="box">
                @if(!$items->isEmpty())
                    <div class="box-body">
                        <h4><i class="fa fa-gift"></i> Danh sách sản phẩm</h4>
                        <table class="table">
                            <thead>
                            <th class="col-md-2">Mã SP</th>
                            <th class="col-md-2">Tên sản phẩm</th>
                            <th class="col-md-2">Mô tả sản phẩm</th>
                            <th class="col-md-2">Số lượng</th>
                            <th class="col-md-2">Giá</th>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>PRO_{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        {!! $item->description !!}
                                        @php($pattr = \App\Shop\ProductAttributes\ProductAttribute::find($item->product_attribute_id))
                                        @if(!is_null($pattr))<br>
                                        @foreach($pattr->attributesValues as $it)
                                            <p class="label label-primary">{{ $it->attribute->name }}
                                                : {{ $it->value }}</p>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $item->pivot->quantity }}</td>
                                    <td>{{ number_format($item->price) }} đ</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                {{--<div class="box-body">--}}
                {{--<div class="row">--}}
                {{--<div class="col-md-6">--}}
                {{--<h4> <i class="fa fa-map-marker"></i> Address</h4>--}}
                {{--<table class="table">--}}
                {{--<thead>--}}
                {{--<th>Address 1</th>--}}
                {{--<th>Address 2</th>--}}
                {{--<th>City</th>--}}
                {{--<th>Province</th>--}}
                {{--<th>Zip</th>--}}
                {{--<th>Country</th>--}}
                {{--<th>Phone</th>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                {{--<tr>--}}
                {{--<td>{{ $order->address->address_1 }}</td>--}}
                {{--<td>{{ $order->address->address_2 }}</td>--}}
                {{--<td>{{ $order->address->city }}</td>--}}
                {{--<td>--}}
                {{--@if(isset($order->address->province))--}}
                {{--{{ $order->address->province->name }}--}}
                {{--@endif--}}
                {{--</td>--}}
                {{--<td>{{ $order->address->zip }}</td>--}}
                {{--<td>{{ $order->address->country->name }}</td>--}}
                {{--<td>{{ $order->address->phone }}</td>--}}
                {{--</tr>--}}
                {{--</tbody>--}}
                {{--</table>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>
            <!-- /.box -->
            <div class="box-footer">
                <div class="btn-group">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-default">Quay lại danh sách</a>
                    @if($user->hasPermission('update-order'))<a href="{{ route('admin.orders.edit', $order->id) }}"
                                                                class="btn btn-primary">Cập nhật</a>@endif
                </div>
            </div>
        @endif

    </section>
    <!-- /.content -->
@endsection