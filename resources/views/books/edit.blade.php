@extends('inc/layout')

@section('title')
Edit Book - {{$book->title}}
@endsection

@include('inc.errors')

@section('content')
    <form method="POST" action="{{route('books.update',$book->id)}}" enctype="multipart/form-data">
    
        @csrf    
        <div class="mb-3">
            {{-- names as in the DB --}}
        <input type="text"  name="title" class="form-control" placeholder="title" value="{{ old('title')?? $book->title}}">
        </div>
    
        <div class="mb-3">
            <textarea class="form-control" name="desc"  rows="3" placeholder="desc" >{{ old('desc')?? $book->desc}}</textarea>
        </div>

        <div class="mb-3">
            <label for="formFileMultiple" class="form-label" >Multiple files input </label>
            <input class="form-control" type="file"  name="img" multiple>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </div>
    </form>
@endsection