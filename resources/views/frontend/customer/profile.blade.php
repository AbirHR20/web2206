@extends('frontend.master')
@section('content')
    <!-- start wpo-page-title -->
    <section class="wpo-page-title">
        <h2 class="d-none">Hide</h2>
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="wpo-breadcumb-wrap">
                        <ol class="wpo-breadcumb-wrap">
                            <li><a href="index.html">Home</a></li>
                            <li>Customer Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end page-title -->
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="card my-5 text-center" style="width: 18rem;">
                    @if (Auth::guard('customer')->user()->photo == null)
                        <img class="m-auto pt-3" src="{{ Avatar::create(Auth::guard('customer')->user()->fname)->toBase64() }}" width="70px">
                    @else
                        <img class="m-auto pt-3" src="{{ asset('uploads/customer') }}/{{ Auth::guard('customer')->user()->photo }}"
                            width="70px">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ Auth::guard('customer')->user()->fname . ' ' . Auth::guard('customer')->user()->lname }}</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-light">Update Profile</li>
                        <li class="list-group-item bg-light">My Order</li>
                        <li class="list-group-item bg-light">Wish List</li>
                        <li class="list-group-item bg-light"><a class="text-dark" href="{{ route('customer.logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 my-5">
                <div class="card">
                    <div class="card-header py-3">
                        <h3>Update Profile Information</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer.profile.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                <div class="col-lg-6">                                   
                                    <div class="mb-3">
                                        <label for="" class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="fname" id="" value="{{ Auth::guard('customer')->user()->fname }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">                                   
                                    <div class="mb-3">
                                        <label for="" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="lname" id="" value="{{ Auth::guard('customer')->user()->lname }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">                                   
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="" value="{{ Auth::guard('customer')->user()->email }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">                                   
                                    <div class="mb-3">
                                        <label for="" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="">
                                    </div>
                                </div>
                                <div class="col-lg-6">                                   
                                    <div class="mb-3">
                                        <label for="" class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="phone" id="" value="{{ Auth::guard('customer')->user()->phone }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">                                   
                                    <div class="mb-3">
                                        <label for="" class="form-label">Country</label>
                                        <input type="text" class="form-control" name="country" id="" value="{{ Auth::guard('customer')->user()->country }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">                                   
                                    <div class="mb-3">
                                        <label for="" class="form-label">Zip</label>
                                        <input type="number" class="form-control" name="zip" id="" value="{{ Auth::guard('customer')->user()->zip }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">                                   
                                    <div class="mb-3">
                                        <label for="" class="form-label">Image</label>
                                        <input type="file" class="form-control" name="image" id="">
                                    </div>
                                </div>
                                <div class="col-lg-12">                                   
                                    <div class="mb-3">
                                        <label for="" class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address" id="" value="{{ Auth::guard('customer')->user()->address }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">                                   
                                    <div class="mb-3 text-center">
                                        <button class="btn btn-primary" type="submit">Update Profile</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
