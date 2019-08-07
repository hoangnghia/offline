@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if(!$products->isEmpty())
            <div class="box">
                <div class="box-body">
                    <h2>Danh sách sản phẩm</h2>
                    <a style="float: right" href="javascript:void(0)" class="btn btn-primary btn-sm assign-agent-all"><i
                                class="fa fa-edit"></i> Đồng bộ zalo</a>
                    {{--<a style="float: right" href="{{ route('admin.product.sync.zalo') }}" class="btn btn-primary btn-sm assign-agent-all"><i class="fa fa-edit"></i> Đồng bộ zalo</a>--}}
                    <dic class="col-md-4">@include('layouts.search', ['route' => route('admin.products.index')])</dic>
                    @include('admin.shared.products')
                    {{ $products->links() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript">

            $(".assign-agent-all").click(function () {
                var arrIds = []
                var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].value == 'on')
                        continue;
                    arrIds.push(checkboxes[i].value)
                }
                if (arrIds.length == 0) {
                    alert('Bạn chưa chọn sản phẩm !');
                    return false;
                }
                var data = {
                    'arrIds': arrIds,
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '<?php echo e(route('admin.product.sync.zalo')); ?>',
                    data: data
                }).done(function (response) {
                    if (response.result) {
                        alert('Đồng bộ thành công');
                    } else {
                        alert('WTF!!! Có lỗi trong quá trình, liên hệ IT ngay nhé.');
                    }
                });

                return false;
            });
        </script>
    </section>
    <!-- /.content -->
@endsection
