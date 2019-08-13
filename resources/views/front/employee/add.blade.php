@extends('layouts.front.app')

@section('content')
    <div id="formContent">
        <h2 class="fadeIn first"> Thêm khách hàng </h2>
        <!-- <div class="fadeIn first">
          <img src="img/logo-1.png" id="icon" alt="User Icon" />
        </div> -->
        <form id="add-campaign" action="{{ route('employee.add') }}" method="post" class="form"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="text" id="login" class="fadeIn second" name="name" placeholder="Họ và tên" required>
            <input type="text" id="login" class="fadeIn second" name="local_id" value="{{$id}}" style="display: none">
            <input type="text" id="Name" class="fadeIn second" name="phone" placeholder="Số điện thoại" required>
            <input type="date" id="Birthday" class="form-control" name="date" placeholder="Năm sinh">
            {{--<input type="email" id="Email" class="fadeIn second" name="email" placeholder="Email">--}}
            <select name="service" id="service" class="fadeIn second">
                <option selected disabled>Chọn dịch vụ</option>
                @foreach($service as $item)
                    <option value="{{$item->service_id}}">{{$item->name_service}}</option>
                @endforeach
            </select>
            <textarea class="fadeIn second" name="note" placeholder="Thông tin thêm...." tabindex="5"></textarea>
            <input type="submit" class="fadeIn fourth" value="Thêm">
        </form>
    </div>
@endsection