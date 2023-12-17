@extends('layouts.admin')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3>FAQ list</h3>
            <a href="{{ route('faq.create') }}" class="badge bg-primary text-light">Add new faq</a>
        </div>
        <div class="card-body">
            <table class="table table-bodered">
                <tr>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>
                @foreach ($faqs as $faq)
                <tr>
                    <td>{{ $faq->question }}</td>
                    <td>{{ Str::substr($faq->answer, 0, 100).'...' }}</td>
                    <td>
                        <a href="{{ route('faq.show',$faq->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('faq.edit',$faq->id) }}" class="btn btn-primary my-2">Edit</a>
                        <form action="{{ route('faq.destroy',$faq->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>    
                @endforeach               
            </table>
        </div>
    </div>
</div>
@endsection