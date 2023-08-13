@extends('layouts.admin')
@section('content')
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header">Edit Subcategory</div>
            <div class="card-body">
                @if (session('updated'))
                    <div class="alert alert-success">{{ session('updated') }}</div>
                @endif
                @if (session('exists'))
                    <div class="alert alert-danger">{{ session('exists') }}</div>
                @endif
                <form action="{{ route('subcategory.update',$subcategory->id) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <select name="category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option {{ $category->id == $subcategory->category_id?'selected':'' }} value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Sub Category Name</label>
                        <input type="text" name="subcategory_name" id="" class="form-control" value="{{ $subcategory->subcategory_name }}">
                        @error('subcategory_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
