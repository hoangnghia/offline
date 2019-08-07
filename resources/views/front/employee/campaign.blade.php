@extends('layouts.front.app')
@section('content')
    <div class="insurance">
        <h2 class="fadeIn first">Chiến dịch</h2>
        @foreach ($campaign as $item)
            <?php $customer = App\Shop\Customer\Customer::where('campaign_id', $item->id)->get();
            $teget = count($customer);
            ?>
            <div class="insurance-list fadeIn second">
                <h4 class="title stop">{{$item->name}}</h4>
                <p class="text"><img src="{{ asset('assets/img/content.png') }}"/>Nội dung: {!! $item->note !!}</p>
                <p class="time"><img src="{{ asset('assets/img/stopwatch.png') }}"/>Bắt đầu: {{$item->time_start}}</p>
                <p class="time"><img src="{{ asset('assets/img/stopwatch.png') }}"/>Kết thúc: {{$item->time_end}}</p>
                <p class="address"><img src="{{ asset('assets/img/address.png') }}"/>Địa chỉ: {{$item->nameAddress}}</p>
                <p class="target"><img src="{{ asset('assets/img/objective.png') }}"/>{{$teget}}/<b>{{$item->taget}}</b>
                </p>
                <div class="button">
                    <a href=" {{url('employee/add') .'/'.$item->id}}">Thêm khách hàng</a>
                    <a href="{{ url('employee/customer').'/'.$item->id }}">DS khách hàng</a>
                </div>
                @endforeach
            </div>
    </div>
@endsection