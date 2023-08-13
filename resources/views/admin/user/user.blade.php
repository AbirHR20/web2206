@extends('layouts.admin')
@section('content')
<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h3>Update Profile Information</h3>
        </div>
        <div class="card-body">
            <form action="{{route('user.name.update')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="name" value="{{Auth::user()->name}}">
                    @error('name')
                        <strong class="text-danger">{{$message}}</strong>

                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="email" value="{{Auth::user()->email}}">
                    @error('email')
                        <strong class="text-danger">{{$message}}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h3>Update Password</h3>
        </div>
        @if(session('pass_update'))
        <div class="alert alert-success">{{session('pass_update')}}</div>
        @endif
        <div class="card-body">
            <form action="{{route('user.pass.update')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="current_password">Current Password</label>
                    <input type="password" class="form-control" name="current_password">
                    @error('current_password')
                        <strong class="text-danger">{{$message}}</strong>
                    @enderror
                    @if(session('current_pass'))
                        <strong class="text-danger">{{session('current_pass')}}</strong>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" name="password">
                    @error('password')
                        <strong class="text-danger">{{$message}}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                    @error('password_confirmation')
                        <strong class="text-danger">{{$message}}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h3>Update Profile Photo</h3>
        </div>
        @if(session('photo_update'))
        <div class="alert alert-success">{{session('photo_update')}}</div>
        @endif
        <div class="card-body">
            <form action="{{route('user.photo.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="photo">Upload Photo</label>
                    <input type="file" class="form-control" name="photo" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                    <span>(min width:200px and min height:300px)</span>
                    <div class="mt-2">
                    <img src="" width="200" id="blah" alt="">
                    </div>
                    @error('photo')
                        <strong class="text-danger">{{$message}}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
