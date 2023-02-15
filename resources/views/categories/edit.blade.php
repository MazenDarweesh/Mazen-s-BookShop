@extends('inc/layout')

@section('title')
Edit Category - {{$category->name}}
@endsection

@include('inc.errors')

@section('content')
    <form method="POST" action="{{route('categories.update',$category->id)}}" enctype="multipart/form-data">
    
        @csrf    
        <div class="mb-3">
            {{-- names as in the DB --}}
        <input type="text"  name="name" class="form-control" placeholder="name" value="{{ old('name')?? $category->name}}">
        </div>
    
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </div>
    </form>
@endsection