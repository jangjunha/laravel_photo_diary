@extends('layout')

@section('container')
    <h1>{{ $photo->title }}</h1>

    <div class="detail">
        <div class="img_wrapper"><img src="{{ $photo->image }}"></div>
        <p class="description">{{ $photo->description }}</p>
    </div>

@endsection
