@extends('layouts.front.app')
@section('content')
    <div class="insurance">
        <h2 class="fadeIn first">Chiến dịch</h2>
        @foreach ($campaign as $item)
            <?php
            $timeNow = Carbon\Carbon::now()->toDateString();
            $tagetFinish = App\Shop\Customer\Customer::where('local_user_id',$item->local_user_id)
                ->get();
            $finish = count($tagetFinish);
            ?>
            <div class="insurance-list fadeIn second">

                <h4 class="title  @if($timeNow >= $item->time_end)stop @endif">{{$item->name}}</h4>
                <p class="text"><img src="{{ asset('assets/img/content.png') }}"/>Nội dung: {!! $item->note !!}</p>
                <p class="time"><img src="{{ asset('assets/img/stopwatch.png') }}"/>Bắt đầu: {{$item->time_start}}</p>
                <p class="time"><img src="{{ asset('assets/img/stopwatch.png') }}"/>Kết thúc: {{$item->time_end}}</p>
                <p class="address"><img src="{{ asset('assets/img/address.png') }}"/>Tên chợ/ Siêu thị: {{$item->local_name}}</p>
                <p class="address"><img src="{{ asset('assets/img/address.png') }}"/>Địa chỉ: {{$item->address}}</p>
                <p class="target"><img src="{{ asset('assets/img/objective.png') }}"/>{{$finish}}
                    /<b>{{$item->user_taget}}</b>
                </p>
                <div class="button">
                    <a href=" {{url('employee/add') .'/'.$item->local_user_id}}">Thêm khách hàng</a>
                    <a href="{{ url('employee/customer').'/'.$item->local_user_id }}">DS khách hàng</a>
                </div>

            </div>
        @endforeach
    </div>

@endsection