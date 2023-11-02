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
                            <li>Customer order</li>
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
                        <img class="m-auto pt-3"
                            src="{{ Avatar::create(Auth::guard('customer')->user()->fname)->toBase64() }}" width="70px">
                    @else
                        <img class="m-auto pt-3"
                            src="{{ asset('uploads/customer') }}/{{ Auth::guard('customer')->user()->photo }}"
                            width="70px">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ Auth::guard('customer')->user()->fname . ' ' . Auth::guard('customer')->user()->lname }}</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-light"><a class="text-dark"
                                href="{{ route('customer.profile') }}">Update Profile</a></li>
                        <li class="list-group-item bg-light">My Order</li>
                        <li class="list-group-item bg-light">Wish List</li>
                        <li class="list-group-item bg-light"><a class="text-dark"
                                href="{{ route('customer.logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 my-5">
                <div class="card">
                    <div class="card-header py-3">
                        <h3>Order Information</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Order ID</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                            @foreach ($myorders as $sl => $myorder)
                                <tr>
                                    <td>{{ $myorders->firstitem() + $sl }}</td>
                                    <td>{{ $myorder->order_id }}</td>
                                    <td>{{ $myorder->total }}</td>
                                    <td>
                                        @if ($myorder->status == 0)
                                            <span class="badge bg-secondary">Placed</span>
                                        @elseif ($myorder->status == 1)
                                            <span class="badge bg-info">Processing</span>
                                        @elseif ($myorder->status == 2)
                                            <span class="badge bg-primary">Shipped</span>
                                        @elseif ($myorder->status == 3)
                                            <span class="badge bg-warning">Ready to Deliver</span>
                                        @elseif ($myorder->status == 4)
                                            <span class="badge bg-success">Received</span>
                                        @elseif ($myorder->status == 5)
                                            <span class="badge bg-danger">Cancel</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($myorder->status != 5)
                                            <a href="{{ route('cancel.order', $myorder->id) }}"
                                                class="btn btn-danger">Cancel order</a>
                                            <a href="{{ route('order.invoice.download', $myorder->id) }}"
                                                class="btn btn-success">Download Invoice</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $myorders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
