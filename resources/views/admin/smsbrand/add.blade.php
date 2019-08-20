@extends('layouts.admin.app')
@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h2 class="title">Tin Nhắn</h2>
                            </div>
                            <div class="contentt">
                                <form id="add-campaign" action="{{ route('admin.customer.sent') }}"
                                      method="post" class="form"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h2 style="text-align: center;font-weight: bold">Nội Dung Tin Nhắn</h2>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tên chiến dịch</label>
                                                        <input type="text" class="form-control border-input"
                                                               placeholder="Tên chiến dịch sms" name="name-customer"
                                                               value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="sel1">Loại tin nhắn:</label>
                                                        <select class="form-control" id="sel1" name="type-sms">
                                                            <option value="1">Quảng cáo</option>
                                                            <option value="2">CSKH</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="section">
                                                        <label for="comment">Comment:</label>
                                                        <textarea class="form-control" id="sms-content"
                                                                  name="content_sms" rows="5"
                                                                  placeholder="Nội dung tin nhắn"></textarea>
                                                        <label for="comment" class="field-icon"><i
                                                                    class="fa fa-comments"></i>
                                                        </label>
                                                        <span style="color:red" class="input-footer">
                                                            <strong>Chú ý: </strong>Nhập nội dung không dấu, không ký tự đặc biệt nhé</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <h2 style="text-align: center;font-weight: bold">Danh Sách Khách Hàng
                                                    Nhận</h2>
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Firstname</th>
                                                        <th>Lastname</th>
                                                        <th>Email</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($data as $item)
                                                        <tr>
                                                            <td style="display: none"><input name="customer_id[]"
                                                                                             value="{{$item->id}}"></td>
                                                            <td>{{$item->name}}</td>
                                                            <td>{{$item->phone}}</td>
                                                            <td>{{$item->service_name}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Gửi tin nhắn SMS
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
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
