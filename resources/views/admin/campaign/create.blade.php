@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form id="add-campaign" action="{{ route('admin.campaign.store') }}" method="post" class="form"
                  enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name">Tên chiến dịch <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Tên chiến dịch" class="form-control"
                               value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Đối tác<span class="text-danger">*</span></label>
                        <select class="form-control"
                                name="agency" >
                            <option class="agency">Danh sách đối tác</option>
                            @foreach($agency as $agencyItem)
                                <option class="agency"
                                        value="{{ $agencyItem->id }}">{{ $agencyItem->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Địa chỉ<span class="text-danger">*</span></label>
                        <select data-value="status"
                                name="customer-reason"
                                class="changeValue form-control"
                                id="customer-reason"
                        >
                            <option>Chọn địa chỉ</option>
                            @foreach($branch as $item)
                                <option class="local-id" value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="local-hide">
                        <select class="form-control"
                                id="local-reason" multiple="multiple"
                                name="local-reason[]" >
                            @foreach($local as $localItem)
                                <option class="local local-{{$localItem->branch_id }}"
                                        value="{{ $localItem->id }}">{{ $localItem->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Thời gian bắt đầu<span class="text-danger">*</span></label>
                        <input type="text" id="set-start-date" name="set-start-date" value="" required/>
                    </div>
                    <div class="form-group">
                        <label for="name">Thời gian kết thúc<span class="text-danger">*</span></label>
                        <input type="text" id="set-end-date" name="set-end-date" value="" required/>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label for="name">Chi phí<span class="text-danger">*</span></label>--}}
                        {{--<input type="number" id="cost" name="cost" value=""/>(VNĐ)--}}
                    {{--</div>--}}
                    <div class="form-group">
                    <label for="name">Độ tuổi<span class="text-danger">*</span></label>
                    <input type="number" id="age" name="age" value="" required/>
                    </div>
                    <div class="form-group">
                        <label for="name">Taget<span class="text-danger">*</span></label>
                        <input type="number" id="taget" name="taget" value="" required/>
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả </label>
                        <textarea class="form-control ckeditor" name="description" id="description" rows="3"
                                  placeholder="Mô tả">{{ old('description') }}</textarea>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-default">Quay lại danh sách</a>
                        <button type="submit" class="btn btn-primary">Tạo mới</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
    <script type="text/javascript">
        $('.local').addClass('hide');
        $('#local-hide').addClass('hide');
        $('#add-campaign .changeValue').change(function () {
            $('#add-campaign #local-hide').removeClass('hide');
            var field = $(this).data("value");
            var local = $(this).data("local");
            $local = $(this).val();
            $('#add-campaign .local').addClass('hide');
            $("#add-campaign .local-" + $local).removeClass('hide');
        });

        $('#local-reason').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: '-- Danh sách local --',
        });
        // $('#agency-reason').multiselect({
        //     includeSelectAllOption: true,
        //     nonSelectedText: '-- Danh sách user --',
        // });


    </script>
    <script>
        $('input[name="set-start-date"]').daterangepicker({
            dateFormat: 'yyyy-mm-dd',
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,

        });
        $('input[name="set-end-date"]').daterangepicker({
            dateFormat: 'yyyy-mm-dd',
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,

        });

        {{--function submitform(e) {--}}
        {{--e.preventDefault(e)--}}
        {{--var local = $('#local-reason').val();--}}
        {{--alert(local);--}}
        {{--var address = $("#customer-reason").val();--}}
        {{--var name = $("#name").val();--}}
        {{--var description = $("#description").val();--}}
        {{--var end = $("#set-end-date").val();--}}
        {{--var start = $("#set-start-date").val();--}}

        {{--$.ajax({--}}
        {{--type: 'POST',--}}
        {{--headers: {--}}
        {{--'X-CSRF-TOKEN': ' {{csrf_token()}}'--}}
        {{--},--}}
        {{--dataType: 'json',--}}
        {{--url: '{{url('/admin/campaign/store')}}',--}}
        {{--data: {--}}
        {{--name: name,--}}
        {{--local: local,--}}
        {{--address: address,--}}
        {{--description: description,--}}
        {{--start: start,--}}
        {{--end: end--}}
        {{--},--}}
        {{--}).done(function (response) {--}}
        {{--if (response.result) {--}}
        {{--alert('Thêm chi nhánh thành công ! ');--}}
        {{--window.location = '{{url('/admin/branch/create')}}';--}}
        {{--} else {--}}
        {{--alert('WTF!!! Có lỗi trong quá trình, liên hệ IT ngay nhé.');--}}
        {{--}--}}
        {{--});--}}
        {{--}--}}
    </script>
@endsection
