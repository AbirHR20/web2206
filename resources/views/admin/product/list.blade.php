@extends('layouts.admin')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Product List</h3>
                <a href="{{ route('product') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Product</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Brand</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>After Discount</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($products as $sl => $product)
                        <tr>
                            <td>{{ $sl + 1 }}</td>
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
                            <td>
                                <div class="d-flex">
                                    <a title="admin inventory" href="{{ route('inventory', $product->id) }}"
                                        class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-archive"></i></a>
                                    <a title="view" href="{{ route('product.show', $product->id) }}"
                                        class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
                                    <a title="delete" href="{{ route('product.delete', $product->id) }}"
                                        class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
@endsection
