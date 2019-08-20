@extends('layouts.admin.app')
@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="card card-user">
                            <div class="group">
                                <div class="author">
                                    <h4 class="title">THÔNG TIN CHIẾN DỊCH</h4>
                                </div>
                                <div class="text-left"><span
                                            class="title">Tên chiến dịch:</span><b>{{$detail->campaign_name}}</b></div>
                                <div class="text-left"><span
                                            class="title">Địa chỉ:</span><b>{{$detail->branch_name}}</b></div>
                                <div class="text-left"><span
                                            class="title">Đối tác:</span><b>{{$detail->agency_name}}</b></div>
                                <div class="text-left"><span class="title">Start:</span><b>{{$detail->time_start}}</b>
                                </div>
                                <div class="text-left"><span class="title">End:</span><b>{{$detail->time_end}}</b></div>
                                <div class="text-left"><span class="title">Taget:</span><b>{{$detail->taget}}</b></div>
                                <div class="text-left"><span class="title">Local:</span><b>{{$detail->local_name}}</b>
                                </div>
                                <div class="text-left"><span class="title">Pg:</span><b>{{$detail->employees_name}}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">THÔNG TIN KHÁCH HÀNG</h4>
                            </div>
                            <div class="content">
                                <form id="add-campaign" action="{{ route('admin.customer.detailUpload') }}"
                                      method="post" class="form"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Tên Khách hàng</label>
                                                <input type="text" class="form-control border-input"
                                                       placeholder="name" name="name-customer"
                                                       value="{{$detail->name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <input type="text" class="form-control border-input"
                                                       placeholder="Username" name="phone-customer"
                                                       value="{{$detail->phone}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Năm sinh</label>
                                                <input type="text"  data-mask="00/00/0000" data-mask-selectonfocus="true" value="{{$detail->birthday}}" name="date-customer" placeholder="Ngày/Tháng/Năm sinh" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Dịch vụ</label>
                                                <input type="number" name="id" value="{{$detail->id}}"
                                                       style="display: none">
                                                <input type="text" class="form-control border-input"
                                                       disabled
                                                       value="{{$detail->service_name}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Ghi chú</label>
                                                <textarea rows="3" class="form-control border-input"
                                                          name="note-customer"
                                                          placeholder="Here can be your description">{{$detail->note}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Cập nhật
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Người thân</h4>
                            </div>
                            <div class="form-group">
                                <ul class="list-unstyled team-members">
                                    <li>
                                        <div class="row">
                                            <div class="col-xs-3">
                                                @if(isset($parent->name)){
                                                {{$parent->name}}
                                                }
                                                @endif
                                            </div>
                                            <div class="col-xs-3">
                                                @if(isset($parent->name)){
                                                {{$parent->phone}}
                                                }
                                                @endif
                                            </div>
                                            <div class="col-xs-3">
                                                @if(isset($parent->name)){
                                                {{$parent->service_name}}
                                                }
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <style type="text/css">
        .header {
            text-align: center
        }

        .header h4 {
            font-weight: bold
        }

        .group {
            padding: 20px
        }

        .group h4 {
            text-align: center;
            font-weight: bold
        }

        .group .text-left {
            font-size: 15px;
            line-height: 25px
        }

        .group .text-left .title {
            font-weight: bold
        }

        .group .text-left b {
            float: right;
            color: #1b75b7
        }

        .form-group input {
            color: #1b75b7;
        }

        .form-group textarea {
            color: #1b75b7;
        }
    </style>
@endsection
