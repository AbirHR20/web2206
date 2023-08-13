@extends('layouts.admin')
@section('content')
    <div class="col-lg-8">
        <form action="{{ route('delete.check') }}" method="post">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Category List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" id="checkAll">
                                            <label class="custom-control-label" for="checkAll">Check All</label>
                                        </div>
                                    </th>
                                    <th>Sl NO.</th>
                                    <th>Category Name</th>
                                    <th>Category Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($categories as $sl => $category)
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="cate{{ $category->id }}" name="category_id[]" value="{{ $category->id }}">
                                                <label class="custom-control-label" for="cate{{ $category->id }}"></label>
                                            </div>
                                        </td>
                                        <td><strong>{{ $categories->firstitem() + $sl }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center"> <span
                                                    class="w-space-no">{{ $category->category_name }}</span></div>
                                        </td>
                                        <td>
                                            <img src="{{ asset('uploads/category') }}/{{ $category->category_img }}"
                                                alt="" width="50px">
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('category.edit', $category->id) }}"
                                                    class="btn btn-primary shadow btn-xs sharp mr-1"><i
                                                        class="fa fa-pencil"></i></a>
                                                <a href="{{ route('category.soft.delete', $category->id) }}"
                                                    class="btn btn-danger shadow btn-xs sharp"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                        {{ $categories->links() }}
                        <button class="btn btn-danger" type="submit">Delete Checked</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add new Category</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control">
                        @error('category_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category_img" class="form-label">Category Image</label>
                        <input type="file" name="category_img" class="form-control">
                        @error('category_img')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer_script')
    <script>
        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
