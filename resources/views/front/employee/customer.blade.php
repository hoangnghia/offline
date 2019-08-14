@extends('layouts.front.app')

@section('content')
    <div class="insurance">
        <h2 class="fadeIn first">Danh sách khách hàng</h2>
        @include('layouts.errors-and-messages')
        @foreach ($customer as $item)
        <div class="insurance-list fadeIn second">
            <h4 class="title">{{$item->name}}</h4>
            <p class="time"><img src="{{ asset('assets/img/smartphone.png') }}"/>Số điện thoại: {{str_repeat("x", (strlen($item->phone) - 4)).substr($item->phone,4,4)}}</p>
            <p class="birth"><img src="{{ asset('assets/img/calendar.png') }}"/>Năm sinh: {{$item->birthday}}</p>
            <p class="text"><img src="{{ asset('assets/img/content.png') }}"/>Ghi chú: {{$item->note}}</p>
        </div>
        @endforeach
    </div>
@endsection