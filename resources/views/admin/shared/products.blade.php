@if(!$products->isEmpty())
    <table class="table hover">
        <thead>
        <tr>
            <td class="text-center"><label class="option block mn"> <input type="checkbox" class="check-all"
                                                                           name="checkbox[]"> <span
                            class="checkbox mn"></span> </label></td>
            <td>ID</td>
            <td>Tên sản phẩm</td>
            <td>Hình sản phẩm</td>
            <td>Số lượng</td>
            <td>Giá sản phẩm</td>
            <td>Giá sale</td>
            <td>Tình trạng</td>
            <td>Đồng bộ</td>
            <td>Hành động</td>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <?php
            $type = \App\Shop\Products\ProductType::where('local_id',$product->id)->first();
            ?>
            <tr>
               <td>
                   <label class="option block mn">
                       <input type="checkbox" class="sub_chk" data-id="{{ $product->id }}" name="checkbox[]" value="{{ $product->id }}">
                       <span class="checkbox mn"></span>
                   </label>
               </td>
                <td>{{ $product->id }}</td>
                <td>
                    @if($admin->hasPermission('view-product'))
                        <a href="{{ route('admin.products.show', $product->id) }}">{{ $product->name }}</a>
                    @else
                        {{ $product->name }}
                    @endif
                </td>
                <td>
                    @if(isset($product->cover))
                        <img style="width: 100px" src="{{ $product->cover }}" alt="" class="img-responsive">
                    @endif
                </td>
                <td>{{ $product->quantity }}</td>
                <td>{{ config('cart.currency') }} {{ number_format($product->price) }}</td>
                <td>{{ config('cart.currency') }} {{ number_format($product->sale_price) }}</td>
                <td>@include('layouts.status', ['status' => $product->status])</td>

               <td>
                   @if(isset($type))
                       <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-paper-plane"></i> Đồng bộ</button>
                   @else
                       <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-paper-plane"></i> Chưa đồng bộ</button>
                   @endif
               </td>
                <td>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete">
                        <div class="btn-group">
                            @if($admin->hasPermission('update-product'))<a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Cập nhật</a>@endif
                            @if($admin->hasPermission('delete-product'))<button onclick="return confirm('Bạn chắc chắn thực hiện thành động này?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Xóa</button>@endif
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif