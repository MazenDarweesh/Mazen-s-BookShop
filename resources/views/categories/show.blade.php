@extends('inc/layout')
{{-- //the section dealing with the views --}}
@section('content')
    
    <h1>category ID : {{$category->id}}</h1>
    <h3>{{$category->name}}</h3>

    <hr>

    <h3>Books:</h3>
    
    <ul>
        @foreach ($category->books as $book)
        <li>{{$book->title}}</li>
        @endforeach
    </ul>

    <a href="{{route('categories.index')}}">Back</a>

@endsection