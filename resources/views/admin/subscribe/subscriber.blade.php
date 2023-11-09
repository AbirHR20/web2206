@extends('layouts.admin')
@section('content')
@can('subscribe_access')
<div class="col-lg-10 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Subscriber List</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($subscribers as $sl => $subscriber)
                        <tr>
                            <td>{{ $sl + 1 }}</td>
                            <td>{{ $subscriber->email }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('send.newsletter',$subscriber->id) }}">Send Newsletter</a>
                                <a class="btn btn-danger" href="">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @else
    <h3 class="text-danger">You don't have access to view this page.</h3>    
@endcan   
@endsection
