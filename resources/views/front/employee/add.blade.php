@extends('layouts.front.app')

@section('content')
    @include('layouts.errors-and-messages')
    <div id="formContent">
        <h2 class="fadeIn first"> Thêm khách hàng </h2>
        @include('layouts.errors-and-messages')
        <form id="add-campaign" action="{{ route('employee.add') }}" method="post" class="form"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="text" id="login" class="fadeIn second" name="name" placeholder="Họ và tên" required>
            <input type="text" id="login" class="fadeIn second" name="local_id" value="{{$id}}" style="display: none">
            <input type="text" id="phone" class="fadeIn second" name="phone" placeholder="Số điện thoại" required>
            <input type="text" data-mask="00/00/0000" data-mask-selectonfocus="true" name="date" placeholder="Ngày/Tháng/Năm sinh" />
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
        $("#phone").change(function () {
            var phone = $('#phone').val().length
            if (phone != 10) {
                alert('Oh...Không ! Sai số rồi bạn ơi... ');
            }
        });
    </script>
@endsection
@section('scripts')

@endsection