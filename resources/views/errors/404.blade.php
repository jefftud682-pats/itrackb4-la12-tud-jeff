@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
    <h1>Page not found</h1>

    <p>The movie page you requested could not be found.</p>

    <a href="{{ route('movies.index') }}">Back to the list</a>
@endsection