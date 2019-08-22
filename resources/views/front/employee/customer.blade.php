@extends('layouts.front.app')

@section('content')
    <div class="insurance bg-n">
        <h2 class="fadeIn first">Danh sách khách hàng</h2>
        @include('layouts.errors-and-messages')
        <div class="insurance-list fadeIn second only-pc">
            <h4 class="title">Tên khách hàng</h4>
            <p class="time"><img src="http://offline.ngocdung.net/assets/img/smartphone.png"/>Số điện thoại</p>
            <p class="birth"><img src="http://offline.ngocdung.net/assets/img/calendar.png"/>Năm sinh</p>
            <p class="text"><img src="http://offline.ngocdung.net/assets/img/content.png"/>Ghi chú</p>
        </div>
        @foreach ($customer as $item)
            <div class="insurance-list fadeIn second">
                <h4 class="title">{{$item->name}}</h4>
                <p class="time"><img src="http://offline.ngocdung.net/assets/img/smartphone.png"/>{{str_repeat("x", (strlen($item->phone) - 4)).substr($item->phone,4,4)}}</p>
                <p class="birth"><img src="http://offline.ngocdung.net/assets/img/calendar.png"/>{{$item->birthday}}</p>
                <p class="text"><img src="http://offline.ngocdung.net/assets/img/content.png"/>{{$item->note}}</p>
            </div>
        {{--<div class="insurance-list fadeIn second only-pc">--}}
            {{--<h4 class="title">{{$item->name}}</h4>--}}
            {{--<p class="time"><img src="{{ asset('assets/img/smartphone.png') }}"/>Số điện thoại: {{str_repeat("x", (strlen($item->phone) - 4)).substr($item->phone,4,4)}}</p>--}}
            {{--<p class="birth"><img src="{{ asset('assets/img/calendar.png') }}"/>Năm sinh: {{$item->birthday}}</p>--}}
            {{--<p class="text"><img src="{{ asset('assets/img/content.png') }}"/>Ghi chú: {{$item->note}}</p>--}}
        {{--</div>--}}
        @endforeach
        {{ $customer->links() }}
    </div>
@endsection