@extends('layouts.admin')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header f-flex justify-content-between">
                <h3>Order list</h3>
                <a class="btn btn-info" href="{{ route('order.cancel.request') }}">Order Cancel Request</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Order id</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Charge</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->rel_to_customer->fname . ' ' . $order->rel_to_customer->lname }}</td>
                            <td>{{ $order->total }}</td>
                            <td>{{ $order->discount }}</td>
                            <td>{{ $order->charge }}</td>
                            <td>
                                @if ($order->status == 0)
                                    <span class="badge bg-secondary text-light">Placed</span>
                                @elseif ($order->status == 1)
                                    <span class="badge bg-info text-light">Processing</span>
                                @elseif ($order->status == 2)
                                    <span class="badge bg-primary text-light">Shipped</span>
                                @elseif ($order->status == 3)
                                    <span class="badge bg-warning text-light">Out for delevery</span>
                                @elseif ($order->status == 4)
                                    <span class="badge bg-success text-light">Delevered</span>
                                @elseif ($order->status == 5)
                                    <span class="badge bg-warning text-light">Cancel</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('order.status.update') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle" type="button"
                                            data-toggle="dropdown" aria-expanded="false">
                                            Change status
                                        </button>
                                        <div class="dropdown-menu">
                                            <button name="status" class="dropdown-item" style="color: {{ $order->status == 0 ? 'blue' : '' }}"
                                                value="0">Placed</button>
                                            <button name="status" class="dropdown-item" style="color: {{ $order->status == 1 ? 'blue' : '' }}"
                                                value="1">Processing
                                            </button>
                                            <button name="status" class="dropdown-item" style="color: {{ $order->status == 2 ? 'blue' : '' }}"
                                                value="2">Shipped</button>
                                            <button name="status" class="dropdown-item" style="color: {{ $order->status == 3 ? 'blue' : '' }}"
                                                value="3">Out for delevery
                                            </button>
                                            <button name="status" class="dropdown-item" style="color: {{ $order->status == 4 ? 'blue' : '' }}"
                                                value="4">Delevered
                                            </button>
                                            <button name="status" class="dropdown-item" style="color: {{ $order->status == 5 ? 'blue' : '' }}"
                                                value="5">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
