@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
    {{--<div class="box">--}}
    {{--<div class="box-header with-border">--}}
    {{--<h3 class="box-title">Title</h3>--}}

    {{--<div class="box-tools pull-right">--}}
    {{--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">--}}
    {{--<i class="fa fa-minus"></i></button>--}}
    {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
    {{--<i class="fa fa-times"></i></button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="box-body">--}}
    {{--Start creating your amazing application!--}}
    {{--</div>--}}
    {{--<!-- /.box-body -->--}}
    {{--<div class="box-footer">--}}
    {{--Footer--}}
    {{--</div>--}}
    {{--<!-- /.box-footer-->--}}
    {{--</div>--}}
    <!-- /.box -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <p class="card-category">Số lượng đơn hàng</p>
                        <h3 class="card-title">433
                            <small>đơn hàng</small>
                        </h3>
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
                        <h3 class="card-title">3223
                            <small>khách hàng</small></h3>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-product-hunt"></i>
                        </div>
                        <p class="card-category">Sản phẩm</p>
                        <h3 class="card-title">75
                                <small>sản phẩm</small></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-code-fork"></i>
                        </div>
                        <p class="card-category">Danh mục</p>
                        <h3 class="card-title">454 <small>danh mục</small></h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
