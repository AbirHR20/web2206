@extends('layouts.admin')
@section('content')
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Edit Category</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('category.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="mb-3">
                        <input type="hidden" name="category_id" value="{{ $category_info->id }}">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control" value="{{ $category_info->category_name }}">
                        @error('category_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category_img" class="form-label">Category Image</label>
                        <input type="file" name="category_img" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        @error('category_img')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="my-2">
                        <img src="{{ asset('uploads/category') }}/{{ $category_info->category_img }}" alt="" width="100px" id="blah">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection