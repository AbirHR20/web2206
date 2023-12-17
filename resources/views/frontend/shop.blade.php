@extends('frontend.master')
@section('content')
    <!-- start wpo-page-title -->
    <section class="wpo-page-title">
        <h2 class="d-none">Hide</h2>
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="wpo-breadcumb-wrap">
                        <ol class="wpo-breadcumb-wrap">
                            <li><a href="index.html">Home</a></li>
                            <li>Shop</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- product-area-start -->
    <div class="shop-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="shop-filter-wrap">
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <div class="shop-filter-search">
                                    <form>
                                        <div>
                                            <input id="search-input2" type="text" class="form-control" placeholder="Search..">
                                            <button class="search-btn2" type="button"><i class="ti-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Shop by Categotry</h2>
                                <ul>
                                    @foreach ($categories as $category)
                                    <li>
                                        <label class="topcoat-radio-button__label">
                                            {{ $category->category_name }} <span>({{ App\Models\Product::where('category_id',$category->id)->count() }})</span>
                                            <input {{ $category->id == @$_GET['category_id']?'checked':'' }} name="category_id" type="radio" name="topcoat2" class="category_id" value="{{ $category->id }}">
                                            <span class="topcoat-radio-button"></span>
                                        </label>
                                    </li>    
                                    @endforeach                                  
                                </ul>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Filter by price</h2>
                                <div class="shopWidgetWraper">
                                    <div class="priceFilterSlider">
                                        <form action="#" method="get" class="clearfix">
                                            <!-- <div id="sliderRange"></div>
                                                    <div class="pfsWrap">
                                                        <label>Price:</label>
                                                        <span id="amount"></span>
                                                    </div> -->
                                            <div class="d-flex">
                                                <div class="col-lg-6 pe-2">
                                                    <label for="" class="form-label">Min</label>
                                                    <input id="min" value="{{ @$_GET['min'] }}" type="text" class="form-control" placeholder="Min amount">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="" class="form-label">Max</label>
                                                    <input id="max" value="{{ @$_GET['max'] }}" type="text" class="form-control" placeholder="Max amount">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-4">
                                                <button type="button" id="price_range" class="form-control bg-light search-btn">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Color</h2>
                                <ul>
                                    @foreach ($colors as $color)
                                    <li>
                                        <label class="topcoat-radio-button__label">
                                            {{ $color->color_name }} <span>({{ App\Models\Inventory::where('color_id',$color->id)->count() }})</span>
                                            <input type="radio" name="color_id" class="color_id" value="{{ $color->id }}" {{ $color->id == @$_GET['color_id']?'checked':'' }}>
                                            <span class="topcoat-radio-button"></span>
                                        </label>
                                    </li>    
                                    @endforeach                                   
                                </ul>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Size</h2>
                                <ul>
                                    @foreach ($sizes as $size)
                                    <li>
                                        <label class="topcoat-radio-button__label">
                                            {{ $size->size_name }} <span>({{ App\Models\Inventory::where('size_id',$size->id)->count() }})</span>
                                            <input type="radio" class="size_id" name="size_id"  value="{{ $size->id }}"{{ $size->id == @$_GET['size_id']?'checked':'' }}>
                                            <span class="topcoat-radio-button"></span>
                                        </label>
                                    </li>    
                                    @endforeach                                   
                                </ul>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item tag-widget">
                                <h2>Popular Tags</h2>
                                <ul>
                                    @foreach ($tags as $tag)
                                    <li>
                                        <label class="topcoat-radio-button__label">
                                            {{ $tag->tag }}
                                            <input name="tag_id" type="radio" name="topcoat2" class="tag_id" value="{{ $tag->id }}" {{ $tag->id == @$_GET['tag_id']?'checked':'' }}>
                                            <span class="topcoat-radio-button"></span>
                                        </label>
                                    </li>    
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="shop-section-top-inner">
                        <div class="shoping-product">
                            <p>We found <span>{{ $products->count() }} items</span> for you!</p>
                        </div>
                        <div class="short-by">
                            <ul>
                                <li>
                                    Sort by:
                                </li>
                                <li>
                                    <select name="show" class="sorting">
                                        <option value="">Default Sorting</option>
                                        <option value="1">Low To High</option>
                                        <option value="2">High To Low</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="row align-items-center">
                            @forelse ($products as $product)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="product-item">
                                        <div class="image">
                                            <img src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" alt="" height="200">
                                            <div class="tag new">New</div>
                                        </div>
                                        <div class="text">
                                            <h2>@if (Str::length($product->product_name) > 20)
                                                <a title="{{ $product->product_name }}"
                                                    href="{{ route('products.details',$product->slug) }}">{{ Str::substr($product->product_name, 0, 20) . '...' }}</a>
                                            @else
                                                <a title="{{ $product->product_name }}"
                                                    href="{{ route('products.details',$product->slug) }}">{{ $product->product_name }}</a>
                                            @endif</a></h2>
                                            <div class="rating-product">
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <span>130</span>
                                            </div>
                                            <div class="price">
                                                <span class="present-price">&#2547;{{ number_format($product->after_product_discount) }}</span>
                                                <del class="old-price">&#2547;{{ number_format($product->product_price) }}</del>
                                            </div>
                                            <div class="shop-btn">
                                                <a class="theme-btn-s2" href="{{ route('products.details',$product->slug) }}">Shop Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <h3>No product Found!</h3>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product-area-end -->
@endsection