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
                        <input type="text" name="name" id="name" placeholder="Tên danh mục" class="form-control"
                               value="{{ $campaign->name  }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả danh mục </label>
                        <textarea class="form-control ckeditor" name="description" id="description" rows="3"
                                  placeholder="Mô tả danh mục">{{ $campaign->note }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">Thời gian bắt đầu<span class="text-danger">*</span></label>
                        <input type="text" id="set-start-date" name="set-start-date"
                               value="{{date('mm/dd/YYYY', strtotime($campaign->time_start))}}"/>
                    </div>
                    <div class="form-group">
                        <label for="name">Thời gian kết thúc<span class="text-danger">*</span></label>
                        <input type="text" id="set-end-date" name="set-end-date"
                               value="{{date('mm/dd/YYYY', strtotime($campaign->time_end))}}"/>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label for="name">Chi phí<span class="text-danger">*</span></label>--}}
                        {{--<input type="text" id="cost" name="cost" value="{{$campaign->cost}}"/>vnđ--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label for="name">Taget<span class="text-danger">*</span></label>
                        <input type="text" id="taget" name="taget" value="{{$campaign->taget}}"/>
                    </div>
                    <div class="form-group">
                        <label for="name">Địa chỉ<span class="text-danger">*</span></label>
                        <select data-value="status"
                                name="customer-reason"
                                class="changeValue form-control"
                                id="customer-reason"
                        >
                            <option>Chọn chi nhánh</option>
                            @foreach($branch as $item)
                                <option class="local-id" value="{{ $item->id }}"
                                        @if($campaign->address == $item->id) selected="selected" @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control"
                                id="local-reason" multiple="multiple"
                                name="local-reason[]">
                            {{--@foreach($branchList as $branchItem)--}}
                            {{--@foreach($local as $localItem)--}}
                                {{--<option class="local local-{{$localItem->branch_id }}"--}}
                                        {{--value="{{ $localItem->id }}">{{ $localItem->name }}</option>--}}
                            {{--@endforeach--}}
                            {{--@endforeach--}}


                            @foreach($branchList as $branchItem)
                                <option class=""
                                @foreach($local as $localItem)
                                 @if($localItem->local_id == $branchItem->local_id) selected @endif
                                @endforeach
                                >{{ $branchItem->local_name }}</option>
                                @endforeach
                            {{--@foreach($branchList as $branchItem)--}}
                            {{--@foreach($local as $localItem)--}}
                                {{--<option class="local-{{$localItem->branch_id }}" @if($localItem->id == $item->id) selected="selected" @endif--}}
                                        {{--value="{{ $localItem->id }}">{{ $localItem->name }}</option>--}}
                            {{--@endforeach--}}
                            {{--@endforeach--}}
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default">Quay lại danh sách</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
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
            $local = $('.local-id').val();
            $("#add-campaign .local-" + $local).removeClass('hide');
        });
        $('.local_user').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: '-- Danh sách user --',
        });

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
        $('#local-reason').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: '-- Danh sách local --',
        });
    </script>
@endsection
