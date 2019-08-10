@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <div class="row">

                <div class="col-lg-12">
                    <h2>Thông Tin Chiến Dịch</h2>
                    <div class="form-group">
                        <div class="col-lg-6">
                            <label><i class="fa fa-star"></i> Tên chiến dịch: {{$campaign->name}}</label><br>
                            <label><i class="fa fa-star"></i> Đối tác: {{$campaign->name_branchs}}</label><br>
                            <label><i class="fa fa-star"></i> Địa chỉ: {{$campaign->agency_name}}</label><br>
                            <label><i class="fa fa-star"></i> Tình trạng: @if($campaign->status == 0)<button type="button" class="btn btn-danger">InActive</button>@else<button type="button" class="btn btn-success">Active</button>@endif</label>
                        </div>
                        <div class="col-lg-6">
                            <label><i class="fa fa-star"></i> Thời gian bắt đầu: {{$campaign->time_start}}</label><br>
                            <label><i class="fa fa-star"></i> Thời gian kết thúc: {{$campaign->time_end}}</label><br>
                            <label><i class="fa fa-star"></i> Chí Phí: {{$campaign->cost}}</label><br>
                            <label><i class="fa fa-star"></i> Taget: {{$campaign->taget}}</label>
                        </div>
                    </div>
                </div>
            </div>
            <form id="add-campaign" action="{{ route('admin.campaign.user') }}" method="post" class="form"
                  enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <input value="{{$idcampaign}}" name="idcampaign" hidden>
                    </div>
                    {{ csrf_field() }}
                    @if(isset($local))
                        <div class="form-group">
                            @foreach($local as $localItem)
                                <div class="form-group">
                                    <input value="{{$localItem->id}}" name="local_id_{{$localItem->id }}" hidden>
                                </div>
                                <div class="form-group">
                                    <label for="name">Địa chỉ : {{$localItem->name}}</label>
                                    <select class="form-control local_user"
                                            multiple="multiple"
                                            name="local{{$localItem->id }}_local_user[]">
                                        @foreach($user as $userItem)
                                            <option class="local-{{$userItem->id }}"
                                                    value="{{ $userItem->id }}">{{ $userItem->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="name">Taget</label>
                                    <input type="number"  class="form-group" name="taget_local_{{$localItem->id }}" >
                                </div>
                            @endforeach
                        </div>
                    @endif
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
    <style type="text/css">
        .box {
            padding: 10px;
        }
        /*.box-body .form-group {display: inline-block}*/
    </style>
    <!-- /.content -->
    <script type="text/javascript">
        $('.local_user').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: '-- Danh sách user --',
        });

    </script>
@endsection
