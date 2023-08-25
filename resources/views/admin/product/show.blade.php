@extends('layouts.admin')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Product Details</h3>
                <a href="{{ route('product.list') }}" class="btn btn-primary"><i class="fa fa-list"></i> Product List</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td>Product Name</td>
                        <td>{{ $product->product_name }}</td>
                    </tr>
                    <tr>
                        <td>Product Price</td>
                        <td>{{ $product->product_price }}</td>
                    </tr>
                    <tr>
                        <td>Short Description</td>
                        <td>{{ $product->short_desp }}</td>
                    </tr>
                    <tr>
                        <td>Long Description</td>
                        <td>{!! $product->long_desp !!}</td>
                    </tr>
                    <tr>
                        <td>Additional Info</td>
                        <td>{!! $product->add_info !!}</td>
                    </tr>
                    <tr>
                        <td>Preview</td>
                        <td>
                            <img src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" alt="" width="100px">
                        </td>
                    </tr>
                    <tr>
                        <td>Gallery</td>
                        <td>
                            @foreach ($galleries as $gallery)
                            <img src="{{ asset('uploads/product/gallery') }}/{{ $gallery->gallery }}" alt="" width="200px">
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection