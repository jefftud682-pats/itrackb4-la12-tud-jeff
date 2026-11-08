@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
    <h1>Something went wrong</h1>

    <p>We could not complete your request. Please try again later.</p>

    <a href="{{ route('movies.index') }}">Back to the Movie List</a>
@endsection