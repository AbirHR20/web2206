@extends('layouts.admin')
@section('content')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Tag list</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Tag name</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($tages as $sl => $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->tag }}</td>
                            <td><a href="{{ route('tag.remove',$tag->id) }}" class="btn btn-danger">Delete</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add new tags</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('tag.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label"></label>
                        <input type="text" name="tag" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add tag</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
