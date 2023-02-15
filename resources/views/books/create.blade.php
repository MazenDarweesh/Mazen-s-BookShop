@extends('inc/layout')

@section('title')
Create Book
@endsection

@include('inc.errors')

@section('content')

<?php $my_msg = "hello"; ?>

    
    <x-alert msg="creted ur book" type="success"></x-alert>
    <x-alert :msg="$my_msg" type="danger"></x-alert>
    <x-alert msg="this is anotttther" type="info"></x-alert>

    <form method="POST" action="{{route('books.store')}}" enctype="multipart/form-data">
    
        @csrf    
        <div class="mb-3">
            {{-- names as in the DB --}}
        <input type="text"  name="title" class="form-control"  placeholder="Title" value={{ old('title')}}>
        </div>
    
        <div class="mb-3">
            <textarea class="form-control" name="desc"  rows="3" placeholder="Description" value={{ old('desc')}}></textarea>
        </div>
        
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label" >Multiple files input </label>
            <input class="form-control" type="file"  name="img" multiple>
        </div>

        Select Categories: 
        @foreach ($categories as $category)      
            <div class="form-check">
            <input class="form-check-input" type="checkbox" name="category_ids[]" value="{{ $category->id }}" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
                {{ $category->name }}
            </label>
            </div>
        @endforeach

        <br>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </div>
    </form>
@endsection