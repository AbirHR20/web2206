@extends('layouts.admin')
@section('content')
@can('role_access')
<div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Role list</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Role name</th>
                        <th>Permission</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($roles as $sl=>$role)
                    <tr>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @foreach ($role->getPermissionNames() as $permission)
                                <span class="badge badge-secondary my-2" style="font-size: 13px">{{ $permission }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('edit.role',$role->id) }}" class="btn btn-primary my-2">Edit</a>
                            <a href="{{ route('delete.role',$role->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>    
                    @endforeach
                    
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>User list</h3>
            </div>
            <div class="card-body">
                @if (session('remove_role'))
                    <div class="alert alert-success">{{ session('remove_role') }}</div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>User name</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $sl=>$user)
                    <tr>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @forelse ($user->getRoleNames() as $role)
                                <span class="badge badge-info my-2" style="font-size: 13px">{{ $role }}</span>
                                @empty
                                Not assign!
                            @endforelse
                        </td>
                        <td>
                            <a href="{{ route('remove.user.role',$user->id) }}" class="btn btn-danger">Delete</a>
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
                <h3>Add new permission</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('permission.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Permission name</label>
                        <input type="text" name="permission_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add permission</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Add new role</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('role_added'))
                    <div class="alert alert-success">{{ session('role_added') }}</div>
                @endif
                <form action="{{ route('role.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-lebel">Role name</label>
                        <input type="text" name="role_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Permission</label>
                        <div class="form-group">
                            @foreach ($permissions as $permission)
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="permission[]" class="form-check-input" value="{{ $permission->name }}" checked="">{{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add role</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card" id="role-assign">
            <div class="card-header">
                <h3>Assign role</h3>
            </div>
            <div class="card-body">
                @if (session('role_assign'))
                    <div class="alert alert-success">{{ session('role_assign') }}</div>
                @endif
                <form action="{{ route('assign.role') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-lebel">User</label>
                        <select name="user_id" class="form-control">
                            <option value="">Select user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-lebel">Role</label>
                        <select name="role" class="form-control">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Assign role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <h3 class="text-danger">You don't have access to view this page.</h3>   
@endcan   
@endsection
