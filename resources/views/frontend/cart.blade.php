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
                            <li>Cart</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- cart-area-s2 start -->
    <div class="cart-area-s2 section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="single-page-title">
                        <h2>Your Cart</h2>
                        <p>There are 4 products in this list</p>
                    </div>
                </div>
            </div>
            <div class="cart-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            <div class="cart-item">
                                <table class="table-responsive cart-wrap">
                                    <thead>
                                        <tr>
                                            <th class="images images-b">Product</th>
                                            <th class="ptice">Price</th>
                                            <th class="stock">Quantity</th>
                                            <th class="ptice total">Subtotal</th>
                                            <th class="remove remove-b">Remove</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $sub = 0;
                                    @endphp
                                    <tbody>
                                        @foreach ($carts as $cart)
                                            <tr class="wishlist-item">
                                                <td class="product-item-wish">
                                                    <div class="check-box"><input type="checkbox"
                                                            class="myproject-checkbox">
                                                    </div>
                                                    <div class="images">
                                                        <span>
                                                            <img src="{{ asset('uploads/product/preview') }}/{{ $cart->rel_to_product->preview }}"
                                                                alt="">
                                                        </span>
                                                    </div>
                                                    <div class="product">
                                                        <ul>
                                                            <li title="{{ $cart->rel_to_product->product_name }}"
                                                                class="first-cart">
                                                                {{ Str::substr($cart->rel_to_product->product_name, 0, 10) . '...' }}
                                                            </li>
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
                                                <td class="ptice getcart">
                                                    &#2547;{{ $cart->rel_to_product->after_product_discount }}</td>
                                                <td class="td-quantity getcart">
                                                    <div class="quantity">
                                                        <input name="quantity[{{ $cart->id }}]" class="quan text-value" type="text"
                                                            value="{{ $cart->quantity }}">
                                                        <div data-price="{{ $cart->rel_to_product->after_product_discount }}"
                                                            class="dec qtybutton">-</div>
                                                        <div data-price="{{ $cart->rel_to_product->after_product_discount }}"
                                                            class="inc qtybutton">+</div>
                                                    </div>
                                                </td>
                                                <td class="ptice getcart">
                                                    &#2547;<span>{{ $cart->rel_to_product->after_product_discount * $cart->quantity }}</span>
                                                </td>
                                                <td class="action">
                                                    <ul>
                                                        <li class="w-btn"><a data-bs-toggle="tooltip" data-bs-html="true"
                                                                title="" href="{{ route('cart.remove', $cart->id) }}"
                                                                data-bs-original-title="Remove from Cart"
                                                                aria-label="Remove from Cart"><i
                                                                    class="fi ti-trash"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @php
                                                $sub += $cart->rel_to_product->after_product_discount * $cart->quantity;
                                            @endphp
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                            <div class="cart-action">
                                <button type="submit" class="theme-btn-s2"><i class="fi flaticon-refresh"></i> Update
                                    Cart</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="cart-total-wrap">
                            <h3>Cart Totals</h3>
                            @if ($msg)
                                <div class="alert alert-danger">{{ $msg }}</div>
                            @endif
                            <form action="{{ route('cart') }}" method="get">
                                <div class="apply-area my-5">
                                    <input type="text" class="form-control" name="coupon" placeholder="Enter your coupon" value="{{ @$_GET['coupon'] }}">
                                    <button class="theme-btn-s2" type="submit" >Apply</button>
                                </div>
                            </form>
                            @php
                                if ($type == 1) {
                                    $discount_final = $sub*$discount/100;
                                    $total = round($sub - $discount_final);
                                }else {
                                    $discount_final = $discount;
                                    $total = round($sub -$discount_final);
                                }
                            @endphp
                            <div class="sub-total">
                                <h4>Subtotal</h4>
                                <span>&#2547;{{ $sub }}</span>
                            </div>
                            <div class="sub-total my-3">
                                <h4>Discount</h4>
                                <span>&#2547;{{ round($discount_final) }}</span>
                            </div>
                            <div class="total mb-3">
                                <h4>Total</h4>
                                <span>&#2547;{{ $total }}</span>
                            </div>
                            @php
                                session([
                                    'discount'=>$discount_final,
                                    'total'=>$total,
                                    'sub_total'=>$sub,
                                ])
                            @endphp
                            <a class="theme-btn-s2" href="{{ route('checkout') }}">Proceed To CheckOut</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cart-prodact">
                <h2>You May be Interested in…</h2>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="product-item">
                            <div class="image">
                                <img src="assets/images/interest-product/1.png" alt="">
                                <div class="tag new">New</div>
                            </div>
                            <div class="text">
                                <h2><a href="product-single.html">Wireless Headphones</a></h2>
                                <div class="rating-product">
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <span>130</span>
                                </div>
                                <div class="price">
                                    <span class="present-price">$120.00</span>
                                    <del class="old-price">$200.00</del>
                                </div>
                                <div class="shop-btn">
                                    <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="product-item">
                            <div class="image">
                                <img src="assets/images/interest-product/2.png" alt="">
                                <div class="tag sale">Sale</div>
                            </div>
                            <div class="text">
                                <h2><a href="product-single.html">Blue Bag with Lock</a></h2>
                                <div class="rating-product">
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <span>120</span>
                                </div>
                                <div class="price">
                                    <span class="present-price">$160.00</span>
                                    <del class="old-price">$190.00</del>
                                </div>
                                <div class="shop-btn">
                                    <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="product-item">
                            <div class="image">
                                <img src="assets/images/interest-product/3.png" alt="">
                                <div class="tag new">New</div>
                            </div>
                            <div class="text">
                                <h2><a href="product-single.html">Stylish Pink Top</a></h2>
                                <div class="rating-product">
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <span>150</span>
                                </div>
                                <div class="price">
                                    <span class="present-price">$150.00</span>
                                    <del class="old-price">$200.00</del>
                                </div>
                                <div class="shop-btn">
                                    <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="product-item">
                            <div class="image">
                                <img src="assets/images/interest-product/4.png" alt="">
                                <div class="tag sale">Sale</div>
                            </div>
                            <div class="text">
                                <h2><a href="product-single.html">Brown Com Boots</a></h2>
                                <div class="rating-product">
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <span>120</span>
                                </div>
                                <div class="price">
                                    <span class="present-price">$120.00</span>
                                    <del class="old-price">$150.00</del>
                                </div>
                                <div class="shop-btn">
                                    <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart-area end -->
@endsection
@section('footer_script')
    <script>
        var td = document.getElementsByClassName('getcart');
        var array = Array.from(td);
        console.log(array);
        array.map((item) => {
            item.addEventListener('click', function(e) {
                if (e.target.className == 'inc qtybutton') {
                    var price = e.target.dataset.price;
                    var quantity = e.target.parentElement.firstElementChild.value;
                    var sub = price * quantity;
                    item.nextElementSibling.firstElementChild.innerHTML = sub;
                }
                if (e.target.className == 'dec qtybutton') {
                    var price = e.target.dataset.price;
                    var quantity = e.target.parentElement.firstElementChild.value;
                    var sub = price * quantity;
                    item.nextElementSibling.firstElementChild.innerHTML = sub;
                }
            })
        })
    </script>
@endsection
