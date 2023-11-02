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
                            <li><a href="product.html">Product</a></li>
                            <li>Product Single</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end page-title -->
    <!-- product-single-section  start-->
    <div class="product-single-section section-padding">
        <div class="container">
            <div class="product-details">
                <form action="{{ route('cart.store') }}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="product-single-img">
                                <div class="product-active owl-carousel">
                                    @foreach (App\Models\ProductGallery::where('product_id', $product_details->id)->get() as $gallery)
                                        <div class="item">
                                            <img src="{{ asset('uploads/product/gallery') }}/{{ $gallery->gallery }}"
                                                alt="">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="product-thumbnil-active  owl-carousel">
                                    @foreach (App\Models\ProductGallery::where('product_id', $product_details->id)->get() as $gallery)
                                        <div class="item">
                                            <img src="{{ asset('uploads/product/gallery') }}/{{ $gallery->gallery }}"
                                                alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @php
                            $avg = 0;
                            if ($reviews->count() != 0) {
                                $avg = round($total_stars / $reviews->count());
                            }
                        @endphp
                        <div class="col-lg-7">
                            <div class="product-single-content">
                                <h2>{{ $product_details->product_name }}</h2>
                                <div class="price">
                                    <span class="present-price">&#2547;{{ $product_details->after_product_discount }}</span>
                                    @if ($product_details->product_discount)
                                        <del class="old-price">&#2547;{{ $product_details->product_price }}</del>
                                    @endif
                                </div>
                                <div class="rating-product">
                                    @for ($i = 1; $i <= $avg; $i++)
                                        <i class="fi flaticon-star"></i>
                                    @endfor
                                    <span>{{ $reviews->count() }}</span>
                                </div>
                                <p>Aliquam proin at turpis sollicitudin faucibus.
                                    Non nunc molestie interdum nec sit duis vitae vestibulum id.
                                    Ipsum non donec egestas quis. A habitant tellus nibh blandit.
                                    Faucibus dictumst nibh et aliquet in auctor. Amet ultrices urna ullamcorper
                                    sagittis.
                                    Hendrerit orci ac fusce pulvinar. Diam tincidunt integer eget morbi diam scelerisque
                                    mattis.
                                </p>
                                <div class="product-filter-item color">
                                    <div class="color-name">
                                        <span>Color :</span>
                                        <ul>
                                            @foreach ($avilable_colors as $avilable_color)
                                                @if ($avilable_color->rel_to_color->color_name == 'NA')
                                                    <li class=""><input class="color_id"
                                                            id="color{{ $avilable_color->color_id }}" type="radio"
                                                            name="color_id" value="{{ $avilable_color->color_id }}">
                                                        <label
                                                            style="background-color: transparent; font-size:13px; border:2px solid #000; text-align:center; line-height:26px;"
                                                            for="color{{ $avilable_color->color_id }}">{{ $avilable_color->rel_to_color->color_name }}</label>
                                                    </li>
                                                @else
                                                    <li class=""><input class="color_id"
                                                            id="color{{ $avilable_color->color_id }}" type="radio"
                                                            name="color_id" value="{{ $avilable_color->color_id }}">
                                                        <label
                                                            style="background-color: {{ $avilable_color->rel_to_color->color_name }}"
                                                            for="color{{ $avilable_color->color_id }}"></label>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        @error('color_id')
                                            <strong class="text-danger">Please select your color</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="product-filter-item color filter-size">
                                    <div class="color-name">
                                        <span>Sizes:</span>
                                        <ul class="size_avl">
                                            @foreach ($avilable_sizes as $avilable_size)
                                                <li class=""><input class="size_id"
                                                        id="size{{ $avilable_size->size_id }}" type="radio"
                                                        name="size_id" value="{{ $avilable_size->size_id }}">
                                                    <label title="{{ $avilable_size->rel_to_size->size_name }}"
                                                        for="size{{ $avilable_size->size_id }}">
                                                        @if (Str::length($avilable_size->rel_to_size->size_name) > 3)
                                                            {{ Str::substr($avilable_size->rel_to_size->size_name, 0, 3) . '..' }}
                                                        @else
                                                            {{ $avilable_size->rel_to_size->size_name }}
                                                        @endif
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @error('size_id')
                                            <strong class="text-danger">Please select your size</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="pro-single-btn">
                                    <div class="quantity cart-plus-minus">
                                        <input name="quantity" class="text-value" type="text" value="1">
                                    </div>
                                    @auth('customer')
                                        <button type="submit" class="cart-btn theme-btn-s2">Add to cart</button>
                                    @else
                                        <a href="{{ route('customer.login') }}" class="theme-btn-s2">Add to cart</a>
                                    @endauth
                                    <a href="#" class="wl-btn"><i class="fi flaticon-heart"></i></a>
                                </div>
                                <input type="hidden" name="product_id" value="{{ $product_details->id }}">
                                <ul class="important-text">
                                    <li><span>SKU:</span>FTE569P</li>
                                    <li><span>Categories:</span>Best Seller, sale</li>
                                    <li><span>Tags:</span>Fashion, Coat, Pink</li>
                                    <li class="stock"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="product-tab-area">
                <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="descripton-tab" data-bs-toggle="pill"
                            data-bs-target="#descripton" type="button" role="tab" aria-controls="descripton"
                            aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Ratings-tab" data-bs-toggle="pill" data-bs-target="#Ratings"
                            type="button" role="tab" aria-controls="Ratings" aria-selected="false">Reviews
                            (3)</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Information-tab" data-bs-toggle="pill"
                            data-bs-target="#Information" type="button" role="tab" aria-controls="Information"
                            aria-selected="false">Additional
                            info</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="descripton" role="tabpanel"
                        aria-labelledby="descripton-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="Descriptions-item">
                                        {!! $product_details->long_desp !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Ratings" role="tabpanel" aria-labelledby="Ratings-tab">
                        <div class="container">
                            <div class="rating-section">
                                <div class="row">
                                    <div class="col-lg-12 col-12">

                                        <div class="comments-area">
                                            <div class="comments-section">
                                                <h3 class="comments-title">{{ $reviews->count() }} reviews for
                                                    {{ $product_details->product_name }}</h3>
                                                <ol class="comments">
                                                    @foreach ($reviews as $review)
                                                        <li class="comment">
                                                            <div>
                                                                <div class="comment-theme">
                                                                    <div class="comment-image">
                                                                        @if ($review->rel_to_customer->photo == null)
                                                                            <img class="m-auto pt-3"
                                                                                src="{{ Avatar::create($review->rel_to_customer->fname)->toBase64() }}"
                                                                                width="70px">
                                                                        @else
                                                                            <img class="m-auto pt-3"
                                                                                src="{{ asset('uploads/customer') }}/{{ $review->rel_to_customer->photo }}"
                                                                                width="70px">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="comment-main-area">
                                                                    <div class="comment-wrapper">
                                                                        <div class="comments-meta">
                                                                            <h4>{{ $review->rel_to_customer->fname . ' ' . $review->rel_to_customer->lname }}
                                                                            </h4>
                                                                            <div class="rating-product">
                                                                                @for ($i = 1; $i <= $review->star; $i++)
                                                                                    <i class="fi flaticon-star"></i>
                                                                                @endfor
                                                                            </div>
                                                                            <span
                                                                                class="comments-date">{{ $review->updated_at->diffForHumans() }}</span>
                                                                        </div>
                                                                        <div class="comment-area">
                                                                            <p>{{ $review->review }}
                                                                                <a class="comment-reply-link"
                                                                                    href="#"><span>Reply...</span></a>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach

                                                </ol>
                                            </div> <!-- end comments-section -->
                                            <div class="col col-lg-10 col-12 review-form-wrapper">
                                                @auth('customer')
                                                    @if (App\Models\OrderProduct::where('customer_id', Auth::guard('customer')->id())->where('product_id', $product_details->id)->exists())
                                                        @if (App\Models\OrderProduct::where('customer_id', Auth::guard('customer')->id())->where('product_id', $product_details->id)->whereNotNull('review')->first() == false)
                                                            <div class="review-form">
                                                                <h4>Add a review</h4>
                                                                <form action="{{ route('review.store') }}" method="POST">
                                                                    @csrf
                                                                    <div class="give-rat-sec">
                                                                        <div class="give-rating">
                                                                            <label>
                                                                                <input type="radio" name="stars"
                                                                                    value="1">
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="stars"
                                                                                    value="2">
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="stars"
                                                                                    value="3">
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="stars"
                                                                                    value="4">
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="stars"
                                                                                    value="5">
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <textarea name="review" class="form-control" placeholder="Write Comment..."></textarea>
                                                                    </div>
                                                                    <div class="name-input">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Name"
                                                                            value="{{ Auth::guard('customer')->user()->fname }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="name-email">
                                                                        <input type="email" class="form-control"
                                                                            placeholder="Email"
                                                                            value="{{ Auth::guard('customer')->user()->email }}"
                                                                            required>
                                                                    </div>
                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $product_details->id }}">
                                                                    <div class="rating-wrapper">
                                                                        <div class="submit">
                                                                            <button type="submit" class="theme-btn-s2">Post
                                                                                review</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <div class="alert alert-warning">
                                                                <h3>You already reviewed this product.</h3>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="alert alert-warning">
                                                            <h3>You didn't purchase this product yet.</h3>
                                                        </div>
                                                    @endif
                                                @endauth

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Information" role="tabpanel" aria-labelledby="Information-tab">
                        <div class="container">
                            <div class="Additional-wrap">
                                <div class="row">
                                    <div class="col-12">
                                        {!! $product_details->add_info !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="related-product">
        </div>
    </div>
    <!-- product-single-section  end-->
@endsection
@section('footer_script')
    <script>
        $('.color_id').click(function() {
            var color_id = $(this).val();
            var product_id = '{{ $product_details->id }}';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '/getSize',
                data: {
                    'color_id': color_id,
                    'product_id': product_id,
                },
                success: function(data) {
                    $('.size_avl').html(data);
                    $('.size_id').click(function() {
                        var size_id = $(this).val();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: '/getQuantity',
                            data: {
                                'color_id': color_id,
                                'product_id': product_id,
                                'size_id': size_id,
                            },
                            success: function(data) {
                                $('.stock').html(data);
                                var q = $('.abc').val();
                                if (q == 0) {
                                    $('.cart-btn').attr('disabled', '');
                                } else {
                                    $('.cart-btn').removeAttr('disabled', '');
                                }
                            }
                        });
                    });
                }
            });
        })
    </script>
    @if (session('cart_added'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('cart_added') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
@endsection
