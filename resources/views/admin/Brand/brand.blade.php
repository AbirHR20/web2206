@extends('layouts.admin')
@section('content')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Brand List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sl no</th>
                        <th>Brand Name</th>
                        <th>Brand Logo</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($brand as $sl=>$brands)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $brands->brand_name }}</td>
                            <td><img src="{{ asset('uploads/brand/') }}/{{ $brands->brand_logo }}" width="50" alt=""></td>
                            <td>
                                <div class="d-flex">
                                    <a href=""
                                        class="btn btn-primary shadow btn-xs sharp mr-1"><i
                                            class="fa fa-pencil"></i></a>
                                    <a href="z"
                                        class="btn btn-danger shadow btn-xs sharp"><i
                                            class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Brand</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('brand.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Brand Name</label>
                        <input type="text" name="brand_name" class="form-control">
                        @error('brand_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Brand Logo</label>
                        <input type="file" name="brand_logo" class="form-control">
                        @error('brand_logo')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
