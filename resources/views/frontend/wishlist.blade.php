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
                            <li><a href="product.html">Product Page</a></li>
                            <li>Wishlist</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- cart-area start -->
    <div class="cart-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="single-page-title">
                        <h2>Your Wishlist</h2>
                        <p>There are {{ App\Models\wishlist::where('customer_id', Auth::guard('customer')->id())->count() }} products in this list</p>
                    </div>
                </div>
            </div>
            <div class="form">
                <div class="cart-wrapper">
                    <div class="row">
                        <div class="col-12">
                            <form action="https://wpocean.com/html/tf/themart/cart">
                                <table class="table-responsive cart-wrap">
                                    <thead>
                                        <tr>
                                            <th class="images images-b">Product</th>
                                            <th class="ptice">Price</th>
                                            <th class="stock">Stock Status</th>
                                            <th class="remove remove-b">Action</th>
                                            <th class="remove remove-b">Remove</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($wishlists as $wishlist)                                           
                                        <tr class="wishlist-item">
                                            <td class="product-item-wish">
                                                <div class="images">
                                                    <span>
                                                        <img src="{{ asset('uploads/product/preview') }}/{{ $wishlist->rel_to_product->preview }}" alt="">
                                                    </span>
                                                </div>
                                                <div class="product">
                                                    <ul>
                                                        <li class="first-cart">{{ $wishlist->rel_to_product->product_name }}</li>
                                                        <li>
                                                            <div class="rating-product">
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <span>130</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="ptice">&#2547; {{ $wishlist->rel_to_product->after_product_discount }}</td>
                                            <td class="stock">
                                                @php
                                                    $quantity = App\Models\Inventory::where('product_id',$wishlist->product_id)->where('color_id',$wishlist->color_id)->where('size_id',$wishlist->size_id)->first()->quantity;

                                                @endphp
                                                @if ($quantity >= $wishlist->quantity)
                                                <span class="in-stock">In Stock</span>
                                                @else
                                                <span class="in-stock out-stock">Out Stock</span>
                                                @endif
                                            </td>
                                            <td class="add-wish">
                                                @if ($quantity >= $wishlist->quantity)
                                                <a class="theme-btn-s2" href="{{ route('wish.cart',$wishlist->id) }}">Add to Cart</a>
                                                @else
                                                <a class="theme-btn-s2" @disabled(true)>Add to Cart</a>
                                                @endif
                                            </td>
                                            <td class="action">
                                                <ul>
                                                    <li class="w-btn"><a data-bs-toggle="tooltip" data-bs-html="true"
                                                            title="" href="{{ route('wishlist.remove',$wishlist->id) }}" data-bs-original-title="Remove"
                                                            aria-label="Remove"><i class="fi flaticon-remove"></i></a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart-area end -->
@endsection
