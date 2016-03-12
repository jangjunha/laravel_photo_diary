@extends('layout')

@section('container')
    <ul class="photos row">
        @foreach ($photos as $photo)
        <li class="col-lg-3 col-md-3 col-md-4 col-xs-6">
            <a href="{{ route('photos::view', ['photo' => $photo]) }}" class="card">
                <div class="image-box" style="background-image: url('{{ $photo->image }}')"></div>
                <div class="info">
                    <h2>{{ $photo->title }}</h2>
                    <p class="description">{{ $photo->description }}</p>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
@endsection
