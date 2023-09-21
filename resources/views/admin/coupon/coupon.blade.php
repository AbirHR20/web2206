@extends('layouts.admin');
@section('content')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Coupon List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Coupon</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Validity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($coupons as $sl => $coupon)
                        <tr>
                            <td>{{ $sl + 1 }}</td>
                            <td>{{ $coupon->coupon }}</td>
                            <td>{{ $coupon->type == 1 ? 'percentage' : 'solid' }}</td>
                            <td>{{ $coupon->amount }} {{ $coupon->type == 1 ? '%' : 'tk' }}</td>
                            <td>
                                @if (Carbon\Carbon::now() > $coupon->validity)
                                    <span class="badge bg-warning text-light">Expired</span>
                                @else
                                    <span
                                        class="badge bg-success text-light">{{ Carbon\Carbon::now()->diffInDays($coupon->validity, false) }}
                                        days left</span>
                                @endif
                            </td>
                            <td>
                                <input data-id="{{ $coupon->id }}" {{ $coupon->status == 1 ? 'checked' : '' }}
                                    class="check" type="checkbox" data-toggle="toggle" data-size="sm"
                                    value="{{ $coupon->status }}">
                            </td>
                            <td><a title="delete" href="{{ route('coupon.delete',$coupon->id) }}"
                                class="btn btn-danger shadow "><i class="fa fa-trash"></i></a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add new coupon</h3>
            </div>
            <div class="card-body">
                @if (session('coupon'))
                    <div class="alert alert-success">{{ session('coupon') }}</div>
                @endif
                <form action="{{ route('coupon.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Coupon Name</label>
                        <input name="coupon" type="text" class="form-control">
                        @error('coupon')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Coupon Type</label>
                        <select name="type" id="" class="form-control">
                            <option value="">select coupon type</option>
                            <option value="1">percentage</option>
                            <option value="2">solid amount</option>
                        </select>
                        @error('type')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Coupon Amount</label>
                        <input name="amount" type="number" class="form-control">
                        @error('amount')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Coupon Limit</label>
                        <input name="limit" type="number" class="form-control">
                        @error('limit')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Coupon Validity</label>
                        <input type="date" name="validity" id="" class="form-control">
                        @error('validity')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer_script')
    <script>
        $('.check').change(function() {
            if ($(this).val() == 1) {
                $(this).attr('value', 0)
            } else {
                $(this).attr('value', 1)
            }
            var status = $(this).val();
            var coupon_id = $(this).attr('data-id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '/couponChangeStatus',
                data: {
                    'coupon_id': coupon_id,
                    'status': status,
                },
                success: function(data) {

                }
            });
        })
    </script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
@endsection
