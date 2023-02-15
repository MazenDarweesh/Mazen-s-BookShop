@extends('inc/layout')

@section('title')
Register
@endsection

@include('inc.errors')

@section('content')
    <form method="POST" action="{{route('auth.handleRegister')}}" >
    
        @csrf  {{-- 419 error if not found --}}  
        <div class="mb-3">
            <input type="text"  name="name" class="form-control"  placeholder="name" value={{ old('name')}}>
        </div>
    
        <div class="mb-3">
            <input type="text"  name="email" class="form-control"  placeholder="email" value={{ old('email')}}>
        </div>

        <div class="mb-3">
            <input type="password"  name="password" class="form-control"  placeholder="password" value={{ old('password')}}>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </div>
    </form>

    <a href="{{route('auth.github.redirect')}}" class="btn btn-success mb-3">Sign up with github</a>

@endsection