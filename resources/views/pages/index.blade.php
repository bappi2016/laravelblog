@extends('layouts.app')

@section('content')

<div class="jumbotron text-center">
    <h1>Welcome To My Blog</h1>
    <p>Laravel Application Built with Laravel 6.2 and Bootstrap</p>
    <p> 
        <a href="/login" class="btn btn-primary btn-lg" role="button">Login</a>

        <a href="/register" class="btn btn-success btn-lg" role="button">Register</a>
    </p>
</div>

@endsection('content')