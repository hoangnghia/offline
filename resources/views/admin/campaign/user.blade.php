@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
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
                                    <label for="name">{{$localItem->name}}</label>
                                    <select class="form-control local_user"
                                            multiple="multiple"
                                            name="local{{$localItem->id }}_local_user[]">
                                        @foreach($user as $userItem)
                                            <option class="local-{{$userItem->id }}"
                                                    value="{{ $userItem->id }}">{{ $userItem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Taget</label>
                                    <input  class="form-group" name="taget_local_{{$localItem->id }}" >
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
    <!-- /.content -->
    <script type="text/javascript">
        $('.local_user').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: '-- Danh sách user --',
        });

    </script>
@endsection
