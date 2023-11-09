@extends('layouts.admin')
@section('content')
    @can('trash_category')
        <div class="col-lg-8">
            <form action="{{ route('restore.check') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Trash Category List</h4>
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
                                @forelse ($trash_category as $sl=>$category)
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="cate{{ $category->id }}" name="category_id[]"
                                                        value="{{ $category->id }}">
                                                    <label class="custom-control-label" for="cate{{ $category->id }}"></label>
                                                </div>
                                            </td>
                                            <td><strong>{{ $sl + 1 }}</strong></td>
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
                                                    <a title="restore" href="{{ route('category.restore', $category->id) }}"
                                                        class="btn btn-primary shadow btn-xs sharp mr-1"><i
                                                            class="fa fa-reply"></i></a>
                                                    <a title="delete" href="{{ route('category.hard.delete', $category->id) }}"
                                                        class="btn btn-danger shadow btn-xs sharp"><i
                                                            class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No trash found</td>
                                    </tr>
                                @endforelse

                            </table>
                            <button class="btn btn-info" type="submit">Restore Checked</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @else
        <h3 class="text-danger">You don't have access to view this page.</h3>
    @endcan

@endsection
@section('footer_script')
    <script>
        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
