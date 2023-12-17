@extends('layouts.admin')
@section('content')
<div class="col-lg-8 m-auto">
    <div class="card-header">
        <h3>Add new faq</h3>
        <a href="{{ route('faq.index') }}" class="badge bg-primary text-light">Faq List</a>
    </div>
    <div class="card-body">
        <form action="{{ route('faq.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Question</label>
                <input type="text" name="question" id="" class="form-control">
                @error('question')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Answer</label>
                <textarea name="answer" class="form-control"></textarea>
                @error('answer')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Add Faq</button>
            </div>
        </form>
    </div>
</div>
@endsection