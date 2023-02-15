@extends('inc/layout')

@section('title')
Create Category
@endsection

@include('inc.errors')

@section('content')
    <form method="POST" action="{{route('categories.store')}}" enctype="multipart/form-data">
    
        @csrf    
        <div class="mb-3">
            {{-- names as in the DB --}}
        <input type="text"  name="name" class="form-control"  placeholder="name" value={{ old('name')}}>
        </div>
    
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </div>
    </form>
@endsection