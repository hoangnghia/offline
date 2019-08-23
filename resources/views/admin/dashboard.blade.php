@extends('layouts.admin.app')
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- /.box -->
        <h1 class="title">Tổng</h1>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <p class="card-category">Chiến dịch</p>
                        <h3 class="card-title">{{$totalCampaign}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <p class="card-category">Khách hàng</p>
                        <h3 class="card-title">{{$totalCustomer}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-product-hunt"></i>
                        </div>
                        <p class="card-category">Tin nhắn</p>
                        <h3 class="card-title">{{$totalSms}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-code-fork"></i>
                        </div>
                        <p class="card-category">CareSoft</p>
                        <h3 class="card-title">{{$totalCS}}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
        <h1 class="title">Hôm nay</h1>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <p class="card-category">Chiến dịch</p>
                        <h3 class="card-title">{{$todayCampaign}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <p class="card-category">Khách hàng</p>
                        <h3 class="card-title">{{$todayCustomer}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-product-hunt"></i>
                        </div>
                        <p class="card-category">Tin nhắn</p>
                        <h3 class="card-title">{{$todaySms}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-code-fork"></i>
                        </div>
                        <p class="card-category">CareSoft</p>
                        <h3 class="card-title">{{$todayCS}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
