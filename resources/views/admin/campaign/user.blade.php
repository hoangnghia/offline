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
                            <label><i class="fa fa-star"></i> Tình trạng: @if($campaign->status == 0)
                                    <button type="button" class="btn btn-danger">InActive</button>@else
                                    <button type="button" class="btn btn-success">Active</button>@endif</label>
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
                    {{--<div class="form-group">--}}
                    {{--<div class="col-lg-6">--}}
                    {{--<label for="name">Địa chỉ : {{$localItem->name}}</label>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{ csrf_field() }}
                    @if(isset($local))
                        <div class="form-group">
                            @foreach($local as $localItem)
                                <div class="form-group">
                                    <input value="{{$localItem->id}}" name="local_id_{{$localItem->id }}" hidden>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3"><label for="name">Địa chỉ : {{$localItem->name}}</label></div>
                                    <div class="col-lg-3">
                                        <select class="form-control local_user"
                                                multiple="multiple"
                                                name="local{{$localItem->id }}_local_user[]">
                                            @foreach($user as $userItem)
                                                <option class="local-{{$userItem->id }}"
                                                        value="{{ $userItem->id }}"
                                                        @foreach($localUser as $localUserItem)
                                                        @if($localUserItem->user_id == $userItem->id && $localUserItem->local_id == $localItem->local_id) selected @endif
                                                        @endforeach
                                                >{{ $userItem->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select class="form-control services scrollbar"
                                                multiple="multiple"
                                                name="services-{{$localItem->id }}[]">
                                            @foreach($service as $serviceItem)
                                                <option class="service-{{$serviceItem->id }}"
                                                        value="{{ $serviceItem->id }}"
                                                        @foreach($localServices as $localServicesItem)
                                                        @if($localServicesItem->service_id == $serviceItem->id && $localServicesItem->local_id == $localItem->local_id ) selected @endif
                                                        @endforeach
                                                >{{ $serviceItem->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="name">Taget</label>
                                        <?php
                                        $taget = \App\Shop\Local\LocalUser::where('campaign_id', $idcampaign)->where('local_id', $localItem->local_id)->get();
                                        if (count($taget) != 0) {
                                            $tagetNumber = $taget[0]->taget * count($taget);
                                        } else {
                                            $tagetNumber = 0;
                                        }
                                        ?>
                                        <input type="number" class="form-group" name="taget_local_{{$localItem->id }}"
                                               value="{{$tagetNumber}}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
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
    <style type="text/css">
        .box {
            padding: 10px;
        }

        .dropdown-menu {
            max-height: 150px;
            margin-bottom: 10px;
            overflow: scroll;
            -webkit-overflow-scrolling: touch;
        }

        /*.box-body .form-group {display: inline-block}*/
    </style>
    <!-- /.content -->
    <script type="text/javascript">
        $('.local_user').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: '-- Danh sách user --',
        });
        $('.services').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: '-- Danh sách dịch vụ --',
        });

    </script>
@endsection
