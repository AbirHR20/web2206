@extends('layouts.admin')
@section('content')
<div class="col-lg-8 m-auto">
    <div class="card">
        <div class="card-header">
            <h3>Edit role</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('role_added'))
                <div class="alert alert-success">{{ session('role_added') }}</div>
            @endif
            <form action="{{ route('update.role',$role->id) }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Role name</label>
                    <input type="text" name="role_name" class="form-control" value="{{ $role->name }}">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Permission</label>
                    <div class="form-group">
                        @foreach ($permissions as $permission)
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" name="permission[]" class="form-check-input" value="{{ $permission->name }}"{{ $role->hasPermissionTo($permission->name)?'checked':'' }}>{{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Edit role</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection