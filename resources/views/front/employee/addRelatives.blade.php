@extends('layouts.front.app')

@section('content')

    <div id="formContent">
        <h2 class="fadeIn first"> Thêm người thân của {{$customer->name}}</h2>
        @include('layouts.errors-and-messages')
        <form id="add-campaign" action="{{ route('employee.postAddRelatives') }}" method="post" class="form"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="text" id="login" class="fadeIn second" name="name" placeholder="Họ và tên" required>
            <input type="text" id="login" class="fadeIn second" name="customer" value="{{$customer->id}}" style="display: none">
            <input type="text" id="Name" class="fadeIn second" name="phone" placeholder="Số điện thoại" required>
            <input type="date" id="Birthday" class="form-control" name="date" placeholder="Năm sinh">
            <select name="service" id="service" class="fadeIn second">
                <option selected disabled>Chọn dịch vụ</option>
                @foreach($service as $item)
                    <option value="{{$item->service_id}}">{{$item->name_service}}</option>
                @endforeach
            </select>
            <textarea class="fadeIn second" name="note" placeholder="Thông tin thêm...." tabindex="5"></textarea>
            <input type="submit" class="fadeIn fourth" name="submit" value="Thêm khách hàng">
            <input type="submit" class="fadeIn fourth" name="submit" value="Thêm người thân">
        </form>
    </div>
@endsection