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
                            <li>{{ $subcategories->subcategory_name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end page-title -->
    <section class="themart-interestproduct-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wpo-section-title">
                        <h2>{{ $subcategories->subcategory_name }}</h2>
                    </div>
                </div>
            </div>
            <div class="product-wrap">
                <div class="row">
                    @forelse ($product_subcategories as $product_subcategory)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img height="250"
                                        src="{{ asset('uploads/product/preview') }}/{{ $product_subcategory->preview }}"
                                        alt="">
                                    @if ($product_subcategory->product_discount)
                                        <div class="tag sale">{{ $product_subcategory->product_discount }}%</div>
                                    @else
                                        <div class="tag new">New</div>
                                    @endif
                                </div>
                                <div class="text">
                                    <h2>
                                        @if (Str::length($product_subcategory->product_name) > 20)
                                            <a title="{{ $product_subcategory->product_name }}"
                                                href="product.html">{{ Str::substr($product_subcategory->product_name, 0, 20) . '...' }}</a>
                                        @else
                                            <a title="{{ $product_subcategory->product_name }}"
                                                href="product.html">{{ $product_subcategory->product_name }}</a>
                                        @endif
                                    </h2>
                                    <div class="price">
                                        <span
                                            class="present-price">&#2547;{{ number_format($product_subcategory->after_product_discount) }}</span>
                                        @if ($product_subcategory->product_discount)
                                            <del
                                                class="old-price">&#2547;{{ number_format($product_subcategory->product_price) }}</del>
                                        @endif
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <h3>No Product Found</h3>
                        </div>
                    @endforelse

                    <div class="more-btn">
                        <a class="theme-btn-s2" href="product.html">Load More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
