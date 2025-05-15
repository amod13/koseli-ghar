<!-- resources/views/errors/404.blade.php -->

@extends('layouts.app') <!-- Use your main layout if available -->

@section('title', '404 Not Found')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 bg-light">
    <div class="text-center">
        <h1 class="display-1 fw-bold text-warning">404</h1>
        <p class="fs-3"><span class="text-danger">Oops!</span> Page not found.</p>
        <p class="lead">The page you are looking for might have been removed or is temporarily unavailable.</p>
        <a href="{{ url('/') }}" class="btn btn-primary px-4 py-2">Go to Homepage</a>
    </div>
</div>
@endsection
