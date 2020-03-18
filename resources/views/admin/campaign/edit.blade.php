@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form id="add-campaign" action="{{ route('admin.campaign.editPosst') }}" method="post" class="form"
                  enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name">Tên chiến dịch <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Tên danh mục" class="form-control"
                               value="{{ $campaign->name  }}">
                        <input value="{{$campaign->id}}" name="campaign_id" style="display: none">
                    </div>
                    <div class="form-group">
                        <label for="name">Taget<span class="text-danger">*</span></label>
                        <input type="text" id="taget" name="taget" value="{{$campaign->taget}}"/>
                    </div>
                    <div class="form-group">
                        <label for="name">Độ tuổi<span class="text-danger">*</span></label>
                        <input type="number" id="age" name="age" value="{{$campaign->age}}" required/>
                    </div>
                    <div class="form-group">
                        <label for="name">Địa chỉ<span class="text-danger" disabled>*</span></label>
                        <select data-value="status"
                                name="customer-reason"
                                class="changeValue form-control"
                                id="customer-reason" disabled
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
                                name="local_reason[]">
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
                                        @endforeach value="{{$branchItem->local_id}}"
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
                    <div class="form-group">
                        <label for="description">Mô tả danh mục </label>
                        <textarea class="form-control ckeditor" name="description" id="description" rows="3"
                                  placeholder="Mô tả danh mục">{{ $campaign->note }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">Thời gian bắt đầu<span class="text-danger">*</span></label>
                        <input type="text" id="set-start-date" name="set_start_date"
                               value="{{date('mm/dd/YYYY', strtotime($campaign->time_start))}}"/>
                    </div>
                    <div class="form-group">
                        <label for="name">Thời gian kết thúc<span class="text-danger">*</span></label>
                        <input type="text" id="set-end-date" name="set_end_date"
                               value="{{date('mm/dd/YYYY', strtotime($campaign->time_end))}}"/>
                    </div>
                    <div class="form-group">
                        <label for="name">Thời gian hoạt động : <span class="text-danger">*</span></label>
                        <label for="name">Bắt đầu : <span class="text-danger">*</span></label>
                        <select id="time_start" name="time_start">
                            <option value="1"
                                    @if($campaign->time_start_login == 1) selected @endif>1
                            </option>
                            <option value="2"
                                    @if($campaign->time_start_login == 2) selected @endif>2
                            </option>
                            <option value="3"
                                    @if($campaign->time_start_login == 3) selected @endif>3
                            </option>
                            <option value="4"
                                    @if($campaign->time_start_login == 4) selected @endif>4
                            </option>
                            <option value="5"
                                    @if($campaign->time_start_login == 5) selected @endif>5
                            </option>
                            <option value="6"
                                    @if($campaign->time_start_login == 6) selected @endif>6
                            </option>
                            <option value="7"
                                    @if($campaign->time_start_login == 7) selected @endif>7
                            </option>
                            <option value="8"
                                    @if($campaign->time_start_login == 8) selected @endif>8
                            </option>
                            <option value="9"
                                    @if($campaign->time_start_login == 9) selected @endif>9
                            </option>
                            <option value="10"
                                    @if($campaign->time_start_login == 10) selected @endif>
                                10
                            </option>
                            <option value="11"
                                    @if($campaign->time_start_login == 11) selected @endif>
                                11
                            </option>
                            <option value="12"
                                    @if($campaign->time_start_login == 12) selected @endif>
                                12
                            </option>
                            <option value="13"
                                    @if($campaign->time_start_login == 13) selected @endif>
                                13
                            </option>
                            <option value="14"
                                    @if($campaign->time_start_login == 14) selected @endif>
                                14
                            </option>
                            <option value="15"
                                    @if($campaign->time_start_login == 15) selected @endif>
                                15
                            </option>
                            <option value="16"
                                    @if($campaign->time_start_login == 16) selected @endif>
                                16
                            </option>
                            <option value="17"
                                    @if($campaign->time_start_login == 17) selected @endif>
                                17
                            </option>
                            <option value="18"
                                    @if($campaign->time_start_login == 18) selected @endif>
                                18
                            </option>
                            <option value="19"
                                    @if($campaign->time_start_login == 19) selected @endif>
                                19
                            </option>
                            <option value="20"
                                    @if($campaign->time_start_login == 20) selected @endif>
                                20
                            </option>
                            <option value="21"
                                    @if($campaign->time_start_login == 21) selected @endif>
                                21
                            </option>
                            <option value="22"
                                    @if($campaign->time_start_login == 22) selected @endif>
                                22
                            </option>
                            <option value="23"
                                    @if($campaign->time_start_login == 23) selected @endif>
                                23
                            </option>
                            <option value="24"
                                    @if($campaign->time_start_login == 24) selected @endif>
                                24
                            </option>
                        </select>
                        <label for="name">Kết thúc : <span class="text-danger">*</span></label>
                        <select id="time_end" name="time_end">
                            <option value="1"
                                    @if($campaign->time_end_login == 1) selected @endif>1
                            </option>
                            <option value="2"
                                    @if($campaign->time_end_login == 2) selected @endif>2
                            </option>
                            <option value="3"
                                    @if($campaign->time_end_login == 3) selected @endif>3
                            </option>
                            <option value="4"
                                    @if($campaign->time_end_login == 4) selected @endif>4
                            </option>
                            <option value="5"
                                    @if($campaign->time_end_login == 5) selected @endif>5
                            </option>
                            <option value="6"
                                    @if($campaign->time_end_login == 6) selected @endif>6
                            </option>
                            <option value="7"
                                    @if($campaign->time_end_login == 7) selected @endif>7
                            </option>
                            <option value="8"
                                    @if($campaign->time_end_login == 8) selected @endif>8
                            </option>
                            <option value="9"
                                    @if($campaign->time_end_login == 9) selected @endif>9
                            </option>
                            <option value="10"
                                    @if($campaign->time_end_login == 10) selected @endif>10
                            </option>
                            <option value="11"
                                    @if($campaign->time_end_login == 11) selected @endif>11
                            </option>
                            <option value="12"
                                    @if($campaign->time_end_login == 12) selected @endif>12
                            </option>
                            <option value="13"
                                    @if($campaign->time_end_login == 13) selected @endif>13
                            </option>
                            <option value="14"
                                    @if($campaign->time_end_login == 14) selected @endif>14
                            </option>
                            <option value="15"
                                    @if($campaign->time_end_login == 15) selected @endif>15
                            </option>
                            <option value="16"
                                    @if($campaign->time_end_login == 16) selected @endif>16
                            </option>
                            <option value="17"
                                    @if($campaign->time_end_login == 17) selected @endif>17
                            </option>
                            <option value="18"
                                    @if($campaign->time_end_login == 18) selected @endif>18
                            </option>
                            <option value="19"
                                    @if($campaign->time_end_login == 19) selected @endif>19
                            </option>
                            <option value="20"
                                    @if($campaign->time_end_login == 20) selected @endif>20
                            </option>
                            <option value="21"
                                    @if($campaign->time_end_login == 21) selected @endif>21
                            </option>
                            <option value="22"
                                    @if($campaign->time_end_login == 22) selected @endif>22
                            </option>
                            <option value="23"
                                    @if($campaign->time_end_login == 23) selected @endif>23
                            </option>
                            <option value="24"
                                    @if($campaign->time_end_login == 24) selected @endif>24
                            </option>
                        </select>
                    </div>
                    {{--<div class="form-group">--}}
                    {{--<label for="name">Chi phí<span class="text-danger">*</span></label>--}}
                    {{--<input type="text" id="cost" name="cost" value="{{$campaign->cost}}"/>vnđ--}}
                    {{--</div>--}}

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-default">Quay lại danh sách</a>
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
        $('input[name="set_start_date"]').daterangepicker({
            dateFormat: 'yyyy-mm-dd',
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
        });
        $('input[name="set_end_date"]').daterangepicker({
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
