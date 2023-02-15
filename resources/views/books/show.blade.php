@extends('inc/layout')
{{-- //the section dealing with the views --}}
@section('content')
    
    <h1>Book ID : {{$book->id}}</h1>
    <h3>{{$book->title}}</h3>
    <p>{{$book->desc}}</p>

    <hr>

    <h3>Categories:</h3>
    
    <ul>
        @foreach ($book->categories as $category)
        <li>{{$category->name}}</li>
        @endforeach
    </ul>
    <a href="{{route('books.index')}}">Back</a>

@endsection