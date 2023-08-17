@extends('layouts.admin')
@section('content')
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Edit Brand</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('brand.update',$brand->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Brand Name</label>
                        <input type="text" name="brand_name" class="form-control" value="{{ $brand->brand_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Brand Logo</label>
                        <input type="file" name="brand_logo" class="form-control"   onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                    <div class="my-2">
                        <img src="{{ asset('uploads/brand') }}/{{ $brand->brand_logo }}" alt="" width="100px" id="blah">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
