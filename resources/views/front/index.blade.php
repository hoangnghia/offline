@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
@endsection

@section('content')
    @if(count($products) > 0)
        <section class="banner-statistics section-space">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h2>Dịch vụ bán chạy nhất</h2>
                            <p>Những dịch vụ kết hợp các phương pháp điều trị từ trong ra ngoài nhằm mang đến vẻ đẹp an
                                toàn, lâu dài cho khách hàng.</p>
                        </div>
                    </div>
                </div>
                <div class="row mbn-30">
                @foreach($products as $bestProduct)
                    <!-- start store item -->
                        <div class="col-md-4">
                            <div class="banner-item mb-30">
                                <figure class="banner-thumb">
                                    <a href="{{ route('front.get.product', str_slug($bestProduct->slug)) }}">
                                        @if(isset($bestProduct->cover))
                                            <img src="{{ asset("storage/$bestProduct->cover") }}"
                                                 alt="{{ $bestProduct->name }}"
                                                 class="img-bordered img-responsive">
                                        @else
                                            <img src="https://placehold.it/263x330"
                                                 alt="{{ $bestProduct->name }}" class="pri-img"/>
                                        @endif
                                    </a>
                                    <span class="discount_hot">-60%</span>

                                    <figcaption class="banner-content">
                                        <div class="name_services_hot">
                                            <?php
                                                $category = isset($bestProduct->categories[0]) ? $bestProduct->categories[0] : null;
                                            ?>
                                            <h5 class="text1">{{!is_null($category) ? $category-> name : 'Chưa xác định'}}</h5>
                                            <a href="{{ route('front.get.product', str_slug($bestProduct->slug)) }}"><h3
                                                        class="text2">{{ $bestProduct->name }}</h3></a>
                                        </div>
                                        <div class="price_services_hot">
                                            <b>{{number_format($bestProduct->sale_price)}}</b>
                                            <label for="">{{number_format($bestProduct->price)}}</label>


                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                        <!-- start store item -->
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- our product area start -->
    <section class="our-product section-space pt-0" style="margin-top: 40px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 style="  margin-bottom: 5px;">Dịch vụ</h2>
                        <span style="color: #707070; font-size: 14px; line-height: 1.3;">Chúng tôi tin rằng cung cấp các dịch vụ trị liệu cả bên trong lẫn bên ngoài
                            cơ thể phù hợp với nhu cầu của từng khách hàng sẽ mang lại hiệu quả cao nhất.</span>
                    </div>
                </div>
            </div>
            <div style="margin-top: 5px" class="row">
                <div class="col-12">
                    <!-- product tab menu start -->
                    <div class="tab-menu nd_tab_service">
                        <ul class="nav justify-content-center">
                            <li><a data-toggle="tab" class="active" href="#zero">Tất cả</a></li>
                            @foreach($categories as $categorie)
                                <li><a data-toggle="tab" href="#{{$categorie->slug}}">{{$categorie->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- product tab menu start -->

                    <!-- product tab container start -->
                    <div class="product-container">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="zero">
                                <div class="row">
                                @foreach($categories as $cat2)
                                    <?php
                                    $productsAll = $cat2->products->where('status', 1)
                                    ?>
                                    @foreach($productsAll as $proItem)
                                        <!-- product single item start -->
                                            <div class="product-item col-md-3">
                                                <figure class="product-thumb">
                                                    <a href="javascript:void(0)">
                                                        @if(isset($proItem->cover))
                                                            <img src="{{ asset("storage/$proItem->cover") }}"
                                                                 alt="{{ $proItem->name }}"
                                                                 class="img-bordered img-responsive">
                                                        @else
                                                            <img src="https://placehold.it/263x330"
                                                                 alt="{{ $proItem->name }}" class="pri-img"/>
                                                        @endif
                                                    </a>
                                                    <div class="product-badge">
                                                        <div class="product-label discount">
                                                            <span>10%</span>
                                                        </div>
                                                    </div>
                                                    <div class="box-cart">
                                                        <form action="{{ route('cart.store') }}" method="post">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="quantity" value="1"/>
                                                            <input type="hidden" name="product"
                                                                   value="{{ $proItem->id }}">
                                                            <button type="button" data-id="{{ $proItem->id }}"
                                                                    id="add-to-cart-btn"
                                                                    class="btn btn-cart"><i class="lnr lnr-cart"></i>
                                                                Thêm vào giỏ
                                                            </button>
                                                            <a href="{{ route('front.get.product', str_slug($proItem->slug)) }}">
                                                                <button type="button"
                                                                        class="btn btn-cart"><i
                                                                            class="lnr lnr-link"></i>
                                                                    Chi tiết sản phẩm
                                                                </button>
                                                            </a>
                                                        </form>
                                                    </div>
                                                </figure>
                                                <div class="product-caption">
                                                    <p class="product-name">
                                                        <a href="{{ route('front.get.product', str_slug($proItem->slug)) }}">{{ $proItem->name }}</a>
                                                    </p>
                                                    <div class="price-box">
                                                        <span class="price-regular">  {{ number_format($proItem->sale_price) }}</span>
                                                        <span class="price-old"><del>  {{ number_format($proItem->price) }}</del></span>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                    <!-- product single item end -->
                                    @endforeach
                                </div>

                                {{--<div class="pagging_services">--}}
                                {{--<nav aria-label="Page navigation example">--}}
                                {{--<ul class="pagination">--}}
                                {{--<li class="page-item active"><a class="page-link" href="#">1</a></li>--}}
                                {{--<li class="page-item"><a class="page-link" href="#">2</a></li>--}}
                                {{--<li class="page-item"><a class="page-link" href="#">3</a></li>--}}
                                {{--<li class="page-item"><a class="page-link" href="#">4</a></li>--}}
                                {{--<li class="page-item"><a class="page-link" href="#">5</a></li>--}}
                                {{--<li class="page-item"><a class="page-link" href="#">></a></li>--}}
                                {{--</ul>--}}
                                {{--</nav>--}}
                                {{--</div>--}}
                            </div>
                            @foreach($categories as $cat2)
                                <div class="tab-pane fade" id="{{$cat2->slug}}">
                                    <?php
                                    $products = $cat2->products->where('status', 1)
                                    ?>
                                    <div class="row">
                                    @foreach($products as $product)
                                        <!-- product single item start -->
                                            <div class="product-item col-md-3">
                                                <figure class="product-thumb">
                                                    <a href="javascript:void(0)">
                                                        @if(isset($product->cover))
                                                            <img src="{{ asset("storage/$product->cover") }}"
                                                                 alt="{{ $product->name }}"
                                                                 class="img-bordered img-responsive">
                                                        @else
                                                            <img src="https://placehold.it/263x330"
                                                                 alt="{{ $product->name }}" class="pri-img"/>
                                                        @endif
                                                    </a>
                                                    <div class="product-badge">
                                                        <div class="product-label discount">
                                                            <span>{{$product->price / $product->sale_price}}%</span>
                                                        </div>
                                                    </div>
                                                    <div class="box-cart">
                                                        <form action="{{ route('cart.store') }}" method="post">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="quantity" value="1"/>
                                                            <input type="hidden" name="product"
                                                                   value="{{ $product->id }}">
                                                            <button type="submit" id="add-to-cart-btn"
                                                                    class="btn btn-cart"><i class="lnr lnr-cart"></i>
                                                                Thêm vào giỏ
                                                            </button>
                                                            <a href="{{ route('front.get.product', str_slug($product->slug)) }}">
                                                                <button type="button"
                                                                        class="btn btn-cart"><i
                                                                            class="lnr lnr-link"></i>
                                                                    Chi tiết sản phẩm
                                                                </button>
                                                            </a>
                                                        </form>
                                                    </div>
                                                </figure>
                                                <div class="product-caption">
                                                    <p class="product-name">
                                                        <a href="{{ route('front.get.product', str_slug($product->slug)) }}">{{ $product->name }}</a>
                                                    </p>
                                                    <div class="price-box">
                                                        <span class="price-regular">  {{ number_format($product->sale_price) }}</span>
                                                        <span class="price-old"><del>  {{ number_format($product->price) }}</del></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- product single item end -->
                                        @endforeach
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- product tab container end -->
            </div>
        </div>
    </section>
    <!-- our product area end -->
    <style>
        .box-cart button {
            margin-bottom: 15px;
            color: #FFF;
        }
    </style>
@endsection