@extends('inc/layout')

@section('title')
Add Note
@endsection

@include('inc.errors')

@section('content')
    <form method="POST" action="{{route('notes.store')}}" >
    
        @csrf    
        <div class="mb-3">
            <textarea class="form-control" name="content"  rows="3" placeholder="content" value={{ old('content')}}></textarea>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </div>
    </form>
@endsection