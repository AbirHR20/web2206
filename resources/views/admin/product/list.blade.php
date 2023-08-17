@extends('layouts.admin')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Product List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>After Discount</th>
                        <th>Brand</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->rel_to_cate->category_name }}</td>
                            <td>{{ $product->rel_to_subcate->subcategory_name }}</td>
                            <td>{{ $product->rel_to_brand->brand_name }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->product_price }}</td>
                            <td>{{ $product->product_discount }}</td>
                            <td>{{ $product->after_product_discount }}</td>
                            <td>
                                <img src="{{ asset('uploads/product/preview') }}/{{ $product->preview }} " alt=""
                                    width="100px">
                            </td>
                            <td><a href="" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
@endsection
