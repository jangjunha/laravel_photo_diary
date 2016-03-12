@extends('layout')

@section('container')
    <h1>{{ $photo->title }}</h1>

    <img src="{{ $photo->image }}">

    <p class="description">{{ $photo->description }}</p>

@endsection
